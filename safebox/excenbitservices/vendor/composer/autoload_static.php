<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitab845175ed0e9ccc2aff33e88cb002a0
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'chillerlan\\Traits\\' => 18,
            'chillerlan\\QRCode\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'chillerlan\\Traits\\' => 
        array (
            0 => __DIR__ . '/..' . '/chillerlan/php-traits/src',
        ),
        'chillerlan\\QRCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/chillerlan/php-qrcode/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitab845175ed0e9ccc2aff33e88cb002a0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitab845175ed0e9ccc2aff33e88cb002a0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
