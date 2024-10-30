<?php

namespace MoredealAiWriter\application\helpers;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionException;

defined( '\ABSPATH' ) || exit;

/**
 * Class ClassHelper
 *
 * @author MoredealAiWriter
 */
class ClassHelper {

    function getSubclassesInPackage($abstractClassName, $packageNamespace, $packagePath): array {
        $subclasses = array();

        // 获取指定目录下的所有文件
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($packagePath));

        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }

            // 获取文件路径和类名
            $filePath = $file->getPathname();
            $className = $packageNamespace . '\\' . str_replace([$packagePath, '/', '.php'], ['', '\\', ''], $filePath);

            // 检查类是否存在，并且是抽象类的子类
            if (class_exists($className) && is_subclass_of($className, $abstractClassName)) {
                $subclasses[] = $className;
            }
        }

        return $subclasses;
    }

}