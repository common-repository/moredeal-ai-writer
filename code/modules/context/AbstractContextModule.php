<?php

namespace MoredealAiWriter\code\modules\context;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\config\GeneralConfig;
use MoredealAiWriter\code\components\BaseModule;
use MoredealAiWriter\code\consts\EventCodeConst;
use MoredealAiWriter\code\modules\event\AbstractEventModule;
use MoredealAiWriter\code\modules\step\AbstractStepModule;
use MoredealAiWriter\code\modules\template\AbstractTemplateModule;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;

/**
 * Class AbstractContextModule
 *
 * @author MoredealAiWriter
 */
abstract class  AbstractContextModule extends BaseModule {

    const GLUE = ".";

    const KEY_STEP = "step";

    const KEY_STEP_RESPONSE = "_out";

    const KEY_GLOBAL = "global";

    /**
     * @var array{AbstractEventModule}
     */
    private $_events = [];

    /**
     * 参数变量
     *
     * @var array
     */
    private $_variableMap = [];

    /**
     * 模版
     *
     * @var AbstractTemplateModule
     */
    protected $template;

    /**
     * 执行场景，根据场景执行
     *
     * @var string
     */
    private $_sceneKey;

    /**
     * 执行的步骤，根据步骤来执行
     *
     * @var string
     */
    private $stepField;

    /**
     * 执行的实例 id
     *
     * @var
     */
    private $instanceId;

    private $isStream;

    /**
     * 根据步骤重新加载
     *
     * @param AbstractStepModule $step
     *
     * @return mixed
     */
    public abstract function reloadByStep( AbstractStepModule $step );

    /**
     * 构造函数
     *
     * @param AbstractTemplateModule $template
     */
    public function __construct( AbstractTemplateModule $template ) {
        $this->template = $template;
        parent::__construct();
    }

    /**
     * 初始化
     * @return void
     */
    public function init() {

    }

    /**
     * 生成 该对象
     *
     * @param $object
     *
     * @return AbstractContextModule
     */
    public static function factoryObject( $object ) {
        $self = self::new();

        return ModuleConvertUtil::convert( $self, $object );
    }

    /**
     * 生成 key
     *
     * @param $keys
     *
     * @return string
     */
    public static function generateKey( $keys ): string {

        return strtoupper( implode( static::GLUE, $keys ) );
    }

    /**
     * 获取模版
     *
     * @return AbstractTemplateModule
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * @param mixed $template
     *
     * @return AbstractContextModule
     */
    public function setTemplate( $template ): AbstractContextModule {
        $this->template = $template;

        return $this;
    }

    /**
     * 获取执行场景 key
     *
     * @return string
     */
    public function get_scene_key(): string {
        if ( $this->_sceneKey == null ) {
            return "";
        }

        return $this->_sceneKey;
    }

    /**
     * @param mixed $sceneKey
     *
     * @return BaseContextModule
     */
    public function set_scene_key( $sceneKey ): BaseContextModule {
        $this->_sceneKey = $sceneKey;

        return $this;
    }

    public function set_isstream( $isStream ): BaseContextModule {
        $this->isStream = $isStream;
        return $this;
    }

    public function get_isstream():string {
        return $this->isStream ;
    }

    /**
     * 获取 要执行的步骤
     * @return string
     */
    public function getStepField() {
        return $this->stepField;
    }

    /**
     * @param string $stepField
     *
     * @return BaseContextModule
     */
    public function setStepField( string $stepField ): BaseContextModule {
        $this->stepField = $stepField;

        return $this;
    }

    /**
     * 获取要执行的实例 id
     * @return mixed
     */
    public function getInstanceId() {
        return $this->instanceId;
    }

    /**
     * 设置要执行的实例 id
     *
     * @param mixed $instanceId
     *
     * @return BaseContextModule
     */
    public function setInstanceId( $instanceId ): BaseContextModule {
        $this->instanceId = $instanceId;

        return $this;
    }

    /**
     * 获取 openAi key
     * @return string
     */
    public function getOpenAiKey() {

        return GeneralConfig::getInstance()->getApiKey();
    }

    /**
     * 获取上一步执行步骤结果
     *
     * @param $key
     *
     * @return mixed|null
     */
    public function getPreStepResponseValue( $key ) {

        $preStep = $this->getTemplate()->getPreStep( $key );

        $keys = [ static::KEY_STEP, $preStep->field, static::KEY_STEP_RESPONSE ];
        $val  = $this->_getVariablesByKey( static::generateKey( $keys ) );

        return $val;
    }

    /**
     * 根据 step field 获取指定步骤
     *
     * @param $field
     *
     * @return false|mixed
     */
    public function getStepByField( $field ) {
        return $this->getTemplate()->getStepByField( $field );
    }

