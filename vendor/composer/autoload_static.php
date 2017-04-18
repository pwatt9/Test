<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8ee4e299ea8498b33cc8be64190194d8
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'League\\Plates\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'League\\Plates\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/plates/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8ee4e299ea8498b33cc8be64190194d8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8ee4e299ea8498b33cc8be64190194d8::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
