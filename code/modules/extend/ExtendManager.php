<?php

namespace MoredealAiWriter\code\modules\extend;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\extend\LogExtend\LogExtend;
use MoredealAiWriter\code\extend\UseLimit\UseLimitExtend;
use MoredealAiWriter\code\modules\context\AbstractContextModule;

/**
 * Class ExtendManager
 *
 * @author MoredealAiWriter
 */
class ExtendManager {

    /**
     * @var array{AbstractBaseExtend}
     */
    private $_extends = [];

    /**
     * @var $_context AbstractContextModule
     */
    protected $_context;


    public function __construct() {

    }


    private function _sysExtends(): array {
        return [
            SceneExtend::class, //场景
            LogExtend::class, //日志
            UseLimitExtend::class // 用户限制
        ];
    }


    /**
     * @param AbstractContextModule $context
     *
     * @return
     */
    public static function _init( AbstractContextModule $context ) {

        $manager = new ExtendManager();

        $manager->_context = $context;

        //遍历增加的扩展
        foreach ( $manager->_sysExtends() as $extend ) {
            $var                 = $extend::new();
            $manager->_extends[] = $var;
        }

        $manager->_loadExtends();

        return $manager;

    }


    protected function _loadExtends() {

        //目录下文件

        //调用静态方法

        /**
         * @var $extend AbstractBaseExtend
         */
        foreach ( $this->_extends as $extend ) {

            $extend->initExtend( $this->_context );
        }

    }

}