<?php

namespace MoredealAiWriter\application\consts;

defined( '\ABSPATH' ) || exit;

/**
 * Constant class file
 * 失败信息常量类
 *
 * @author MoredealAiWriter
 */
class ErrorConstant {

    /**
     * 激活失败默认提示
     */
    const ACTIVE_LICENSE_FAIL_MESSAGE = 'Active fail, place contact your administrator';

    /**
     * 获取授权信息失败默认提示
     */
    const GET_LICENSE_INFO_FAIL_MESSAGE = 'Get license info fail, place contact your administrator';

    /**
     * 解绑授权失败默认提示
     */
    const UNBIND_LICENSE_FAIL_MESSAGE = 'Unbind license fail, place contact your administrator';

    /**
     * 获取模版市场模版分页数据失败默认提示
     */
    const PAGE_MARKET_TEMPLATE_FAIL_MESSAGE = 'Page market template fail, place contact your administrator';

    /**
     * 获取模版市场模版详情失败默认提示
     */
    const DETAIL_MARKET_TEMPLATE_FAIL_MESSAGE = 'Detail market template fail, place contact your administrator';

    /**
     * 获取主题集合
     */
    const GET_TOPIC_FAIL_MESSAGE = 'Get topic map fail, place contact your administrator';

    /**
     * 模版市场模版操作失败默认提示
     */
    const ACTION_MARKET_TEMPLATE_FAIL_MESSAGE = 'Action market template fail, place contact your administrator';

    /**
     * 模版市场安装模板操作失败提示
     */
    const INSTALL_MARKET_TEMPLATE_FAIL_MESSAGE = 'Install market template fail, place contact your administrator';

    /**
     * 发送openai chat 请求失败
     */
    const SEND_OPENAI_CHAT_COMPLETION_FAIL_MESSAGE = 'Send openai chat completion fail, place contact your administrator';

    /**
     * 发送openai image 请求失败
     */
    const SEND_OPENAI_IMAGE_FAIL_MESSAGE = 'Send openai image fail, place contact your administrator';

    /**
     * 获取token消耗信息请求失败
     */
    const GET_TOKEN_USAGE_FAIL_MESSAGE = 'Get token usage fail, place contact your administrator';

    /**
     * 获取模版市场模版分类失败默认提示
     */
    const GET_MOREDEAL_AIGC_ACCOUNT_FAIL_MESSAGE = 'Get moredeal aigc account fail, place contact your administrator';

    /**
     * 获取 token 信息失败默认提示
     */
    const GET_TOKEN_INFO_FAIL_MESSAGE = 'Get token info fail, place contact your administrator';

    /**
     * 激活 token 失败默认提示
     */
    const ACTIVE_TOKEN_FAIL_MESSAGE = 'Active token fail, place contact your administrator';

    /**
     * 生成文章失败
     */
    const CREATE_POST_FAIL_MESSAGE = 'Create post fail, place contact your administrator';

    /**
     * 查询商品失败
     */
    const SEND_SEARCH_PRODUCT_FAIL_MESSAGE = 'Send search product fail, place contact your administrator';

    const SERVICE_SOURCE_TYPE_FAIL_MESSAGE = 'service source type fail, place contact your administrator';

    const SERVICE_DELETE_FAIL_MESSAGE = 'service delete fail, place contact your administrator';

    const SERVICE_UPDATE_FAIL_MESSAGE = 'service update fail, place contact your administrator';

    const SERVICE_LIST_FAIL_MESSAGE = 'service list fail, place contact your administrator';

    const SERVICE_REGISTER_FAIL_MESSAGE = 'service register fail, place contact your administrator';

    /**
     * 批量创建模版请求失败
     */
    const UPLOAD_FILE_FAIL_MESSAGE = 'upload file is fail,  place contact your administrator';


    /**
     * 获取账户集合请求失败
     */
    const SERVICE_ACCOUNTS_FAIL_MESSAGE = 'service accounts fail, place contact your administrator';

    const GET_DEFAULT_IMAGE_FAIL_MESSAGE = 'get default image fail, place contact your administrator';

    /**
     * 获取授权码信息请求失败
     */
    const SERVICE_GET_AUTHCODE_INFO_FAIL_MESSAGE = 'service get authcode info fail, place contact your administrator';

}