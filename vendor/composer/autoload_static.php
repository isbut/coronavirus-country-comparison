<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit84062104898bd283c20d54a756a52b16
{
    public static $files = array (
        '7c713e393ad7d128eaa13ada7d87f0a4' => __DIR__ . '/../..' . '/app/Helpers/Common.php',
    );

    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $prefixesPsr0 = array (
        'B' => 
        array (
            'Bramus' => 
            array (
                0 => __DIR__ . '/..' . '/bramus/router/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit84062104898bd283c20d54a756a52b16::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit84062104898bd283c20d54a756a52b16::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit84062104898bd283c20d54a756a52b16::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