    /**
     * 添加变量
     *
     * @param $values
     *
     * @return $this
     */
    public function addVariable( $values ): AbstractContextModule {

        $this->_variableMap = $values;

        return $this;
    }

    /**
     * 添加 / 更新变量
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function pushVariable( $key, $value ): AbstractContextModule {

        $this->_variableMap[ $key ] = $value;

        return $this;
    }

    /**
     * 获取指定步骤的入参
     *
     * @param $key
     *
     * @return mixed
     */
    public function getStepVariable( $key ) {
        return $this->getStepVariableByStep( $key, $this->getStepField() );
    }

    /**
     * 获取指定步骤的入参
     *
     * @param $key
     * @param $stepField
     *
     * @return mixed
     */
    public function getStepVariableByStep( $key, $stepField ) {

        $keys = [ 'step', $stepField, $key ];
        $val  = $this->_getVariablesByKey( static::generateKey( $keys ) );

        return empty( $val ) ? $this->getGlobalVariable( $key ) : $val;
    }

    /**
     * 获取全局变量
     *
     * @param $key
     *
     * @return mixed|null
     */
    public function getGlobalVariable( $key ) {

        $keys = [ 'global', $key ];

        return $this->_getVariablesByKey( static::generateKey( $keys ) );
    }

    /**
     * 是否存在变量
     *
     * @param $key
     *
     * @return bool|string
     */
    public function existsStepVariableAndReturnFullKey( $key ) {
        return $this->existsStepVariableAndReturnFullKeyByStep( $key, $this->getStepField() );
    }

    /**
     * 是否存在变量
     *
     * @param $key
     * @param $stepField
     *
     * @return string|bool
     */
    public function existsStepVariableAndReturnFullKeyByStep( $key, $stepField ) {
        $keys = [ 'step', $stepField, $key ];
        $key  = static::generateKey( $keys );
        if ( array_key_exists( $key, $this->_variableMap ) ) {

            return $key;
        }

        return false;
    }

    /**
     * 获取指定步骤的入参
     *
     * @param $key
     *
     * @return mixed
     */
    protected function _getVariablesByKey( $key ) {
        $val = array_key_exists( $key, $this->_variableMap ) ? $this->_variableMap[ $key ] : null;

        return ! empty( $val ) ? $this->_parseVariables( $val ) : $val;
    }

    /**
     * 解析参数，替换变量
     *
     * @param $val
     *
     * @return mixed
     */
    private function _parseVariables( $val ) {

        if ( is_string( $val ) ) {
            //占位符替换
            foreach ( $this->_variableMap as $key => $value ) {
                if ( ! is_object( $value ) && ! is_array( $value ) ) {
                    $val = str_replace( "{" . $key . "}", $value, $val );
                }
            }

        }

        return $val;
    }

    /**
     * 添加事件
     *
     * @param AbstractEventModule $event
     *
     * @return void
     */
    public function addEvent( $event ) {
        $this->_events[] = $event;
    }

    /**
     * @param $eventCode
     *
     * @return array{AbstractEventModule}
     */
    public function listEvents( $eventCode ): array {

        return array_filter( $this->_events, function ( $event ) use ( $eventCode ) {
            return $event->eventCode == $eventCode;
        } );
    }

    /**
     * 执行模版执行前事件
     *
     * @return null
     * @throws Exception
     */
    public function runEventTempPre() {

        return $this->runEvent( EventCodeConst::EVENT_TEMP_PRE()->getValue() );
    }

    /**
     * 执行模版执行后事件
     * @return null
     * @throws Exception
     */
    public function runEventTempPost() {
        return $this->runEvent( EventCodeConst::EVENT_TEMP_POST()->getValue() );
    }

    /**
     * 执行步骤执行前事件
     *
     * @param AbstractStepModule $stepModule
     *
     * @return null
     * @throws Exception
     */
    public function runEventStepPre( AbstractStepModule $stepModule ) {
        return $this->runEvent( EventCodeConst::EVENT_STEP_PRE()->getValue(), $stepModule );
    }

    /**
     * 执行步骤执行后事件
     *
     * @param AbstractStepModule $stepModule
     *
     * @return null
     * @throws Exception
     */
    public function runEventStepPost( AbstractStepModule $stepModule ) {
        return $this->runEvent( EventCodeConst::EVENT_STEP_POST()->getValue(), $stepModule );
    }

    /**
     * 执行事件
     *
     * @param $eventCode
     *
     * @return void
     * @throws Exception
     */
    protected function runEvent( $eventCode ) {

        $_args = array_slice( func_get_args(), 1 );

        $events = $this->listEvents( $eventCode );
        /**
         * @var $event AbstractEventModule
         */
        foreach ( $events as $event ) {
            try {
                call_user_func_array( [ $event, '_execute' ], array_merge( [ $this ], $_args ) );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }
        }

    }

}