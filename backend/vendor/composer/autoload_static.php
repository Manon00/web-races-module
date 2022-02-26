<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2b5123b5379b55fab4558a5765b77ecf
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2b5123b5379b55fab4558a5765b77ecf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2b5123b5379b55fab4558a5765b77ecf::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2b5123b5379b55fab4558a5765b77ecf::$classMap;

        }, null, ClassLoader::class);
    }
}