<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc34673f28de77716fffd4fc05531c6e9
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'cybot\\cookiebot\\tests\\' => 22,
            'cybot\\cookiebot\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'cybot\\cookiebot\\tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'cybot\\cookiebot\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc34673f28de77716fffd4fc05531c6e9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc34673f28de77716fffd4fc05531c6e9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc34673f28de77716fffd4fc05531c6e9::$classMap;

        }, null, ClassLoader::class);
    }
}
