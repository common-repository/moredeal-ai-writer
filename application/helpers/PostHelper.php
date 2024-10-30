<?php

namespace MoredealAiWriter\application\helpers;

defined( '\ABSPATH' ) || exit;

/**
 * 文章工具类
 *
 * @author MoredealAiWriter
 */
class PostHelper {

    const LANG_CODES_LIST = array(
        'aa' => 'Afar',
        'ab' => 'Abkhazian',
        'af' => 'Afrikaans',
        'ak' => 'Akan',
        'sq' => 'Albanian',
        'am' => 'Amharic',
        'ar' => 'Arabic',
        'an' => 'Aragonese',
        'hy' => 'Armenian',
        'as' => 'Assamese',
        'av' => 'Avaric',
        'ae' => 'Avestan',
        'ay' => 'Aymara',
        'az' => 'Azerbaijani',
        'ba' => 'Bashkir',
        'bm' => 'Bambara',
        'eu' => 'Basque',
        'be' => 'Belarusian',
        'bn' => 'Bengali',
        'bh' => 'Bihari',
        'bi' => 'Bislama',
        'bs' => 'Bosnian',
        'br' => 'Breton',
        'bg' => 'Bulgarian',
        'my' => 'Burmese',
        'ca' => 'Catalan; Valencian',
        'ch' => 'Chamorro',
        'ce' => 'Chechen',
        'zh' => 'Chinese',
        'cu' => 'Church Slavic; Old Slavonic; Church Slavonic; Old Bulgarian; Old Church Slavonic',
        'cv' => 'Chuvash',
        'kw' => 'Cornish',
        'co' => 'Corsican',
        'cr' => 'Cree',
        'cs' => 'Czech',
        'da' => 'Danish',
        'dv' => 'Divehi; Dhivehi; Maldivian',
        'nl' => 'Dutch; Flemish',
        'dz' => 'Dzongkha',
        'en' => 'English',
        'eo' => 'Esperanto',
        'et' => 'Estonian',
        'ee' => 'Ewe',
        'fo' => 'Faroese',
        'fj' => 'Fijjian',
        'fi' => 'Finnish',
        'fr' => 'French',
        'fy' => 'Western Frisian',
        'ff' => 'Fulah',
        'ka' => 'Georgian',
        'de' => 'German',
        'gd' => 'Gaelic; Scottish Gaelic',
        'ga' => 'Irish',
        'gl' => 'Galician',
        'gv' => 'Manx',
        'el' => 'Greek, Modern',
        'gn' => 'Guarani',
        'gu' => 'Gujarati',
        'ht' => 'Haitian; Haitian Creole',
        'ha' => 'Hausa',
        'he' => 'Hebrew',
        'hz' => 'Herero',
        'hi' => 'Hindi',
        'ho' => 'Hiri Motu',
        'hu' => 'Hungarian',
        'ig' => 'Igbo',
        'is' => 'Icelandic',
        'io' => 'Ido',
        'ii' => 'Sichuan Yi',
        'iu' => 'Inuktitut',
        'ie' => 'Interlingue',
        'ia' => 'Interlingua (International Auxiliary Language Association)',
        'id' => 'Indonesian',
        'ik' => 'Inupiaq',
        'it' => 'Italian',
        'jv' => 'Javanese',
        'ja' => 'Japanese',
        'kl' => 'Kalaallisut; Greenlandic',
        'kn' => 'Kannada',
        'ks' => 'Kashmiri',
        'kr' => 'Kanuri',
        'kk' => 'Kazakh',
        'km' => 'Central Khmer',
        'ki' => 'Kikuyu; Gikuyu',
        'rw' => 'Kinyarwanda',
        'ky' => 'Kirghiz; Kyrgyz',
        'kv' => 'Komi',
        'kg' => 'Kongo',
        'ko' => 'Korean',
        'kj' => 'Kuanyama; Kwanyama',
        'ku' => 'Kurdish',
        'lo' => 'Lao',
        'la' => 'Latin',
        'lv' => 'Latvian',
        'li' => 'Limburgan; Limburger; Limburgish',
        'ln' => 'Lingala',
        'lt' => 'Lithuanian',
        'lb' => 'Luxembourgish; Letzeburgesch',
        'lu' => 'Luba-Katanga',
        'lg' => 'Ganda',
        'mk' => 'Macedonian',
        'mh' => 'Marshallese',
        'ml' => 'Malayalam',
        'mi' => 'Maori',
        'mr' => 'Marathi',
        'ms' => 'Malay',
        'mg' => 'Malagasy',
        'mt' => 'Maltese',
        'mo' => 'Moldavian',
        'mn' => 'Mongolian',
        'na' => 'Nauru',
        'nv' => 'Navajo; Navaho',
        'nr' => 'Ndebele, South; South Ndebele',
        'nd' => 'Ndebele, North; North Ndebele',
        'ng' => 'Ndonga',
        'ne' => 'Nepali',
        'nn' => 'Norwegian Nynorsk; Nynorsk, Norwegian',
        'nb' => 'Bokmål, Norwegian, Norwegian Bokmål',
        'no' => 'Norwegian',
        'ny' => 'Chichewa; Chewa; Nyanja',
        'oc' => 'Occitan, Provençal',
        'oj' => 'Ojibwa',
        'or' => 'Oriya',
        'om' => 'Oromo',
        'os' => 'Ossetian; Ossetic',
        'pa' => 'Panjabi; Punjabi',
        'fa' => 'Persian',
        'pi' => 'Pali',
        'pl' => 'Polish',
        'pt' => 'Portuguese',
        'ps' => 'Pushto',
        'qu' => 'Quechua',
        'rm' => 'Romansh',
        'ro' => 'Romanian',
        'rn' => 'Rundi',
        'ru' => 'Russian',
        'sg' => 'Sango',
        'sa' => 'Sanskrit',
        'sr' => 'Serbian',
        'hr' => 'Croatian',
        'si' => 'Sinhala; Sinhalese',
        'sk' => 'Slovak',
        'sl' => 'Slovenian',
        'se' => 'Northern Sami',
        'sm' => 'Samoan',
        'sn' => 'Shona',
        'sd' => 'Sindhi',
        'so' => 'Somali',
        'st' => 'Sotho, Southern',
        'es' => 'Spanish; Castilian',
        'sc' => 'Sardinian',
        'ss' => 'Swati',
        'su' => 'Sundanese',
        'sw' => 'Swahili',
        'sv' => 'Swedish',
        'ty' => 'Tahitian',
        'ta' => 'Tamil',
        'tt' => 'Tatar',
        'te' => 'Telugu',
        'tg' => 'Tajik',
        'tl' => 'Tagalog',
        'th' => 'Thai',
        'bo' => 'Tibetan',
        'ti' => 'Tigrinya',
        'to' => 'Tonga (Tonga Islands)',
        'tn' => 'Tswana',
        'ts' => 'Tsonga',
        'tk' => 'Turkmen',
        'tr' => 'Turkish',
        'tw' => 'Twi',
        'ug' => 'Uighur; Uyghur',
        'uk' => 'Ukrainian',
        'ur' => 'Urdu',
        'uz' => 'Uzbek',
        've' => 'Venda',
        'vi' => 'Vietnamese',
        'vo' => 'Volapük',
        'cy' => 'Welsh',
        'wa' => 'Walloon',
        'wo' => 'Wolof',
        'xh' => 'Xhosa',
        'yi' => 'Yiddish',
        'yo' => 'Yoruba',
        'za' => 'Zhuang; Chuang',
        'zu' => 'Zulu',
    );

