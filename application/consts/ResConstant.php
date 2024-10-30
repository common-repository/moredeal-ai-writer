<?php

namespace MoredealAiWriter\application\consts;

defined( '\ABSPATH' ) || exit;

use const MoredealAiWriter\PLUGIN_RES;
use const MoredealAiWriter\PLUGIN_WP_BLOCK;

/**
 * 资源常量
 *
 * @author MoredealAiWriter
 */
class ResConstant {

    /**
     * 后台样式
     *
     * @var string
     */
    const MOREDEAL_AI_WRITER_ADMIN_UI_STYLE = PLUGIN_RES . '/css/ui.min.css';

    /**
     * 后台脚本
     *
     * @var string
     */
    const MOREDEAL_AI_WRITER_SETTING_STYLE = PLUGIN_RES . '/css/setting.css';

    /**
     * sleek 发布评论 JS
     *
     * @var string
     */
    const MOREDEAL_AIGC_SLEEK_SCRIPT = PLUGIN_RES . '/js/sleek.js';

    /**
     * Moredeal Ai Writer 页面 chunk-vendors.css
     *
     * @var string
     */
    const MOREDEAL_AIGC_VENDOR_STYLE = PLUGIN_RES . '/admin/css/chunk-vendors.css';

    /**
     * Moredeal Ai Writer 页面 index.css
     *
     * @var string
     */
    const MOREDEAL_AIGC_INDEX_STYLE = PLUGIN_RES . '/admin/css/index.css';

    /**
     * Moredeal Ai Writer 页面 chunk-vendors.js
     *
     * @var string
     */
    const MOREDEAL_AIGC_VENDOR_SCRIPT = PLUGIN_RES . '/admin/js/chunk-vendors.js';

    /**
     * Moredeal Ai Writer 页面 index.js
     *
     * @var string
     */
    const MOREDEAL_AIGC_INDEX_SCRIPT = PLUGIN_RES . '/admin/js/index.js';

    /**
     * Moredeal Ai Writer Limit 页面 limit.css
     *
     * @var string
     */
    const MOREDEAL_AIGC_LIMIT_INDEX_STYLE = PLUGIN_RES . '/admin/limit/limits.css';

    /**
     * Moredeal Ai Writer Limit 页面 vendors.js
     *
     * @var string
     */
    const MOREDEAL_AIGC_LIMIT_VENDORS_SCRIPT = PLUGIN_RES . '/admin/limit/chunk-vendors.js';


    /**
     * Moredeal Ai Writer Limit 页面 limit.js
     *
     * @var string
     */
    const MOREDEAL_AIGC_LIMIT_INDEX_SCRIPT = PLUGIN_RES . '/admin/limit/limits.js';

    /**
     * Moredeal Ai Writer Service 页面 service.css
     *
     * @var string
     */
    const MOREDEAL_AIGC_SERVICE_INDEX_STYLE = PLUGIN_RES . '/admin/service/service.css';

    /**
     * Moredeal Ai Writer Service 页面 vendors.js
     *
     * @var string
     */
    const MOREDEAL_AIGC_SERVICE_VENDORS_SCRIPT = PLUGIN_RES . '/admin/service/chunk-vendors.js';

    /**
     * Moredeal Ai Writer Template 单页面 index.css
     *
     * @var string
     */
    const MOREDEAL_AIGC_TEMPLATE_INDEX_STYLE = PLUGIN_RES . '/admin/template/index.css';

    /**
     * Moredeal Ai Writer Template 单页面 vendors.js
     *
     * @var string
     */
    const MOREDEAL_AIGC_TEMPLATE_VENDORS_SCRIPT = PLUGIN_RES . '/admin/template/chunk-vendors.js';

    /**
     * Moredeal Ai Writer Template 单页面 index.js
     *
     * @var string
     */
    const MOREDEAL_AIGC_TEMPLATE_INDEX_SCRIPT = PLUGIN_RES . '/admin/template/index.js';

    /**
     * Moredeal Ai Writer Service 页面 service.js
     *
     * @var string
     */
    const MOREDEAL_AIGC_SERVICE_INDEX_SCRIPT = PLUGIN_RES . '/admin/service/service.js';

    /**
     * Moredeal Ai Writer 文章编辑 Block 工具 style-index.css
     *
     * @var string
     */
    const MOREDEAL_AIGC_BLOCK_STYLE_INDEX_STYLE = PLUGIN_WP_BLOCK . '/build/style-index.css';

    /**
     * Moredeal Ai Writer 文章编辑 Block 工具 index.css
     *
     * @var string
     */
    const MOREDEAL_AIGC_BLOCK_INDEX_STYLE = PLUGIN_WP_BLOCK . '/build/index.css';

    /**
     * Moredeal Ai Writer 文章编辑 Block 工具 index.js
     *
     * @var string
     */
    const MOREDEAL_AIGC_BLOCK_INDEX_SCRIPT = PLUGIN_WP_BLOCK . '/build/index.js';


}