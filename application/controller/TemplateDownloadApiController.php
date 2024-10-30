<?php

namespace MoredealAiWriter\application\controller;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\admin\GeneralConfig;
use MoredealAiWriter\application\models\TemplateDownloadModel;
use MoredealAiWriter\code\modules\template\TemplateFactory;
use WP_REST_Request;

class TemplateDownloadApiController extends AbstractApiController {

    protected function __construct() {
        parent::__construct();
    }

    public function model_name(): string {
        return "templateDownload";
    }

    /**
     * 注册路由
     * @return void
     */
    public function registerSearchRestRoute() {

        // 删除模版
        register_rest_route( $this->name_space(), '/delete', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'deleteTemplate' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 查看模板列表
         */
        register_rest_route( $this->name_space(), '/list', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'list' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 安装模板
         */
        register_rest_route( $this->name_space(), '/install', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'install' ),
            'permission_callback' => '__return_true',
        ) );

    }

    /**
     * 安装模板
     *
     * http://127.0.0.1:8084/wp-json/aigc/v1/templateDownload/install
     *
     * @throws Exception
     */
    public function install( WP_REST_Request $request ): array {
        $template_id = $request->get_param( "template_id" );
        $version     = $request->get_param( "version" );

        if ( empty( $template_id ) ) {
            error_log( "template_id is required." );
            throw new Exception( "template_id is required." );
        }

        if ( empty( $version ) ) {
            error_log( "version is required." );
            throw new Exception( "version is required." );
        }

        try {
            $success = TemplateServiceModel::getInstance()->installTemplate( $template_id, $version );

            return $this->_successCode( $success["code"], $success["message"], $success["data"] );

        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

    }

    public static function convert( $templateInfoDO ): TemplateDownloadModel {
        $templateDownloadModel                 = new TemplateDownloadModel();
        $templateDownloadModel->temp_key       = $templateInfoDO["tempKey"];
        $templateDownloadModel->template_id    = $templateInfoDO["tempId"];
        $templateDownloadModel->name           = $templateInfoDO["name"];
        $templateDownloadModel->modifier       = wp_get_current_user()->user_login;
        $templateDownloadModel->status         = $templateInfoDO["status"];
        $templateDownloadModel->icon           = $templateInfoDO["icon"];
        $templateDownloadModel->topics         = $templateInfoDO["topics"];
        $templateDownloadModel->tags           = $templateInfoDO["tags"];
        $templateDownloadModel->image_urls     = $templateInfoDO["imageUrls"];
        $templateDownloadModel->scenes         = $templateInfoDO["scenes"];
        $templateDownloadModel->version        = $templateInfoDO["version"];
        $templateDownloadModel->plugin_version = $templateInfoDO["pluginVersion"];
        $templateDownloadModel->plugin_level   = $templateInfoDO["pluginLevel"];
        $templateDownloadModel->cost           = $templateInfoDO["cost"];
        $templateDownloadModel->config         = $templateInfoDO["config"];
        $templateDownloadModel->desc           = $templateInfoDO["description"];
        $templateDownloadModel->gmt_create     = current_time( 'mysql' );;
        $templateDownloadModel->gmt_modified   = current_time( 'mysql' );;
        $templateDownloadModel->is_delete = $templateInfoDO["isDelete"];

        return $templateDownloadModel;
    }

    /**
     * 删除模版
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/templateDownload/delete
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function deleteTemplate( WP_REST_Request $request ): array {

        $templateId = $request->get_param( "templateId" );

        if ( ! isset( $templateId ) ) {
            return $this->_error( "The template id is required" );
        }

        $delete = TemplateDownloadModel::getInstance()->deleteByTemplateId( $templateId );
        if ( ! $delete || $delete <= 0 ) {
            return $this->_error( "The template delete failed, place checked and try again!" );
        }

        return $this->_successMessage( $delete, 'The template delete success' );

    }

    /**
     * 获取下载模板列表/推荐列表
     *
     * http://127.0.0.1:8084/wp-json/aigc/v1/templateDownload/list
     *
     * @param WP_REST_Request $request
     *
     * @return array|null
     * @throws Exception
     */
    public function list( WP_REST_Request $request ) {

        $sBody = $request->get_body();
        if ( empty( $sBody ) ) {
            $sBody = json_encode( array( "order" => "gmt_create" ) );
        }

        $params = json_decode( $sBody, true );
        if ( empty( $params ) ) {
            $params = [
                "order" => "gmt_create"
            ];
        }

        $user_template_permission = GeneralConfig::getUserTemplatePermission();

        // if ( $user_template_permission ) {
        //     $user_id   = wp_get_current_user()->ID;
        //     $user_name = wp_get_current_user()->user_login;
        //     if ( ! current_user_can( 'administrator', $user_id ) ) {
        //         $params['user_name'] = $user_name;
        //     }
        // }

        // 推荐模版
        $templateTypes = TemplateFactory::getTemplateRecommend();

        // 下载模板
        $templateDownloadList = TemplateDownloadModel::getInstance()->findList( $params, [] );

        return $this->_successCode( 200, [
            "template_recommend" => $templateTypes,
            "template_download"  => $templateDownloadList
        ], "query list is success" );

    }
}
