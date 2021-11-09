<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3984b2450fa548e64cdb8f2e14618af3
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Debug\\' => 24,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Debug\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/debug',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3984b2450fa548e64cdb8f2e14618af3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3984b2450fa548e64cdb8f2e14618af3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3984b2450fa548e64cdb8f2e14618af3::$classMap;

        }, null, ClassLoader::class);
    }
}