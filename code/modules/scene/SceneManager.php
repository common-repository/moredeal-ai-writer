<?php

namespace MoredealAiWriter\code\modules\scene;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;

/**
 * 扩展管理
 * 场景管理
 *
 * @author MoredealAiWriter
 */
class SceneManager {

    /**
     * 默认场景类
     */
    const DEFAULT_SCENE_LIST = array(
        WPAdminSceneModule::class,
        WPShortCodeSceneModule::class,
        WPTemplateMarketSceneModule::class,
        WPAdminTemplateMarketSceneModule::class
    );

    /**
     * 默认场景类list
     * @return string[]
     */
    private static function default_scene_list(): array {
        return self::DEFAULT_SCENE_LIST;
    }

    /**
     * 特殊场景
     *
     * @return array
     */
    public static function wp_refinement_scenes(): array {
        return array(
            'WPMetaBoxSceneModule'    => array(
                'Titles'   => array(
                    'name'             => Plugin::translation( 'Post Meta Box Titles' ),
                    'description'      => Plugin::translation( 'In the Wordpress Post Editor Meta Box, regenerate the article title scene based on the article content summary.' ),
                    'key_suffix'       => 'Titles',
                    'default_template' => 'post_title',
                ),
                'Excerpts' => array(
                    'name'             => Plugin::translation( 'Post Meta Box Excerpts' ),
                    'description'      => Plugin::translation( 'In the Wordpress Post Editor Meta Box, regenerate the article excerpt scene based on the article content summary.' ),
                    'key_suffix'       => 'Excerpts',
                    'default_template' => 'post_excerpt',
                ),
            ),
            'WPBlockRightSceneModule' => array(
                'Translate_Text'   => array(
                    'name'             => Plugin::translation( 'Post Block Right Translate Text' ),
                    'description'      => Plugin::translation( 'In the Wordpress Post Block Editor Toolbar, right click Translate Text Scene.' ),
                    'key_suffix'       => 'Translate_Text',
                    'default_template' => 'translate_text',
                ),
                'Improve_Writing'  => array(
                    'name'             => Plugin::translation( 'Post Block Right Improve Writing' ),
                    'description'      => Plugin::translation( 'In the Wordpress Post Block Editor Toolbar, right click Improve Writing Scene.' ),
                    'key_suffix'       => 'Improve_Writing',
                    'default_template' => 'improve_writing',
                ),
                'Make_Longer'      => array(
                    'name'             => Plugin::translation( 'Post Block Right Make Longer' ),
                    'description'      => Plugin::translation( 'In the Wordpress Post Block Editor Toolbar, right click Make Longer Scene.' ),
                    'key_suffix'       => 'Make_Longer',
                    'default_template' => 'make_longer',
                ),
                'Summarize_Text'   => array(
                    'name'             => Plugin::translation( 'Post Block Right Summarize Text' ),
                    'description'      => Plugin::translation( 'In the Wordpress Post Block Editor Toolbar, right click Summarize Text Scene.' ),
                    'key_suffix'       => 'Summarize_Text',
                    'default_template' => 'summarize_text',
                ),
                'Continue_Writing' => array(
                    'name'             => Plugin::translation( 'Post Block Right Continue Writing' ),
                    'description'      => Plugin::translation( 'In the Wordpress Post Block Editor Toolbar, right click Continue Writing Scene.' ),
                    'key_suffix'       => 'Continue_Writing',
                    'default_template' => 'continue_writing',
                ),
                'Summarize_Table'  => array(
                    'name'             => Plugin::translation( 'Post Block Right Summarize Table' ),
                    'description'      => Plugin::translation( 'In the Wordpress Post Block Editor Toolbar, right click Summarize Table Scene.' ),
                    'key_suffix'       => 'Summarize_Table',
                    'default_template' => 'summarize_table',
                ),
                'Generate_Table'   => array(
                    'name'             => Plugin::translation( 'Post Block Right Generate Table' ),
                    'description'      => Plugin::translation( 'In the Wordpress Post Block Editor Toolbar, right click Generate Table Scene.' ),
                    'key_suffix'       => 'Generate_Table',
                    'default_template' => 'generate_table',
                ),
            ),

        );
    }

