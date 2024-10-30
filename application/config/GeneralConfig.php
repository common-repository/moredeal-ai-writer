<?php

namespace MoredealAiWriter\application\config;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\modules\util\ModuleConvertUtil;

/**
 * 配置类
 *
 * @author MoredealAiWriter
 */
class GeneralConfig {

    const OPTION_NAME = 'moredeal_aigc_config';

    /**
     * Open Api Key
     *
     * @var string
     */
    public $api_key;

    /**
     * 实例
     *
     * @return GeneralConfig
     */
    public static function getInstance(): GeneralConfig {
        return new static();
    }

    /**
     * 获取所有配置
     *
     * @return GeneralConfig
     */
    public function getConfig(): GeneralConfig {
        $config = get_option( self::OPTION_NAME );
        if ( empty( $config ) ) {
            $config = new GeneralConfig();
        }
        if ( $config instanceof GeneralConfig ) {
            return $this->convert( $config );
        }
        if ( is_array( $config ) ) {
            $config = (object) $config;
        }

        return $this->convert( $config );
    }

    /**
     * 保存配置
     *
     * @param GeneralConfig $config
     *
     * @return bool
     */
    public function saveConfig( GeneralConfig $config ): bool {
        return update_option( self::OPTION_NAME, $config );
    }

    /**
     * 修改配置
     *
     * @param $data
     *
     * @return bool
     */
    public function updateConfig( $data ): bool {
        if ( empty( $data ) ) {
            return false;
        }
        if ( $data instanceof GeneralConfig ) {
            return $this->saveConfig( $data );
        }
        if ( is_array( $data ) ) {
            $data = (object) $data;
        }
        $config = $this->convert( $data );
        if ( empty( $config ) ) {
            return false;
        }

        return $this->saveConfig( $config );
    }

    /**
     * 获取 Open Api Key
     *
     * @return string
     */
    public function getApiKey(): string {
        $api_key = $this->getConfig()->api_key;
        if ( empty( $api_key ) ) {
            return '';
        }

        return $api_key;
    }

    /**
     * 将数据转换为 Config
     *
     * data 存在的值会覆盖 config 中的值，否则不变
     *
     * @param $data
     *
     * @return GeneralConfig
     */
    public function convert( $data ): GeneralConfig {
        $self = new self();
        if ( empty( $data ) ) {
            return $self;
        }
        if ( is_array( $data ) ) {
            $data = (object) $data;
        }
        $self = ModuleConvertUtil::convert( $self, $data );
        if ( ! empty( $self->api_key ) ) {
            $self->api_key = trim( $self->api_key );
        } else {
            $self->api_key = '';
        }

        return $self;
    }

}