    /**
     * 默认分页
     */
    const DEFAULT_PAGE = array( 'page' => 1, 'size' => 10 );

    /**
     * 默认排序
     */
    const DEFAULT_ORDER = array( 'order' => 'DESC', 'orderBy' => 'date' );

    /**
     * 默认排序允许
     */
    const DEFAULT_ORDER_ALLOW = array( 'ASC', 'DESC' );

    /**
     * 默认排序字段允许
     */
    const DEFAULT_ORDERBY_ALLOW = array( 'date', 'modified' );

    /**
     * 默认文章类型允许
     *
     * @var array
     */
    const DEFAULT_POST_TYPE_ALLOW = array( 'post', 'page' );

    /**
     * 默认文章状态允许
     *
     * @var array
     */
    const DEFAULT_POST_STATUS_ALLOW = array(
        'publish',
        'pending',
        'draft',
        'auto-draft',
        'future',
        'private',
        'inherit',
        'trash'
    );

    /**
     * 允许默认查询参数
     */
    const DEFAULT_QUERY_ARGS_ALLOW = array(
        'post_type',
        'post_status',
        'cat',
        'tag',
        'author',
        's',
        'meta_query',
        'orderby',
        'order',
        'paged',
        'posts_per_page',
    );

    /**
     * 默认分页
     *
     * @return array
     */
    public static function default_page(): array {
        return self::DEFAULT_PAGE;
    }