    /**
     * 根据场景 key 获取场景信息
     *
     * @param string $scene_key
     * @param string $key_suffix
     *
     * @return mixed|null
     */
    public static function get_refinement_scene( string $scene_key, string $key_suffix = '' ) {
        foreach ( self::wp_refinement_scenes() as $scene_type => $scene_type_scenes ) {
            if ( $scene_type == $scene_key ) {
                foreach ( $scene_type_scenes as $scene ) {
                    if ( $scene['key_suffix'] == $key_suffix ) {
                        return $scene;
                    }
                }
            }
        }

        return null;
    }

    /**
     * 获取默认场景
     *
     * @return array
     */
    public static function default_scenes(): array {
        $default_scenes = array();
        foreach ( self::default_scene_list() as $index => $item ) {
            /**
             * @var $item AbstractSceneModule
             */
            $default_scenes[ $index ] = $item::of();
        }

        return $default_scenes;
    }

    /**
     * 获取 scenes 并且，如果没有默认 场景，添加默认场景
     *
     * @param array $scenes_keys
     *
     * @return array
     * @throws Exception
     */
    public static function handler_scenes( array $scenes_keys ): array {
        $result      = array();
        $scenes_keys = self::handler_scene_keys( $scenes_keys );
        foreach ( $scenes_keys as $index => $scenes_key ) {
            $result[ $index ] = self::factoryScene( $scenes_key );
        }

        return $result;
    }

    /**
     * 向默认场景中添加新非默认的场景的场景
     *
     * @param array $params
     *
     * @return array
     */
    public static function default_scenes_push( array $params ): array {
        $scenes = self::default_scenes();
        if ( empty( $params ) ) {
            return $scenes;
        }

        foreach ( $params as $item ) {
            $var = self::get_refinement_scene( $item['type'], $item['suffix_key'] );
            if ( $var == null ) {
                continue;
            }
            if ( $item['type'] == WPBlockRightSceneModule::getModuleKey() ) {
                $scenes[] = WPBlockRightSceneModule::of( $var['name'], $var['description'], $var['key_suffix'], $var['default_template'] );
            } else if ( $item['type'] == WPMetaBoxSceneModule::getModuleKey() ) {
                $scenes[] = WPMetaBoxSceneModule::of( $var['name'], $var['description'], $var['key_suffix'], $var['default_template'] );
            }
        }

        return $scenes;
    }

    /**
     * 向默认场景中添加新非默认的场景的场景, 添加一个
     *
     * @param string $type 场景类型
     * @param string $suffix_key 场景后缀
     *
     * @return array
     */
    public static function default_scenes_push_one( string $type, string $suffix_key ): array {
        return self::default_scenes_push( array( array( 'type' => $type, 'suffix_key' => $suffix_key ) ) );
    }

    /**
     * 获取默认场景的 key 的集合
     *
     * @return array
     */
    public static function default_scene_keys(): array {
        $default_scenes_keys = array();
        foreach ( self::default_scene_list() as $index => $item ) {
            /**
             * @var $item AbstractSceneModule
             */
            $default_scenes_keys[ $index ] = $item::of_scene_key();
        }

        return $default_scenes_keys;
    }

    /**
     * 处理场景, 如果场景列表里面没有包含默认场景key，则添加默认场景key
     *
     * @param array $scenes_keys
     *
     * @return array 包含默认场景 key 的场景 key 的数组
     */
    public static function handler_scene_keys( array $scenes_keys ): array {
        $default_scene_keys = self::default_scene_keys();
        if ( empty( $scenes_keys ) ) {
            return $default_scene_keys;
        }

        // 如果未包含默认场景，则添加默认场景
        foreach ( $default_scene_keys as $default_scene_key ) {
            if ( ! in_array( $default_scene_key, $scenes_keys ) ) {
                array_unshift( $scenes_keys, $default_scene_key );
            }
        }

        $scenes_keys = array_values( $scenes_keys );

        return array_filter( $scenes_keys, function ( $scene ) {
            return ! empty( $scene );
        } );
    }

    /**
     * 获取所有场景的 info 信息
     *
     * @param bool $excludeDefault 是否排除掉默认场景
     *
     * @return array
     */
    public static function get_scenes_info( bool $excludeDefault = false ): array {
        $scenes = array();
        if ( ! $excludeDefault ) {
            foreach ( self::default_scene_list() as $index => $item ) {
                /**
                 * @var $item AbstractSceneModule
                 */
                $scenes[ $index ] = $item::of()->get_info();
            }
        }

        // 处理 扩展场景
        foreach ( self::wp_refinement_scenes() as $scene_type => $scene_type_scenes ) {
            foreach ( $scene_type_scenes as $scene ) {
                if ( $scene_type == WPBlockRightSceneModule::getModuleKey() ) {
                    $scenes[] = WPBlockRightSceneModule::of( $scene['name'], $scene['description'], $scene['key_suffix'], $scene['default_template'] )->get_info();
                } else if ( $scene_type == WPMetaBoxSceneModule::getModuleKey() ) {
                    $scenes[] = WPMetaBoxSceneModule::of( $scene['name'], $scene['description'], $scene['key_suffix'], $scene['default_template'] )->get_info();
                }
            }
        }

        return array_values( $scenes );
    }

