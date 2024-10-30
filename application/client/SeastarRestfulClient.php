<?php

namespace MoredealAiWriter\application\client;

defined( '\ABSPATH' ) || exit;

use CURLFile;
use Exception;
use MoredealAiWriter\application\consts\ErrorConstant;
use MoredealAiWriter\application\helpers\DateHelper;
use MoredealAiWriter\application\libs\rest\HttpClient;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\step\StepWrapper;
use MoredealAiWriter\code\modules\template\AbstractTemplateModule;
use MoredealAiWriter\code\modules\template\TemplateManager;

/**
 * 调用 Seastar API 的客户端
 *
 * @author MoredealAiWriter
 */
class SeastarRestfulClient extends MoredealRestfulClient {

    /**
     * token header
     *
     * @var string
     */
    const MOREDEAL_AIGC_TOKEN = 'License-Authorization';

    /**
     * domain header
     *
     * @var string
     */
    const MOREDEAL_AIGC_DOMAIN = 'License-Domain';

    /**
     * 默认 host
     */
    const DEFAULT_SEASTAR_HOST = 'http://bo.moredeal.us/';
//    const DEFAULT_SEASTAR_HOST = 'http://192.168.0.114:8081/'; // hy
//    const DEFAULT_SEASTAR_HOST = 'http://192.168.0.120:8081/'; // wrq
//    const DEFAULT_SEASTAR_HOST = 'http://192.168.0.175:8081/'; // ??

    /**
     * 默认 api 前缀
     */
    const SEASTAR_API_URI_SUFFIX = '/stage-api';
//    const SEASTAR_API_URI_SUFFIX = '';

    /**
     * 不需要 token 的 api
     */
    const NOT_NEED_TOKEN_API = array( '/aigc/crateInitCode' );

    /**
     * 构造函数
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * 请求 host
     * @return string host
     */
    public function host(): string {
        return self::DEFAULT_SEASTAR_HOST;
    }

    /**
     * 请求 api 前缀
     * @return string api 前缀
     */
    public function api_prefix(): string {
        return self::SEASTAR_API_URI_SUFFIX;
    }

    // License API START -----------------------------------------------------------------------------------------------

    /**
     * 获取 moredeal aigc 的 account. 每个网站拥有唯一 account
     * @return array
     */
    public function moredeal_aigc_account(): array {
        $request = json_encode( array(
            'domain' => Plugin::current_domain(),
        ) );
        error_log( 'init moredeal ai writer account request: ' . $request );

        $result          = json_decode( $this->post( '/aigc/crateInitCode', $request ), true );
        $default_message = ErrorConstant::GET_MOREDEAL_AIGC_ACCOUNT_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }

    // License API START -----------------------------------------------------------------------------------------------

    /**
     * 激活授权
     *
     * @param string $license_key
     *
     * @return array
     */
    public function active_license( string $license_key ): array {
        $request = json_encode( array(
            'code'   => $license_key,
            'domain' => Plugin::current_domain(),
        ) );
        error_log( 'active license request: ' . $request );

        $result          = json_decode( $this->post( '/aigc/bind', $request ), true );
        $default_message = ErrorConstant::ACTIVE_LICENSE_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }

    /**
     * 解绑授权
     *
     * @param array $request
     *
     * @return array
     */
    public function unbind_license( array $request ): array {

        $license_key = empty( $request['license'] ) ? '' : $request['license'];
        $domain      = empty( $request['domain'] ) ? '' : $request['domain'];
        if ( empty( $license_key ) || empty( $domain ) ) {
            return $this->failure( 'license or domain is empty' );
        }

        $request = json_encode( array(
            'code'   => $license_key,
            'domain' => $domain,
        ) );
        error_log( 'unbind license request: ' . $request );

        $result          = json_decode( $this->post( '/aigc/unbind', $request ), true );
        $default_message = ErrorConstant::UNBIND_LICENSE_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }

    /**
     * 获取授权信息
     *
     * @param string $license_key
     *
     * @return array
     */
    public function license_info( string $license_key ): array {

        $request = json_encode( array(
            'code' => $license_key,
        ) );
        error_log( 'license info request: ' . $request );

        $result          = json_decode( $this->post( '/aigc/bindList', $request ), true );
        $default_message = ErrorConstant::GET_LICENSE_INFO_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }
    // License API END -------------------------------------------------------------------------------------------------

