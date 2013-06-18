# Mozart - Class Loader - Master [v0.1.0] : [![Build Status](https://travis-ci.org/FaizalPribadi/Loader.png?branch=master)](https://travis-ci.org/FaizalPribadi/Loader)

Mozart Class Loader Extending API Core Component Of "ClassLoader" From Symfony2

installation with composer
==========================
```php
$ curl -s http://getcomposer.org/installer | php
$ php composer.phar require mozart/loader	// next typing "dev-master"
```

installation with git
=====================
```php
$ git clone https://github.com/FaizalPribadi/Loader.git /path/to/your-vendor/Loader
```

usage
=====
```php
<?php
function findFile($file)
{
    if (file_exists($file)) {
        return @include $file;
    }

    throw new \Exception(sprintf('The file "%s" not found', $file));
}

findFile(__DIR__ . '/path-to/Mozart/Library/Loader/ClassLoader.php');
findFile(__DIR__ . '/path-to/Vendors/Symfony/Component/ClassLoader/UniversalClassLoader.php');


use Mozart\Library\Loader\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = new ClassLoader();
$loader->mapClass(array(
        'Mozart'        => __DIR__ . '/Framework',
        'Doctrine'      => __DIR__ . '/Vendors',
        'Symfony'       => __DIR__ . '/Vendors',
        'Psr'           => __DIR__ . '/Vendors',
        'Monolog'       => __DIR__ . '/Vendors',
        'Zend'          => __DIR__ . '/Vendors',
        'AnotherVendor' => __DIR__ . '/Vendors',
    ));

$loader->enableCache(true);     // if you're enable cache with APC
$loader->register();

// if you're parsing annotations with doctrine add this line into you're autoload script
//TODO enable annotations parsing
AnnotationRegistry::registerLoader(function($class) use($loader) {
        $loader->findClassFile($class);
        return class_exists($class, true);
    });
AnnotationRegistry::registerFile(__DIR__ . '/path-to/Vendors/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
```
