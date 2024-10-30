<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\client\WpRestfulClient;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\StepConstant;
use MoredealAiWriter\code\consts\StepTypeConstant;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\scene\WPAdminSceneModule;
use MoredealAiWriter\code\modules\scene\WPAdminTemplateMarketSceneModule;
use MoredealAiWriter\code\modules\step\response\AbstractResponseModule;
use MoredealAiWriter\code\modules\step\response\EmptyResponseModule;
use MoredealAiWriter\code\modules\util\FileConvertUtil;
use MoredealAiWriter\code\modules\util\LogUtil;

/**
 * Open API 执行步骤
 *
 * @author MoredealAiWriter
 */
class  UrlSaveStepModule extends AbstractStepModule {

    /**
     * 获取对象时候使用
     *
     * @param $object
     *
     * @return mixed
     * @throws Exception
     */
    public static function factoryObject( $object ) {
        return parent::factoryObject( $object );
    }

    /**
     * 初始化配置
     *
     * @return void
     */
    protected function initConfig() {
        $this->name         = Plugin::translation('Save Url');
        $this->desc         = Plugin::translation('Download and save the URL to your media library.');
        $this->source       = StepConstant::SOURCE_NATIVE()->getValue();
        $this->sourceUrl    = "";
        $this->type         = StepTypeConstant::TYPE_ADAPTER()->getValue();
        $this->tags         = array( 'WordPress', 'Save Url' );
        $this->isAuto       = false;
        $this->isCanAddStep = false;
        $this->icon         = Plugin::plugin_res() . '/images/url.svg';
        $this->variables    = array();
        $this->scenes       = array( WPAdminSceneModule::of(), WPAdminTemplateMarketSceneModule::of() );
        $this->response     = EmptyResponseModule::defResponse();
    }

    /**
     * @throws Exception
     */
    public function execute( AbstractContextModule $context ): AbstractResponseModule {

        $val         = $context->getPreStepResponseValue( $context->getStepField() );
        $model_price = LogUtil::build_model_price( 'image_url_save' );

        //获取图片
        $files = FileConvertUtil::decode( $val );

        //保存图片
        if ( empty( $files ) ) {
            $this->response->error( "images is empty" );
            $this->response->setProcessParams( LogUtil::build_process( $context, $files, array(), $this->response->status, $model_price ) );

            return $this->response;
        }

        $messages = array();
        $links    = array();
        foreach ( $files as $file ) {
            /**
             * 'jpg|jpeg|jpe'                 => 'image/jpeg',
             * 'gif'                          => 'image/gif',
             * 'png'                          => 'image/png',
             */
            $name = $file->fileName ?? '';
            if ( empty( $file->url ) ) {
                $messages[] = $name . 'image url is empty';
            }
            $result = WpRestfulClient::getInstance()->save_image_media( $file->url, 0, $file->fileName );
            if ( ! $result['success'] ) {
                $messages[] = $name . $result['message'] ?? 'save image error';
            }
            $links[] = $result['data'];
        }

        $res = array(
            'data'    => $links,
            'message' => implode( ',', $messages )
        );
        // 获取当前网站媒体库地址
        $media_link = get_site_url() . '/wp-admin/upload.php';
        // 全部上传失败
        if ( count( $messages ) == count( $files ) ) {
            $this->response->error( implode( ',', $messages ) );
            $this->response->setProcessParams( LogUtil::build_process( $context, $files, $res, $this->response->status, $model_price ) );

            return $this->response;
        }

        // 有部分上传成功
        if ( count( $messages ) > 0 ) {
            $this->response->success( $media_link, implode( ',', $messages ) );
            $this->response->setProcessParams( LogUtil::build_process( $context, $files, $res, $this->response->status, $model_price ) );

            return $this->response;
        }

        // 全部上传成功
        $this->response->success( $media_link, 'save image success' );
        $this->response->setProcessParams( LogUtil::build_process( $context, $files, $res, $this->response->status, $model_price ) );

        return $this->response;
    }


}