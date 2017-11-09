<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb11654868c2e511cde516c1e985d794d
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Process\\' => 26,
            'Symfony\\Component\\OptionsResolver\\' => 34,
        ),
        'M' => 
        array (
            'Medoo\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..',
        ),
        'Symfony\\Component\\OptionsResolver\\' => 
        array (
            0 => __DIR__ . '/..',
        ),
        'Medoo\\' => 
        array (
            0 => __DIR__ . '/..',
        ),
    );

    public static $fallbackDirsPsr0 = array (
        0 => __DIR__ . '/..',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb11654868c2e511cde516c1e985d794d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb11654868c2e511cde516c1e985d794d::$prefixDirsPsr4;
            $loader->fallbackDirsPsr0 = ComposerStaticInitb11654868c2e511cde516c1e985d794d::$fallbackDirsPsr0;

        }, null, ClassLoader::class);
    }
}