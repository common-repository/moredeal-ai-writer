<?php

namespace MoredealAiWriter\application\client;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\helpers\MarkdownHelper;
use MoredealAiWriter\application\helpers\PostHelper;
use MoredealAiWriter\application\Plugin;
use stdClass;
use WP_Query;

/**
 * WordPress restful 客户端
 *
 * @author MoredealAiWriter
 */
class WpRestfulClient extends MoredealRestfulClient {

    /**
     * 构造函数
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * 请求 host
     * @return string
     */
    public function host(): string {
        return rest_url();
    }

    /**
     * 请求 api 前缀
     * @return string
     */
    public function api_prefix(): string {
        return '/wp/v2';
    }

    /**
     * 获取文章列表
     *
     * @param array $request
     *
     * @return array
     */
    public function page_post( array $request ): array {
        try {
            // 处理请求参数
            $request = PostHelper::handler_query_posts( $request );
            // 获取查询对象
            $query = new WP_Query( $request );
            if ( ! $query->have_posts() ) {
                return $this->failure( Plugin::translation( 'no posts found' ) );
            }
            $posts = array();
            // 获取文章列表
            while ( $query->have_posts() ) {
                $query->the_post();
                $post    = array(
                    'ID'          => get_the_ID(),
                    'post_title'  => get_the_title(),
                    'post_url'    => get_permalink(),
                    'post_date'   => get_the_date(),
                    'post_type'   => get_post_type(),
                    'post_status' => get_post_status(),
                );
                $posts[] = $post;
            }


            // 获取文章总数
            $total = $query->found_posts;
            // 获取文章当前页码
            $page = $query->get( 'paged' );
            // 获取文章每页数量
            $size = $query->get( 'posts_per_page' );
            $data = array(
                'list'  => $posts,
                'total' => $total,
                'page'  => $page,
                'size'  => $size,
            );
        } catch ( Exception $e ) {
            return $this->failure( $e->getMessage() );
        }

        return $this->success( $data );
    }

    /**
     * 获取文章分类列表
     *
     * @return array
     */
    public function get_categories(): array {
        try {
            // 获取文章所有分类列表, 树状展示
            // 获取所有文章分类
            $categories = get_categories();
            // 只保留分类 id 和分类名称, slug， 父类 id
            $categories = array_map( function ( $category ) {
                $cat         = new stdClass();
                $cat->id     = $category->term_id;
                $cat->name   = $category->name;
                $cat->slug   = $category->slug;
                $cat->parent = $category->parent;

                return $cat;
            }, $categories );

            // 获取文章分类树
            $tree = PostHelper::get_category_tree( $categories );

        } catch ( Exception $e ) {
            return $this->failure( $e->getMessage() );
        }

        return $this->success( $tree );
    }

    /**
     * 创建文章
     *
     * @param array $request
     *
     * @return array
     */
    public function create_post( array $request ): array {

        // 文章标题
        if ( empty( $request['post_title'] ) ) {
            return $this->failure( Plugin::translation( 'post title is empty' ) );
        }

        // 文章内容
        if ( empty( $request['post_content'] ) ) {
            return $this->failure( Plugin::translation( 'post content is empty' ) );
        }
        // 转换 markdown 为 html
        $request['post_content'] = MarkdownHelper::markdown_to_html( $request['post_content'] );
        // 默认草稿状态
        $request['post_status'] = 'draft';
        // 默认发布类型
        $request['post_type'] = 'post';

        $result = wp_insert_post( $request, true );

        if ( is_wp_error( $result ) ) {
            return $this->failure( $result->get_error_message() );
        }

        // 根据文章 id 获取文章编辑页面链接、
        $post_link = get_edit_post_link( $result );

        // 获取链接失败
        if ( empty( $post_link ) ) {
            return $this->failure( Plugin::translation( 'create post success, but get post link fail, place go to post page to view your post.' ) );
        }
        $post_link = str_replace( '&amp;', '&', $post_link );

        return $this->success( $post_link );
    }

    /**
     * 从指定的URL下载图像，将其保存为附件，并可选地将其附加到帖子。
     *
     * @param string $url 要下载的图像的URL。
     * @param int    $post_id 可选。媒体要关联的帖子ID。
     * @param string $desc 可选。图像描述。
     *
     * @return array
     */
    public function save_image_media( string $url, int $post_id = 0, string $desc = '' ): array {

        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . "wp-admin/includes/image.php";

        $result = media_sideload_image( $url, $post_id, $desc, "src" );

        if ( is_wp_error( $result ) ) {
            return $this->failure( $result->get_error_message() );
        }

        return $this->success( $result );
    }

}