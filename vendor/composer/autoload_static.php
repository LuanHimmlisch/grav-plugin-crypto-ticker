<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdfc465ac782ddb4d5aa8c1d2ab0012ee
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Grav\\Plugin\\CryptoTicker\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Grav\\Plugin\\CryptoTicker\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Grav\\Plugin\\CryptoTickerPlugin' => __DIR__ . '/../..' . '/crypto-ticker.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdfc465ac782ddb4d5aa8c1d2ab0012ee::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdfc465ac782ddb4d5aa8c1d2ab0012ee::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdfc465ac782ddb4d5aa8c1d2ab0012ee::$classMap;

        }, null, ClassLoader::class);
    }
}
