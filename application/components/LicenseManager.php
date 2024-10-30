<?php

namespace MoredealAiWriter\application\components;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\admin\LicenseConfig;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\consts\ErrorConstant;
use MoredealAiWriter\application\Plugin;

/**
 * 授权码管理
 *
 * @author MoredealAiWriter
 */
class LicenseManager {

    /**
     * 解绑标识
     *
     * @var string
     */
    const UNBIND_TAG = 'moredeal_aigc_license_unbind_tag';

    /**
     * 解绑标识值
     *
     * @var string
     */
    const UNBIND_TAG_VALUE = 'moredeal_aigc_license_unbind';

    /**
     * 解绑表单 License 字段
     *
     * @var string
     */
    const UNBIND_FORM_LICENSE = 'moredeal_aigc_unbind_form_license';

    /**
     * 解绑表单 Domain 字段
     *
     * @var string
     */
    const UNBIND_FORM_DOMAIN = 'moredeal_aigc_unbind_form_domain';

    /**
     * License 信息
     *
     * @var array
     */
    private $license_info = null;

    /**
     * 授权码管理实例
     *
     * @var null LicenseManager
     */
    private static $instance = null;

    /**
     * 获取实例
     *
     * @return LicenseManager
     */
    public static function getInstance(): LicenseManager {
        if ( self::$instance == null ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * 是否是 license 配置页面
     * @return bool
     */
    public static function is_display_notice(): bool {
        if ( $GLOBALS['pagenow'] == 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] == LicenseConfig::getInstance()->page_slug() ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 添加错误信息
     *
     * @param string $message
     *
     * @return void
     */
    public static function add_license_setting_error( string $message ) {
        if ( self::is_display_notice() ) {
            return;
        }
        add_settings_error( 'license_key', 'license_key', $message );
    }

    /**
     * 请求接口获取License信息
     *
     * @param string $license 授权码
     *
     * @return array
     */
    public function license_info( string $license ): array {

        if ( $this->license_info !== null ) {
            return $this->license_info;
        }

        if ( ! $license ) {
            return array();
        }

        $result = SeastarRestfulClient::getInstance()->license_info( $license );

        if ( ! empty( $result['success'] ) && ! empty( $result['data'] ) && is_array( $result['data'] ) ) {
            $license_info = $result['data'];
        } else {
            $license_info = array();
        }
        $this->license_info = $license_info;

        return $this->license_info;
    }

    /**
     * 请求接口获取License信息
     *
     * @param string $license 授权码
     *
     * @return array
     */
    public function license_info_message( string $license ): array {

        if ( $this->license_info !== null ) {
            return $this->license_info;
        }

        if ( ! $license ) {
            return array();
        }

        $result = SeastarRestfulClient::getInstance()->license_info( $license );

        if ( ! empty( $result['success'] ) && ! empty( $result['data'] ) && is_array( $result['data'] ) ) {
            $this->license_info = $result['data'];
        }

        return $result;

    }

    /**
     * 获取 license level
     *
     * @return string
     */
    public function license_level(): string {
        $license_key = LicenseConfig::license_key();
        if ( ! $license_key ) {
            return 'free';
        }

        $license_info = $this->license_info( $license_key );
        if ( empty( $license_info ) ) {
            return 'free';
        }

        return $this->get_type( empty( $license_info['codeType'] ) ? '' : strtoupper( $license_info['codeType'] ) );
    }

    /**
     * 初始化加载
     * @return void
     */
    public function admin_init() {
        if ( ! self::is_display_notice() ) {
            return;
        }
        add_action( 'admin_notices', array( $this, 'display_notice' ) );
    }

    /**
     * 展示授权码信息
     *
     * @return void
     */
    public function display_notice() {
        // 仅在 License 配置页面显示
        if ( ! self::is_display_notice() ) {
            return;
        }
        // 加载样式
        $this->add_inline_css();

        // 授权码不存在，说明未授权。
        $license = LicenseConfig::license_key();
        if ( ! $license ) {
            $this->display_no_license( $license );

            return;
        }

        // 获取授权码信息失败，提示用户联系我们。
        $result = self::getInstance()->license_info_message( $license );
        if ( empty( $result ) || empty( $result['success'] ) || empty( $result['data'] ) ) {
            $this->display_no_data( $license, $result['message'] ?? ErrorConstant::GET_LICENSE_INFO_FAIL_MESSAGE );

            return;
        }
        $data = $result['data'];
        // 授权码存在，但是还是免费版，说明未下载最新包覆盖。
        if ( Plugin::is_free() ) {
            $this->display_download_plugin( $license, $data );

        }

        // 获取 token 信息
        $token_info = TokenManager::getInstance()->token_info( $license );
        if ( ! empty( $token_info ) ) {
            $data['token_info'] = $token_info;
        }

        // 会员获取授权码信息
        $this->display_active_notice( $data, $license );
    }

    /**
     * 授权码不存在，说明未授权。
     *
     * @param string $license
     *
     * @return void
     */
    public function display_no_license( string $license ) {

    }

    /**
     * 渲染下载最新插件的通知
     * 第一次输入授权码激活之后出现
     *
     * @param string $license
     * @param        $data
     *
     * @return void
     */
    public function display_download_plugin( string $license, $data ) {
        $level        = $this->get_type( empty( $data['codeType'] ) ? '' : strtoupper( $data['codeType'] ) );
        $download_url = UpdateManager::download_url( $level );
        if ( empty( $download_url ) ) {
            echo '<div class="notice notice-error is-dismissible"><p>';
            echo Plugin::translation( 'Cant get download url?, please contact us get the url download the latest version overrides the current free version of the plugin.' );
        } else {
            echo '<div class="notice notice-success moredeal-notice"><p>';
            echo Plugin::translation( 'You can download the latest version overrides the current free version of the plugin to use Advanced version' );
            echo '<span style="margin-left: 8px"><a href="' . $download_url . '" target="_blank" class="button ">' . Plugin::translation( 'Download Latest Plugin' ) . '</a></span>';
        }
        echo '</p></div>';
    }

    /**
     * 展示未授权信息或者未获取到授权信息
     *
     * @param string $license 授权码
     * @param string $message
     *
     * @return void
     */
    public function display_no_data( string $license, string $message = '' ) {
        echo '<div class="notice notice-error is-dismissible"><p>';
        if ( ! empty( $message ) ) {
            echo Plugin::translation( $message );
        } else {
            echo Plugin::translation( 'Cant get License Info, This License has an unknown error occurred, contact your administrator to solve the problem. ' );
        }
        echo '</p></div>';
    }

    /**
     * 展示授权信息
     *
     * @param array $data
     * @param string $license 授权码
     *
     * @return void
     */
    public function display_active_notice( array $data, string $license ) {
        // 授权码
        $license = $data['license'] ?? $license;
        // 授权状态
        $status = $this->get_status( strtoupper( $data['codeStatus'] ) );
        // 授权类型
        $type = $this->get_type( empty( $data['codeType'] ) ? '' : strtoupper( $data['codeType'] ), true );
        // 授权类型小写
        $level = $this->get_type( empty( $data['codeType'] ) ? '' : strtoupper( $data['codeType'] ) );
        // 过期时间
        $days_left = floor( ( strtotime( $data['expireTime'] ) - time() ) / 3600 / 24 );
        // 扩展说去
        $extData = (array) $data['extendData'] ?? array();
        // 限制绑定
        $limitBind = array_key_exists( 'limitBind', $extData ) ? $extData['limitBind'] : null;

        if ( strtoupper( $status ) == 'ACTIVE' ) {
            $color = '#00ba37';
        } else {
            $color = '#d63638';
        }
        echo '<div class="notice notice-success moredeal-notice"><p>' . Plugin::translation( 'License status: ' ) . '<span class="moredeal-label moredeal-label-active" style="background-color: ' . $color . '">';
        echo Plugin::translation( strtoupper( $status ) );

        echo ' </span> &nbsp;&nbsp;';
        $upper_status = strtoupper( $status );
        if ( $upper_status == 'NOACTIVE' ) {
            echo ' ' . Plugin::translation( 'The License has no active, place contact your administrator' );
        }
        if ( $upper_status == 'ACTIVE' ) {
            echo ' ' . Plugin::translation( 'You can use the advanced features of Moredeal AI Writer' );
        }
        if ( $upper_status == 'INACTIVE' ) {
            echo ' ' . Plugin::translation( 'The License has expired, please Renew your current license code or obtain a new license key' );
        }
        if ( $upper_status == 'DISABLE' ) {
            echo ' ' . Plugin::translation( 'The License has disabled, place contact your administrator' );
        }
        if ( $upper_status == 'UNKNOWN' ) {
            echo ' ' . Plugin::translation( 'Cant get the License status, place contact your administrator' );
        }
        echo '<br />' . sprintf( Plugin::translation( 'License Level is %s' ), Plugin::translation( $type ) );
        echo '<br />' . sprintf( Plugin::translation( 'Active at %s ' ), gmdate( 'Y-m-d H:i', strtotime( $data['activeTime'] ) ) );
        echo '<br />' . sprintf( Plugin::translation( 'Expires at %s (%d days left)' ), gmdate( 'Y-m-d H:i', strtotime( $data['expireTime'] ) ), strval( $days_left ) );
        echo '</p>';

        $token_info = empty( $data['token_info'] ) ? array() : $data['token_info'];
        if ( ! empty( $token_info ) ) {
            // 可用 token
            $usable_token = ! empty( $token_info['tokenUsable'] ) ? $token_info['tokenUsable'] : null;
            // 到期时间
            $timeLeft = ! empty( $token_info['timeLeft'] ) ? $token_info['timeLeft'] : null;

            echo '<p>';
            if ( ! empty( $usable_token ) ) {
                echo sprintf( Plugin::translation( 'You have usable tokens: %s, ' ), $usable_token );
            }
            if ( ! empty( $timeLeft ) ) {
                echo sprintf( Plugin::translation( 'Days left: %d .' ), strval( $timeLeft ) );
            }
//            if ( Plugin::is_free() ) {
//                echo ' <span style="color: red">' . Plugin::translation( 'Please download and install the premium version plug-in as soon as possible, otherwise you will not be able to use and experience the features of the premium version, and the token of this authorization code will not be available.' ) . '</span>';
//            }
            echo '</p>';
        }

        if ( $limitBind ) {
            echo '<p>' . sprintf( Plugin::translation( 'This License code can be bind to %s websites. ' ), $limitBind );
        }
        $rows    = array( 'bind_domain', 'options' );
        $sources = $data['sources'] ?? array();
        if ( count( $sources ) > 0 ) {
            echo ' ' . sprintf( Plugin::translation( 'Already bind websites: %s. ' ), count( $sources ) );
            if ( count( $sources ) < $limitBind ) {
                echo ' ' . sprintf( Plugin::translation( 'You can bind %s websites. ' ), ( $limitBind - count( $sources ) ) );
            } else {
                echo ' ' . Plugin::translation( 'You can not bind website, if you want bind other website, you can unbind already bind websites or upgrade your license. ' );
            }

            echo '</p><div class="products"><div class="comp_wrapper">';
            foreach ( $rows as $row ) {
                echo '<div class="comp_row">';
                echo '<div class="comp_thead">' . esc_html( Plugin::translation( $row ) );
                echo '</div>';
                $this->display_domain( $sources, $row );
//                $this->displayQueries( $sources, $row );
                $this->display_unbind( $sources, $row, $license );
                echo '</div>';
            }
            echo '</div></div>';
        }

        echo '<p> ' . sprintf( Plugin::translation( 'Moredeal AI Writer now Version is %s, Latest Version is %s.' ), Plugin::version(), UpdateManager::latest_version( $level ) ) . ' </p>';
        echo '</div>';
    }

    /**
     * 获取状态
     *
     * @param string $status
     *
     * @return string
     */
    public function get_status( string $status ): string {
        if ( $status == 'NOACTIVE' ) {
            return 'noactive';
        } else if ( $status == 'ACTIVE' ) {
            return 'active';
        } else if ( $status == 'EFFICACY' ) {
            return 'inactive';
        } else if ( $status == 'DISABLE' ) {
            return 'disable';
        } else {
            return 'unknown';
        }
    }

    /**
     * 渲染域名
     *
     * @param $data array 数据
     * @param $row string 行信息
     *
     * @return void
     */
    public function display_domain( array $data, string $row ) {
        if ( $row != 'bind_domain' ) {
            return;
        }
        foreach ( $data as $item ) {
            $item = (array) $item;
            if ( $item['sourceMark'] ) {
                $color = '#448FD5';
                echo '<div class="com_data data_product" >';
                if ( $item['sourceMark'] == Plugin::current_domain() ) {
                    echo '<span class="moredeal-label moredeal-label-active" style="background-color: #00ba37">' . Plugin::translation( 'Current Website' ) . '</span>';
                }
                echo '<a target="_blank" style="color: ' . $color . '" href="' . esc_url_raw( $item['sourceMark'] ) . '">' . esc_html( $item['sourceMark'] ) . '</a>';
                echo '</div>';
            }
        }
    }

    /**
     * 渲染解绑
     *
     * @param $data array 数据
     * @param $row string 行信息
     * @param $license string license code
     *
     * @return void
     */
    public function display_unbind( array $data, string $row, string $license ) {
        if ( $row != 'options' ) {
            return;
        }
        foreach ( $data as $index => $item ) {
            $item = (array) $item;
            if ( $item['sourceMark'] ) {
                echo '<div class="com_data data_product" >';
                echo '<form action=" ' . esc_url_raw( get_admin_url( get_current_blog_id(), 'admin.php?page=' . LicenseConfig::getInstance()->page_slug() ) ) . ' " method="POST">';
                echo '<input type="hidden" name="' . self::UNBIND_FORM_LICENSE . '" id="license_' . $index . '" value="' . esc_attr( $license ) . '"/>';
                echo '<input type="hidden" name="' . self::UNBIND_FORM_DOMAIN . '" id="domain_' . $index . '" value="' . esc_attr( $item['sourceMark'] ) . '"/>';
                echo '<input type="hidden" name="' . self::UNBIND_TAG . '" id="license_unbind_tag_' . $index . '" value="' . self::UNBIND_TAG_VALUE . '"/>';
                echo '<input type="submit" name="moredeal_aigc_submit_unbind_' . $index . '" id="moredeal_aigc_submit_unbind_' . $index . '" value="' . Plugin::translation( 'Unbind' ) . '" style="border:none;background:#f5f5f5;color:#448FD5;font-weight:700;cursor:pointer" />';
                echo '</form>';
                echo '</div>';
            }
        }
    }

    /**
     * 渲染商品查询次数
     *
     * @param $data
     * @param $row
     *
     * @return void
     */
    public function displayQueries( $data, $row ) {
        if ( $row != 'queries' ) {
            return;
        }
        foreach ( $data as $item ) {
            $item = (array) $item;
            if ( array_key_exists( 'extendData', $item ) && $item['extendData'] ) {
                $extendData = (array) $item['extendData'];
                if ( array_key_exists( 'limitRequest', $extendData ) && $extendData['limitRequest'] ) {
                    $limit = $extendData['limitRequest'];
                    if ( $limit == - 1 ) {
                        echo '<div class="com_data data_product" >';
                        echo '<span>' . esc_html( Plugin::translation( 'Unlimited' ) ) . '</span>';
                        echo '</div>';
                    } else {
                        if ( array_key_exists( 'unitTime', $extendData ) && $extendData['unitTime'] ) {
                            $unitTime = $extendData['unitTime'];
                        } else {
                            $unitTime = 'MONTH';
                        }
                        $unit = $this->get_time_unit( $unitTime );
                        echo '<div class="com_data data_product" >';
                        echo '<span>' . esc_html( $limit ) . esc_html( Plugin::translation( ' times / ' ) ) . esc_html( $unit ) . '</span>';
                        echo '</div>';
                    }
                }
            }
        }
    }

    /**
     * 获取类型
     *
     * @param string $type
     * @param bool $is_upper_first
     *
     * @return string
     */
    private function get_type( string $type, bool $is_upper_first = false ): string {
        if ( $type == 'PRO_AIGC' ) {
            if ( $is_upper_first ) {
                return 'Pro';
            }

            return 'pro';
        } elseif ( $type == 'PLUS_AIGC' ) {
            if ( $is_upper_first ) {
                return 'Plus';
            }

            return 'plus';
        } elseif ( $type == 'FREE_AIGC' ) {
            if ( $is_upper_first ) {
                return 'Free';
            }

            return 'free';
        }
        if ( $is_upper_first ) {
            return 'Free';
        }

        return 'free';
    }

    public function get_time_unit( $unitTime ) {
        if ( $unitTime == 'DAY' ) {
            return Plugin::translation( 'Day' );
        } elseif ( $unitTime == 'WEEK' ) {
            return Plugin::translation( 'Week' );
        } elseif ( $unitTime == 'MONTH' ) {
            return Plugin::translation( 'Month' );
        } elseif ( $unitTime == 'YEAR' ) {
            return Plugin::translation( 'Year' );
        }

        return Plugin::translation( 'Month' );
    }

    /**
     * 加载样式
     *
     * @return void
     */
    public function add_inline_css() {
        echo '<style>.moredeal-notice a.moredeal-notice-close {position:static;font-size:13px;float:right;top:0;right0;padding:0;margin-top:-20px;line-height:1.23076923;text-decoration:none;}.moredeal-notice a.moredeal-notice-close::before{position: relative;top: 18px;left: -20px;}.moredeal-notice img {float:left;width:40px;padding-right:12px;}</style>';
        echo '<style>.comp_wrapper{display:table;font-size:13px;color:#7A7A7A;border:1px solid #ececec;margin-bottom:8px}.comp_wrapper .comp_row:nth-child(2n+1){background-color:#f5f5f5}.comp_row{display:table-row}.comp_thead{font-weight:600;max-width:140px}.com_data,.comp_thead{width:140px;display:table-cell;vertical-align:middle;position:relative;text-align:center;padding:10px 10px 10px 10px;}.comp_wrapper .comp_row:nth-child(1) > div{padding:10px 5px}.comp_wrapper a{overflow:hidden;display:block;text-align:center;box-shadow:none;text-decoration:none;color:#448FD5;font-weight:700} </style>';
    }

}