    /**
     * 默认排序
     *
     * @return array
     */
    public static function default_order(): array {
        return self::DEFAULT_ORDER;
    }

    /**
     * 默认排序允许
     *
     * @return array
     */
    public static function default_order_allow(): array {
        return self::DEFAULT_ORDER_ALLOW;
    }

    /**
     * 默认排序字段允许
     *
     * @return array
     */
    public static function default_orderby_allow(): array {
        return self::DEFAULT_ORDERBY_ALLOW;
    }

    /**
     * 默认文章类型允许
     *
     * @return array
     */
    public static function default_post_type_allow(): array {
        return self::DEFAULT_POST_TYPE_ALLOW;
    }

    /**
     * 默认文章状态允许
     *
     * @return array
     */
    public static function default_post_status_allow(): array {
        return self::DEFAULT_POST_STATUS_ALLOW;
    }

    /**
     * 允许默认查询参数
     *
     * @return array
     */
    public static function default_query_args_allow(): array {
        return self::DEFAULT_QUERY_ARGS_ALLOW;
    }

    /**
     * 获取语言列表
     *
     * @return array
     */
    public static function get_lang_list(): array {
        return self::LANG_CODES_LIST;
    }

    /**
     * 获取文章内容, 不带格式
     *
     * @param int $postId
     * @param int $max_tokens
     *
     * @return string
     */
    public static function get_clean_post_content( int $postId, int $max_tokens = 512 ) {
        $post = get_post( $postId );
        if ( ! $post ) {
            return false;
        }
        $post->post_content = apply_filters( 'the_content', $post->post_content );

        return TextHelper::clean_sentences( TextHelper::clean_text( $post->post_content ), $max_tokens );
    }

    /**
     * 获取文章语言
     *
     * @param $postId
     *
     * @return string
     */
    public static function get_post_language( $postId ): string {
        $locale     = get_locale();
        $code       = strtolower( substr( $locale, 0, 2 ) );
        $lang_codes = self::get_lang_list();
        $language   = strtr( $code, $lang_codes );
        $lang       = apply_filters( 'moredeal_post_language_details', null, $postId );
        if ( ! empty( $lang ) ) {
            $language = $lang['display_name'];
        }

        return strtolower( $language );
    }

    /**
     * 处理查询文章分页
     *
     * @param array $request
     *
     * @return void
     */
    public static function handler_query_posts_page( array &$request ) {
        if ( empty( $request['page'] ) ) {
            $request['page'] = self::default_page();
        }

        if ( ! is_array( $request['page'] ) ) {
            $request['page'] = self::default_page();
        }

        if ( empty( $request['page']['page'] ) ) {
            $request['page']['page'] = self::default_page()['page'];
        }

        if ( empty( $request['page']['size'] ) ) {
            $request['page']['size'] = self::default_page()['size'];
        }
        $page                      = $request['page'];
        $request['posts_per_page'] = $page['size'];
        $request['paged']          = $page['page'];
        unset( $request['page'] );
    }

    /**
     * 处理查询文章分页
     *
     * @param array $request
     *
     * @return void
     */
    public static function handler_query_posts_order( array &$request ) {

        if ( empty( $request['order'] ) ) {
            $request['order'] = self::default_order();
        }

        if ( ! is_array( $request['order'] ) ) {
            $request['order'] = self::default_order();
        }

        if ( empty( $request['order']['orderBy'] ) ) {
            $request['order']['orderBy'] = self::default_order()['orderBy'];
        }

        if ( empty( $request['order']['order'] ) ) {
            $request['order']['order'] = self::default_order()['order'];
        }

        $order = $request['order'];

        if ( ! in_array( $order['orderBy'], self::default_orderby_allow() ) ) {
            $order['orderBy'] = self::default_order()['orderBy'];
        }

        if ( ! in_array( $order['order'], self::default_order_allow() ) ) {
            $order['order'] = self::default_order()['order'];
        }

        $request['orderby'] = $order['orderBy'];
        $request['order']   = $order['order'];
    }

    /**
     * 处理文章查询元数据条件
     *
     * @param array $request
     *
     * @return void
     */
    public static function handler_query_posts_meta_query( array &$request ) {
        if ( empty( $request['metas'] ) ) {
            return;
        }
        $metas = $request['metas'];
        if ( ! is_array( $metas ) ) {
            unset( $request['metas'] );

            return;
        }
        $meta_query = array( "relation" => "AND" );
        foreach ( $metas as $meta ) {
            $meta_query[] = array(
                'key'   => $meta['key'],
                'value' => $meta['value'],
            );
        }
        $request['meta_query'] = $meta_query;
    }