    /**
     * 根据场景列表获取该场景列表的所有的场景 key
     *
     * @param array{AbstractSceneModule} $scenes
     *
     * @return array
     */
    public static function get_scene_keys( array $scenes ): array {
        if ( empty( $scenes ) ) {
            return self::default_scene_keys();
        }

        return array_column( $scenes, 'key' );
    }

    /**
     * 根据类型获取场景工厂
     *
     * @param $scene
     *
     * @return mixed
     * @throws Exception
     */
    public static function factoryByKey( $scene ) {

        if ( empty( $scene ) ) {
            throw new Exception( 'scene is required' );
        }

        if ( ! isset( $scene->key ) ) {
            throw new Exception( 'scene key type is required' );
        }

        $key  = $scene->key;
        $keys = explode( '_', $key );
        if ( count( $keys ) < 1 ) {
            throw new Exception( 'scene key type is required' );
        }
        // 取第一个
        $key        = array_shift( $keys );
        $key_suffix = implode( '_', $keys );
        // 向 $scene 中添加 key_suffix
        $scene->key_suffix = $key_suffix;
        $scene_base_class  = 'MoredealAiWriter\\code\\modules\\scene\\' . $key;
        if ( class_exists( $scene_base_class ) ) {
            /**
             * @var AbstractSceneModule $scene_base_class
             */
            try {
                $base_scene = $scene_base_class::factoryObject( $scene );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }

            return $base_scene;
        }

        $scene_ext_class = 'MoredealAiWriter\\extend\\modules\\scene\\' . $key;
        if ( class_exists( $scene_ext_class ) ) {
            try {
                $ext_scene = $scene_ext_class::factoryObject( $scene );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }

            return $ext_scene;
        }
        throw new Exception( $scene->key . ' scene key is not exist' );

    }

    /**
     * @param        $key
     *
     * @return mixed|AbstractSceneModule
     * @throws Exception
     */
    public static function factoryScene( $key ) {

        if ( empty( $key ) ) {
            throw new Exception( 'scene key is required' );
        }

        if ( in_array( $key, self::default_scene_keys() ) ) {
            $scene_base_class = 'MoredealAiWriter\\code\\modules\\scene\\' . $key;
            if ( class_exists( $scene_base_class ) ) {
                /**
                 * @var $scene_base_class AbstractSceneModule
                 */
                return $scene_base_class::new();
            }

            $scene_ext_class = 'MoredealAiWriter\\extend\\modules\\scene\\' . $key;
            if ( class_exists( $scene_ext_class ) ) {
                try {
                    $ext_scene = $scene_ext_class::new();
                } catch ( Exception $e ) {
                    throw new Exception( $e->getMessage() );
                }

                return $ext_scene;
            }
        }

        $keys = explode( '_', $key );
        if ( count( $keys ) < 1 ) {
            throw new Exception( 'scene key type is required' );
        }
        // 取第一个
        $key        = array_shift( $keys );
        $key_suffix = implode( '_', $keys );
        $scene_data = self::get_refinement_scene( $key, $key_suffix );
        if ( $scene_data == null ) {
            throw new Exception( $key . '_' . $key_suffix . " is not exist" );
        }
        $scene_base_class = 'MoredealAiWriter\\code\\modules\\scene\\' . $key;
        if ( class_exists( $scene_base_class ) ) {
            /**
             * @var $scene_base_class AbstractSceneModule
             */
            return $scene_base_class::of( $scene_data['name'], $scene_data['description'], $scene_data['key_suffix'], $scene_data['default_template'] );
        }

        $scene_ext_class = 'MoredealAiWriter\\extend\\modules\\scene\\' . $key;
        if ( class_exists( $scene_ext_class ) ) {
            try {
                $ext_scene = $scene_ext_class::of( $scene_data['name'], $scene_data['description'], $scene_data['key_suffix'], $scene_data['default_template'] );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }

            return $ext_scene;
        }
        throw new Exception( $key . ' scene key is not exist' );
    }

}