    // TOKEN API START -------------------------------------------------------------------------------------------------
    /**
     * 激活 token. 充值 token
     *
     * @param string $token
     *
     * @return array
     */
    public function active_token( string $token ): array {
        $request = json_encode( array(
            'code'      => Plugin::plugin_key(),
            'domain'    => Plugin::current_domain(),
            'tokenCode' => $token
        ) );
        error_log( 'token active body: ' . $request );

        $result          = json_decode( $this->post( '/aigc/rechargeToken', $request ), true );
        $default_message = ErrorConstant::ACTIVE_TOKEN_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }

    /**
     * 获取 token 信息, 剩余 token 数量, token 过期时间
     *
     * @param string $aigc_key
     *
     * @return array
     */
    public function token_info( string $aigc_key ): array {

        $request = json_encode( array(
            'code' => $aigc_key,
        ) );
        error_log( 'token info body: ' . $request );

        $result = json_decode( $this->post( '/aigc/codetokeninfo', $request ), true );

        $default_message = ErrorConstant::GET_TOKEN_INFO_FAIL_MESSAGE;
        $result          = $this->build_result( $result, $default_message );

        if ( empty( $result['success'] ) || empty( $result['data'] ) ) {
            return $result;
        }
        // 格式化过期时间
        if ( ! empty( $result['data']['expireTime'] ) ) {
            $result['data']['timeLeft'] = DateHelper::formatExpireTimeToTimeLeft( $result['data']['expireTime'] );
        } else {
            $result['data']['timeLeft'] = '0 day';
        }
        $result['data']['level'] = Plugin::plugin_level();

        return $result;
    }
    // TOKEN API END ---------------------------------------------------------------------------------------------------

