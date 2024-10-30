<?php

namespace MoredealAiWriter\application\controller;

use Exception;
use MoredealAiWriter\application\admin\LicenseConfig;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\consts\ErrorConstant;
use MoredealAiWriter\application\models\TemplateDownloadModel;
use MoredealAiWriter\application\models\TemplateModel;
use MoredealAiWriter\application\Plugin;

class TemplateServiceModel {

    public function __construct() {
    }

    private static $instance = null;

    public static function getInstance(): TemplateServiceModel {

        self::$instance = new self;

        return self::$instance;
    }

    /**
     * 上传模版
     *
     * @param $params
     *
     * @return array
     * @throws Exception
     */
    public function submitTemplate( $params ): array {

        if ( ! isset( $params['id'] ) ) {
            throw new Exception( "The ID is required" );
        }

        if ( empty( $params['topics'] ) ) {
            throw new Exception( "The topics is required" );
        }

        $id            = $params['id'];
        $templateModel = TemplateModel::getInstance()->templateDetail( $id );

        $params['config']   = json_encode( $templateModel->info );
        $params['describe'] = $templateModel->desc;
        $params['free']     = true;
        $params['name']     = $templateModel->name;
        $params['tags']     = $templateModel->tags;
        $params['scenes']   = $templateModel->scenes;

        $key = $templateModel->temp_key;
        if ( empty( $key ) ) {
            $params['tempKey'] = $templateModel->type;
        } else {
            $params['tempKey'] = $templateModel->temp_key;
        }

        $params['pluginLevel']   = Plugin::plugin_level();
        $params['pluginVersion'] = Plugin::version();
        $result                  = SeastarRestfulClient::getInstance()->submitTemplate( $params );

        if ( ! isset( $result['success'] ) || ! $result['success'] ) {
            throw new Exception( $result['errorMessage'] ?? ErrorConstant::ACTION_MARKET_TEMPLATE_FAIL_MESSAGE );
        }

        // 保存返回template_id
        $data        = $result['data'];
        $template_id = $data["tempId"];
        if ( empty( $template_id ) ) {
            return $this->success( 200, 'submit success', 'The template submit success' );
        }

        $update_time = current_time( 'mysql' );

        $item = [
            'template_id' => $template_id,
            'update_time' => $update_time,
        ];

        $where = "id = " . $params['id'];

        $modify = TemplateModel::getInstance()->updateField( $item, $where );

        if ( ! $modify || $modify <= 0 ) {
            throw new Exception( "The template modify failed, place checked and try again!" );
        }

        return $this->success( 200, 'submit success', 'The template submit success' );

    }


    /**
     * 下载模板
     *
     * @param $template_id
     * @param $version
     *
     * @return array
     * @throws Exception
     */
    public function installTemplate( $template_id, $version ): array {

        $params = [
            "where" => "template_id = " . "'" . $template_id . "'"
        ];

        $exists = TemplateDownloadModel::getInstance()->exists( $params );
        if ( $exists ) {
            throw new Exception( "The template has been installed." );
        }

        $license_key = LicenseConfig::license_key();
        if ( empty( $license_key ) ) {
            throw new Exception( "Please install plug-ins." );
        }

        $user_plugin_level   = Plugin::plugin_level();
        $user_plugin_version = Plugin::version();

        $params = [
            "template_id"         => $template_id,
            "version"             => $version,
            "license_key"         => $license_key,
            "user_plugin_level"   => $user_plugin_level,
            "user_plugin_version" => $user_plugin_version
        ];

        $seastarRestfulClient = new SeastarRestfulClient();
        $response             = $seastarRestfulClient->installMarketTemplate( $params );
        if ( empty( $response ) ) {
            throw new Exception( "http client is error." );
        }

        $code    = $response["code"];
        $message = $response["message"];
        $data    = $response["data"];
        error_log( 'rest----------body : ' . $code );

        if ( $code == 500 ) {
            throw new Exception( $message );
        } else if ( $code == 302 ) {
            return $this->success( 302, str_replace( "\\", "-", $data ), 'Go to pay!' );
        } else {
            $templateInfoDO        = json_decode( $data, true );
            $templateDownloadModel = TemplateDownloadApiController::convert( $templateInfoDO );

            $i = $templateDownloadModel->insert( (array) $templateDownloadModel );

            if ( empty( $i ) || $i < 1 ) {
                throw new Exception( 'install error, db is error' );
            }

        }

        return $this->success( 200, 'install success', 'The template install success' );

    }


    public function success( $code, $data = null, string $message = '' ): array {
        return array(
            'code'    => $code,
            'message' => $message,
            'data'    => $data
        );
    }

}