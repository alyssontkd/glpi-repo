<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7f6837312d20027ca8a5ce941957c650
{
    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'Zend\\Loader\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Zend\\Loader\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-loader/src',
        ),
    );

    public static $classMap = array (
        'Zend\\Loader\\AutoloaderFactory' => __DIR__ . '/..' . '/zendframework/zend-loader/src/AutoloaderFactory.php',
        'Zend\\Loader\\ClassMapAutoloader' => __DIR__ . '/..' . '/zendframework/zend-loader/src/ClassMapAutoloader.php',
        'Zend\\Loader\\Exception\\BadMethodCallException' => __DIR__ . '/..' . '/zendframework/zend-loader/src/Exception/BadMethodCallException.php',
        'Zend\\Loader\\Exception\\DomainException' => __DIR__ . '/..' . '/zendframework/zend-loader/src/Exception/DomainException.php',
        'Zend\\Loader\\Exception\\ExceptionInterface' => __DIR__ . '/..' . '/zendframework/zend-loader/src/Exception/ExceptionInterface.php',
        'Zend\\Loader\\Exception\\InvalidArgumentException' => __DIR__ . '/..' . '/zendframework/zend-loader/src/Exception/InvalidArgumentException.php',
        'Zend\\Loader\\Exception\\InvalidPathException' => __DIR__ . '/..' . '/zendframework/zend-loader/src/Exception/InvalidPathException.php',
        'Zend\\Loader\\Exception\\MissingResourceNamespaceException' => __DIR__ . '/..' . '/zendframework/zend-loader/src/Exception/MissingResourceNamespaceException.php',
        'Zend\\Loader\\Exception\\PluginLoaderException' => __DIR__ . '/..' . '/zendframework/zend-loader/src/Exception/PluginLoaderException.php',
        'Zend\\Loader\\Exception\\RuntimeException' => __DIR__ . '/..' . '/zendframework/zend-loader/src/Exception/RuntimeException.php',
        'Zend\\Loader\\Exception\\SecurityException' => __DIR__ . '/..' . '/zendframework/zend-loader/src/Exception/SecurityException.php',
        'Zend\\Loader\\ModuleAutoloader' => __DIR__ . '/..' . '/zendframework/zend-loader/src/ModuleAutoloader.php',
        'Zend\\Loader\\PluginClassLoader' => __DIR__ . '/..' . '/zendframework/zend-loader/src/PluginClassLoader.php',
        'Zend\\Loader\\PluginClassLocator' => __DIR__ . '/..' . '/zendframework/zend-loader/src/PluginClassLocator.php',
        'Zend\\Loader\\ShortNameLocator' => __DIR__ . '/..' . '/zendframework/zend-loader/src/ShortNameLocator.php',
        'Zend\\Loader\\SplAutoloader' => __DIR__ . '/..' . '/zendframework/zend-loader/src/SplAutoloader.php',
        'Zend\\Loader\\StandardAutoloader' => __DIR__ . '/..' . '/zendframework/zend-loader/src/StandardAutoloader.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7f6837312d20027ca8a5ce941957c650::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7f6837312d20027ca8a5ce941957c650::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7f6837312d20027ca8a5ce941957c650::$classMap;

        }, null, ClassLoader::class);
    }
}
