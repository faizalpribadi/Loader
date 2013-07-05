# Mozart - Class Loader
[![Latest Stable Version](https://poser.pugx.org/mozart/loader/v/stable.png)](https://packagist.org/packages/mozart/loader) - [![Build Status](https://travis-ci.org/FaizalPribadi/Loader.png?branch=master)](https://travis-ci.org/FaizalPribadi/Loader)

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

function findFile($file)
{
    if (file_exists($file)) {
        return @include $file;
    }

    throw new \Exception(sprintf('The file "%s" not found', $file));
}

findFile(__DIR__ . '/Framework/Mozart/Library/Loader/ClassLoader.php');
findFile(__DIR__ . '/Vendors/Symfony/Component/ClassLoader/UniversalClassLoader.php');

use Mozart\Library\Loader\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Mozart\Library\Cache\Driver\OpCache\Apc;

$loader = ClassLoader::bootstrap();
$loader->mapClass(array(
        'Mozart'        => __DIR__ . '/Framework',
        'Doctrine'      => __DIR__ . '/Vendors',
        'Symfony'       => __DIR__ . '/Vendors',
        'Psr'           => __DIR__ . '/Vendors',
        'Monolog'       => __DIR__ . '/Vendors',
        'Metadata'      => __DIR__ . '/Vendors/JMS/Metadata/src',
    ));
$loader->register();
$loader->setCache(new \Mozart\Library\Cache\Cache(new Apc()));
$loader->enableCache(true);


//TODO enable annotations parsing
AnnotationRegistry::registerLoader(function($class) use ($loader) {
        $loader->findClassFile($class);

        return class_exists($class, true);
    });
AnnotationRegistry::registerFile(__DIR__ . '/Vendors/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

```