    // 模版市场 API START -----------------------------------------------------------------------------------------------
    /**
     * 分页获取模版市场模版
     *
     * @param $request array
     *
     * @return array
     */
    public function pageMarketTemplate( array $request ): array {

        $params = json_encode( $request );

        error_log( 'pageMarketTemplate: ' . $params );
        $result          = json_decode( $this->post( "/template/list", $params ), true );
        $default_message = ErrorConstant::PAGE_MARKET_TEMPLATE_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message, '', true );
    }

    /**
     * 获取模板市场模版详情
     *
     * @param $request array
     *
     * @return array
     */
    public function detailMarketTemplate( array $request ): array {
        $params          = json_encode( $request );
        $result          = json_decode( $this->post( "/template/get", $params ), true );
        $default_message = ErrorConstant::DETAIL_MARKET_TEMPLATE_FAIL_MESSAGE;
        $result          = $this->build_result( $result, $default_message );
        if ( empty( $result['success'] ) || empty( $result['data'] ) ) {
            return $result;
        }
        $data = $result['data'];
        if ( ! empty( $data['config'] ) ) {
            $info = json_decode( $data['config'] );
            try {
                /**
                 * @var AbstractTemplateModule $info
                 */
                $info = TemplateManager::factoryByKey( $info );
                if ( ! empty( $request['scene'] ) ) {
                    /**
                     * @var StepWrapper[] $steps
                     */
                    $steps        = $info->steps;
                    $filter_steps = array();
                    // 过滤 step
                    foreach ( $steps as $step ) {
                        $scenes      = $step->stepModule->scenes;
                        $scenes_keys = array_column( $scenes, 'key' );
                        if ( empty( $scenes ) || in_array( $request['scene'], $scenes_keys ) ) {
                            $filter_steps[] = $step;
                        }
                    }
                    $info->steps = array_values( $filter_steps );
                }
            } catch ( Exception $e ) {
                error_log( 'get config error: ' . $e->getMessage() );
            }
            $result['data']['info'] = $info;
        }
        unset( $result['data']['config'] );

        return $result;
    }

    /**
     * 模版市场模版操作, 点赞，浏览
     *
     * @param $request array
     *
     * @return array
     */
    public function actionMarketTemplate( array $request ): array {
        $params = json_encode( $request );
        error_log( 'actionMarketTemplate: ' . $params );
        $result          = json_decode( $this->post( "/template/action", $params ), true );
        $default_message = ErrorConstant::ACTION_MARKET_TEMPLATE_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }

    /**
     * 模版市场提交新模板
     *
     * @param array $request
     *
     * @return array
     */
    public function submitTemplate( array $request ): array {
        $params = json_encode( $request );

        $result          = json_decode( $this->post( "/template/create", $params ), true );
        $default_message = ErrorConstant::ACTION_MARKET_TEMPLATE_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );

    }

    /**
     * 安装模版市场的模版
     *
     * @return mixed
     */
    public function installMarketTemplate( $request ): array {
        error_log( 'send template install body: ' . json_encode( $request ) );
        $result = (array) json_decode( $this->post( '/template/install', json_encode( array(
            'templateId'        => $request["template_id"],
            'version'           => $request["version"],
            'authorizationCode' => $request["license_key"],
            'userPluginLevel'   => $request["user_plugin_level"],
            'userPluginVersion' => $request["user_plugin_version"],
        ) ) ), true );

        error_log( 'rest template install body : ' . json_encode( $result ) );

        if ( $result == null ) {
            return [];
        }

        if ( $result['success'] ) {
            return mb_convert_encoding( $result['data'], 'utf-8', 'UTF-8,GBK,GB2312,BIG5' );
        } else {
            return [];
        }
    }

    /**
     * 获取主题集合
     *
     * @param $request
     *
     * @return array
     */
    public function topicMap( $request = null ): array {
        $result = json_decode( $this->post( "/template/topicMap", $request ), true );

        return $this->build_result( $result, ErrorConstant::GET_TOPIC_FAIL_MESSAGE );

    }

    const TOPIC_IMAGES = array(
        'Other'         => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Other.jpg",
        'Custom'        => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Custom.jpg",
        'Writing'       => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Writing.jpg",
        'Email'         => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Email.jpg",
        'Blog'          => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Blog.jpg",
        'Article'       => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Article.jpg',
        'Image'         => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Image.jpg",
        'Image Content' => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/ImageByContent.jpg",

        'Ads'          => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Ads.jpg",
        'Amazon'       => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Amazon.jpg",
        'Search'       => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Search.jpg',
        'Website'      => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Website.jpg",
        'Social Media' => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/SocialMedia.jpg",
        'Marketing'    => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Maketing.jpg",
        'Business'     => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Business.jpg",
        'Resume'       => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Resume.jpg",
        'Role Play'    => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/RolePlay.jpg",
        'Fun'          => "https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Fun.jpg",

        'Report'           => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Report.jpg',
        'Title'            => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Title.jpg',
        'Excerpt'          => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/Excerpt.jpg',
        'Translate'        => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/TranslateText.jpg',
        'Improve Writing'  => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/ImproveWriting.jpg',
        'Continue Writing' => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/ContinueWriting.jpg',
        'Make Longer'      => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/MakeLonger.jpg',
        'Summarize Text'   => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/SummarizeText.jpg',
        'Summarize Table'  => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/SummarizeTable.jpg',
        'Generate Table'   => 'https://download.hotsalecloud.com/wp-plugins/img/template_img/default/GenerateTable.jpg',
    );

    /**
     * 处理通用默认图片
     *
     * @param $topics
     *
     * @return string
     */
    public function handleCommonDefaultImage( $topics ): string {
        $topic = $topics[0];
        if ( count( $topics ) > 1 && $topic === 'Writing' ) {
            $topic = trim( $topics[1] );

            return $this->commonDefaultImage( $topic );
        }

        return $this->commonDefaultImage( $topic );
    }

    /**
     * @param $topic
     *
     * @return string
     */
    public function commonDefaultImage( $topic ): string {
        if ( array_key_exists( $topic, self::TOPIC_IMAGES ) ) {
            return self::TOPIC_IMAGES[ $topic ];
        }

        return self::TOPIC_IMAGES['Writing'];
    }

    /**
     * 批量创建模板
     *
     * @param $inputStream
     *
     * @return array
     */
    public function batchCreate( $inputStream ): array {
        error_log( 'inputStream body: ' . $inputStream );

        $result = (array) json_decode( $this->post( '/template/readFromInputStream',
            json_encode( array( 'bookStream' => $inputStream ) ) ) );

        return $this->build_result( $result, ErrorConstant::UPLOAD_FILE_FAIL_MESSAGE );
    }

    public function batchCreate1( $file_name ): array {
        error_log( 'file_name body: ' . $file_name );

        $result = (array) json_decode( $this->post( '/template/getBatchCreate',
            json_encode( array( 'file' => new CURLFile( $file_name ) ) ) ) );

        return $this->build_result( $result, ErrorConstant::UPLOAD_FILE_FAIL_MESSAGE );
    }

    // 模版市场 API END -------------------------------------------------------------------------------------------------

    /**
     * 服务注册
     *
     * @param array $request
     *
     * @return array
     */
    public function service_register( array $request ): array {
        $request = json_encode( $request );
        error_log( 'service register body: ' . $request );

        $result          = json_decode( $this->post( '/aigc/service/register', $request ), true );
        $default_message = ErrorConstant::SERVICE_REGISTER_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }

    /**
     * 更新注册信息
     *
     * @param array $request
     *
     * @return array
     */
    public function service_update( array $request ): array {
        $request = json_encode( $request );
        error_log( 'service update register body: ' . $request );

        $result          = json_decode( $this->post( '/aigc/service/updateRegister', $request ), true );
        $default_message = ErrorConstant::SERVICE_UPDATE_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }

    /**
     * 删除注册信息
     *
     * @param array $request
     *
     * @return array
     */
    public function service_delete( array $request ): array {
        error_log( 'service delete register body: ' . json_encode( $request ) );

        $result          = json_decode( $this->get( '/aigc/service/delete', $request ), true );
        $default_message = ErrorConstant::SERVICE_DELETE_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }

    /**
     * 删除注册信息
     *
     * @return array
     */
    public function service_source_type(): array {
        error_log( 'service source type' );

        $result          = json_decode( $this->post( '/aigc/service/sourcetype' ), true );
        $default_message = ErrorConstant::SERVICE_SOURCE_TYPE_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }

    /**
     * 服务列表
     *
     * @return array
     */
    public function service_list(): array {
        error_log( 'service search list' );
        $result          = json_decode( $this->post( '/aigc/service/searchList' ), true );
        $default_message = ErrorConstant::SERVICE_LIST_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }

    /**
     * 服务列表
     *
     * @return array
     */
    public function service_chat_search_list(): array {
        error_log( 'service chat search list' );
        $result          = json_decode( $this->post( '/aigc/service/chat/searchList' ), true );
        $default_message = ErrorConstant::SERVICE_LIST_FAIL_MESSAGE;

        return $this->build_result( $result, $default_message );
    }


    // OPEN-AI API START -----------------------------------------------------------------------------------------------

    /**
     * java调用 openai completion 接口
     *
     * @param $opts
     *
     * @return array
     */
    public function openaiChat( $opts ): array {

        $request = json_encode( $opts );
        error_log( 'send openai chat body: ' . $request );

        $result = (array) json_decode( $this->post( '/aigc/chat/completion', json_encode( array(
            'data' => $request,
        ) ) ), true );

        if ( $result == null ) {
            return [];
        }

        if ( array_key_exists( "success", $result ) && $result['success'] ) {
            return $result['data'];
        } else {
            return [];
        }
    }

    /**
     * java调用 openai chat completion接口
     *
     * @param $opts
     *
     * @return array
     */
    public function openaiChatCompletion( $opts ): array {

        $request = json_encode( $opts );
        error_log( 'send openai chat completion body: ' . $request );

        $response = (array) json_decode( $this->post( '/aigc/chat/chatCompletion', json_encode( array(
            'data' => $request,
        ) ) ), true );

        $result = $this->build_result( $response, ErrorConstant::SEND_OPENAI_CHAT_COMPLETION_FAIL_MESSAGE );
        if ( ! empty( $result['success'] ) && ! empty( $result['data'] ) ) {
            return $result['data'];
        }

        return $result;
    }

    /**
     * java调用 openai image 接口
     *
     * @param $opts
     *
     * @return array
     */
    public function openai_image( $opts ): array {

        $request = json_encode( $opts );
        error_log( 'send openai body: ' . $request );

        $response = (array) json_decode( $this->post( '/aigc/chat/image', json_encode( array(
            'data' => $request,
        ) ) ), true );

        $result = $this->build_result( $response, ErrorConstant::SEND_OPENAI_IMAGE_FAIL_MESSAGE );

        if ( ! empty( $result['success'] ) && ! empty( $result['data'] ) ) {
            return $result['data'];
        }

        return $result;
    }

    // OPEN-AI API END -----------------------------------------------------------------------------------------------

    // SEARCH PRODUCT START ------------------------------------------------------------------------------------------
    /**
     * 查询商品
     *
     * @param array $keyword
     *
     * @return array
     */
    public function searchProduct( $keyword ): array {
        error_log( 'send search product keyword: ' . json_encode( $keyword ) );

        $request = json_encode( array(
            'page'          => array( 'page' => 1, 'pageSize' => 5 ),
            'productSearch' => array( 'title' => $keyword )
        ) );

        $response = (array) json_decode( $this->post( '/selection/product/search', $request )
            , true );

        return $this->build_result( $response, ErrorConstant::SEND_SEARCH_PRODUCT_FAIL_MESSAGE, '', true );

    }

    // SEARCH PRODUCT END ------------------------------------------------------------------------------------------

    // ACCOUNT START ------------------------------------------------------------------------------------------
    /**
     * 获取当前用户的所有子用户集合
     *
     * @param $user_id
     *
     * @return array
     */
    public function searchAccounts( $user_id ): array {
        error_log( 'send search accounts user_id: ' . json_encode( $user_id ) );

        $request = json_encode( array( 'wpUserId' => $user_id ) );

        $response = (array) json_decode( $this->post( '/aigc/account/getChildren', $request )
            , true );

        return $this->build_result( $response, ErrorConstant::SERVICE_ACCOUNTS_FAIL_MESSAGE, '', true );

    }

    /**
     * 查询用户的账户信息
     *
     * @param $user_id
     *
     * @return array
     */
    public function queryAccount( $user_id ): array {
        error_log( 'send query account user_id: ' . json_encode( $user_id ) );

        $request = json_encode( array( 'wpUserId' => $user_id ) );

        $response = (array) json_decode( $this->post( '/aigc/account/get', $request )
            , true );

        return $this->build_result( $response, ErrorConstant::SERVICE_ACCOUNTS_FAIL_MESSAGE, '', true );

    }

    /**
     * 获取授权码信息
     *
     * @param $request
     *
     * @return array
     */
    public function getCodeInfo( $request ): array {
        $params = json_encode( $request );

        $response = (array) json_decode( $this->post( '/authcode/get/code', $params )
            , true );

        return $this->build_result( $response, ErrorConstant::SERVICE_GET_AUTHCODE_INFO_FAIL_MESSAGE, '', true );

    }

    // ACCOUNT START ------------------------------------------------------------------------------------------

    /**
     * 请求前准备参数
     *
     * @param        $client HttpClient
     * @param string $path
     *
     * @return void
     * @throws Exception
     */
    protected function prepareHeaders( HttpClient $client, string $path = '' ) {
        $feature_path = explode( '?', $path );
        if ( count( $feature_path ) > 0 && in_array( $feature_path[0], self::NOT_NEED_TOKEN_API ) ) {
            $client->addHeader( self::MOREDEAL_AIGC_DOMAIN, Plugin::current_domain() );
//            $client->addHeader( 'Content-Type', 'multipart/form-data' );
            parent::prepareHeaders( $client, $path );
            error_log( 'Moredeal Ai Writer Not Need Token Request URL: ' . $client->getUri() );
            error_log( self::MOREDEAL_AIGC_DOMAIN . ' Header: ' . json_encode( $client->getHeader( self::MOREDEAL_AIGC_DOMAIN ) ) );

            return;
        }

        // 需要添加 header token 和 domain 的接口
        $aigc_key = Plugin::plugin_key();
        if ( empty( $aigc_key ) ) {
            throw new Exception( Plugin::name() . Plugin::translation( ' Cant find your account id or license key. Please contact the administrator.' ) );
        }
        $client->addHeader( self::MOREDEAL_AIGC_TOKEN, $aigc_key );
        $client->addHeader( self::MOREDEAL_AIGC_DOMAIN, Plugin::current_domain() );
        parent::prepareHeaders( $client, $path );
        error_log( 'Moredeal Ai Writer Request URL: ' . $client->getUri() . '.  '
                   . self::MOREDEAL_AIGC_TOKEN . ' Header: ' . json_encode( $client->getHeader( self::MOREDEAL_AIGC_TOKEN ) ) . '. '
                   . self::MOREDEAL_AIGC_DOMAIN . ' Header: ' . json_encode( $client->getHeader( self::MOREDEAL_AIGC_DOMAIN ) ) );

    }
}
