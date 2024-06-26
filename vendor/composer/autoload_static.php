<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9928fe14f47aa41d7486b39f3baa42b8
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'R0aringthunder\\RampApi\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'R0aringthunder\\RampApi\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit9928fe14f47aa41d7486b39f3baa42b8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9928fe14f47aa41d7486b39f3baa42b8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9928fe14f47aa41d7486b39f3baa42b8::$classMap;

        }, null, ClassLoader::class);
    }
}
