<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\StepConstant;
use MoredealAiWriter\code\consts\StepTypeConstant;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\scene\WPAdminSceneModule;
use MoredealAiWriter\code\modules\scene\WPAdminTemplateMarketSceneModule;
use MoredealAiWriter\code\modules\step\response\AbstractResponseModule;
use MoredealAiWriter\code\modules\step\response\EmptyResponseModule;
use MoredealAiWriter\code\modules\util\LogUtil;

/**
 * Open API 执行步骤
 *
 * @author MoredealAiWriter
 */
class Base64SaveStepModule extends AbstractStepModule {

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
        $this->name         = Plugin::translation('Save Images');
        $this->desc         = Plugin::translation('Save the image to your media library based on the Base64 image encoding you provide.');
        $this->source       = StepConstant::SOURCE_NATIVE()->getValue();
        $this->type         = StepTypeConstant::TYPE_ADAPTER()->getValue();
        $this->sourceUrl    = '';
        $this->tags         = array( 'WordPress', Plugin::translation('Save Images') );
        $this->isAuto       = false;
        $this->icon         = Plugin::plugin_res() . '/images/url.svg';
        $this->scenes       = array( WPAdminSceneModule::of(), WPAdminTemplateMarketSceneModule::of() );
        $this->variables    = array();
        $this->response     = EmptyResponseModule::defResponse();
        $this->isCanAddStep = false;
    }

    /**
     * 执行步骤，保存图片
     *
     * @throws Exception
     */
    public function execute( AbstractContextModule $context ): AbstractResponseModule {
        $value       = $context->getPreStepResponseValue( $context->getStepField() );
        $model_price = LogUtil::build_model_price( 'image_base64_save' );

        if ( is_string( $value ) ) {
            $value = json_decode( $value, true );
        }
        if ( is_object( $value ) ) {
            $value = (array) $value;
        }

        if ( empty( $value ) ) {
            $this->response->error( "images is empty" );
            $this->response->setProcessParams( LogUtil::build_process( $context, $value, array(), $this->response->status, $model_price ) );

            return $this->response;
        }

        $image_type  = 'image/png';
        $messages    = array();
        $attachments = array();

        foreach ( $value as $index => $data ) {
            // 检查是否已经存在
            if ( empty( $data ) || empty( $data['base64'] ) ) {
                $messages[ $index ] = "image {$index} is empty, skip, cant find base64 data";
                continue;
            }
            // base64解码
            $image_data = base64_decode( $data['base64'] );
            $image_name = $data['name'] ?? uniqid() . '.png';
            $upload_dir = wp_upload_dir();

            $upload_path = $upload_dir['path'] . '/' . $image_name;
            // 保存图片
            $put_result = file_put_contents( $upload_path, $image_data );
            if ( ! $put_result ) {
                $messages[ $index ] = "image {$index} save failed, skip";
                continue;
            }

            // 将文件添加到媒体库
            $attachment = array(
                'guid'           => $upload_dir['url'] . '/' . basename( $upload_path ),
                'post_mime_type' => $image_type,
                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload_path ) ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            $attach_id = wp_insert_attachment( $attachment, $upload_path );
            if ( is_wp_error( $attach_id ) ) {
                $messages[ $index ] = "image {$index} save failed, skip, " . $attach_id->get_error_message();
                continue;
            }
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            $attach_data = wp_generate_attachment_metadata( $attach_id, $upload_path );
            wp_update_attachment_metadata( $attach_id, $attach_data );
            $attachments[ $index ] = $attach_id;
        }

        $res = array(
            'attachments' => $attachments,
            'message'     => implode( ",", $messages )
        );

        // 获取当前网站媒体库地址
        $media_link = get_site_url() . '/wp-admin/upload.php';
        // 全部上传失败
        if ( count( $messages ) == count( $value ) ) {
            $this->response->error( implode( ',', $messages ) );
            $this->response->setProcessParams( LogUtil::build_process( $context, $value, $res, $this->response->status, $model_price ) );

            return $this->response;
        }

        // 有部分上传成功
        if ( count( $messages ) > 0 ) {
            $this->response->success( $media_link, implode( ',', $messages ) );
            $this->response->setProcessParams( LogUtil::build_process( $context, $value, $res, $this->response->status, $model_price ) );

            return $this->response;
        }

        $this->response->success( $media_link, 'save image success' );
        $this->response->setProcessParams( LogUtil::build_process( $context, $value, $res, $this->response->status, $model_price ) );

        return $this->response;
    }


}