    /**
     * 处理查询条件
     *
     * @param array $request
     * @param bool  $is_page
     *
     * @return array
     */
    public static function handler_query_posts( array $request, bool $is_page = true ): array {
        if ( $is_page ) {
            self::handler_query_posts_page( $request );
        } else {
            if ( isset( $request['paged'] ) ) {
                unset( $request['paged'] );
            }
            if ( isset( $request['posts_per_page'] ) ) {
                unset( $request['posts_per_page'] );
            }
        }
        self::handler_query_posts_order( $request );

        // 根据标题进行模糊搜索
        if ( ! empty( $request['title'] ) ) {
            $request['s'] = sanitize_text_field( $request['title'] );
            unset( $request['title'] );
        }

        // 文章类型
        if ( ! empty( $request['postType'] ) ) {
            $post_type = $request['postType'];
            if ( is_array( $post_type ) ) {
                $post_type = array_map( 'sanitize_text_field', $post_type );
            } else if ( is_string( $post_type ) ) {
                $post_type = explode( ',', sanitize_text_field( $post_type ) );
            }
            // 只允许查询文章类型
            $post_type            = self::filter_query_params( $post_type, self::default_post_type_allow(), false );
            $request['post_type'] = $post_type;
            unset( $request['postType'] );
        } else {
            $request['post_type'] = 'post';
        }

        // 文章状态
        if ( ! empty( $request['postStatus'] ) ) {
            $post_status = $request['postStatus'];
            if ( is_array( $post_status ) ) {
                $post_status = array_map( 'sanitize_text_field', $post_status );
            } else if ( is_string( $post_status ) ) {
                $post_status = explode( ',', sanitize_text_field( $post_status ) );
            }
            // 只允许查询文章状态
            $post_status            = self::filter_query_params( $post_status, self::default_post_status_allow(), false );
            $request['post_status'] = $post_status;
            unset( $request['postStatus'] );
        } else {
            $request['post_status'] = 'publish';
        }

        // 文章分类
        if ( ! empty( $request['category'] ) ) {
            $category = $request['category'];
            if ( is_array( $category ) ) {
                $request['cat'] = array_map( 'sanitize_text_field', $category );
            } else {
                $request['cat'] = explode( ',', sanitize_text_field( $category ) );
            }
            unset( $request['category'] );
        }

        // 文章标签
        if ( ! empty( $request['tag'] ) ) {
            $tag = $request['tag'];
            if ( is_array( $tag ) ) {
                $request['tag'] = array_map( 'sanitize_text_field', $tag );
            } else {
                $request['tag'] = explode( ',', sanitize_text_field( $tag ) );
            }
        }

        // 文章作者
        if ( ! empty( $request['author'] ) ) {
            $author = $request['author'];
            if ( is_array( $author ) ) {
                $request['author'] = array_map( 'sanitize_text_field', $author );
            } else {
                $request['author'] = explode( ',', sanitize_text_field( $author ) );
            }
        }

        // 文章元数据
        if ( ! empty( $request['metas'] ) ) {
            self::handler_query_posts_meta_query( $request );
        }

        // 允许过滤查询条件，排除掉不在允许查询条件数组的参数
        $request = self::filter_query_params( $request, self::default_query_args_allow() );

        return $request;
    }

    /**
     * 获取文章列表树状结构
     *
     * @param     $categories
     * @param int $parent
     *
     * @return array
     */
    public static function get_category_tree( $categories, int $parent = 0 ): array {
        $tree = array();
        foreach ( $categories as $category ) {
            if ( $category->parent == $parent ) {
                $tree[ $category->id ]           = $category;
                $tree[ $category->id ]->children = self::get_category_tree( $categories, $category->id );
            }
        }

        return $tree;
    }

    /**
     * 过滤查询参数
     *
     * @param array $params 用户提交的查询参数
     * @param array $allowed_params 允许查询的参数名数组
     * @param bool  $is_flip 是否将允许的参数名转换为键名
     *
     * @return array 经过过滤后的查询参数
     */
    private static function filter_query_params( array $params, array $allowed_params, bool $is_flip = true ): array {
        // 将允许的参数名转换为键名
        if ( $is_flip ) {
            $allowed_params = array_flip( $allowed_params );
        }

        // 过滤掉不在允许列表中的参数
        return array_intersect_key( $params, $allowed_params );
    }


}