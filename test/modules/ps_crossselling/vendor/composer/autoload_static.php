<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdc9699091f96c8ff4cbd27bc61c2f04a
{
    public static $classMap = array (
        'Ps_Crossselling' => __DIR__ . '/../..' . '/ps_crossselling.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitdc9699091f96c8ff4cbd27bc61c2f04a::$classMap;

        }, null, ClassLoader::class);
    }
}
