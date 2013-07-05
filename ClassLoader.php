<?php
namespace Mozart\Library\Loader;

/*
 * This file is a part of Mozart PHP Small MVC Framework
 *
 * (c) Faizal Pribadi <faizal_pribadi@aol.com>
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * file that was distributed with this source code.
 */

use Mozart\Library\Cache\Cache;
use Mozart\Library\Cache\Compressed\CacheFlags;
use Symfony\Component\ClassLoader\UniversalClassLoader;

/**
 * Class ClassLoader
 *
 * @package Mozart\Library\Loader
 * @author Faizal Pribadi <faizal_pribadi@aol.com>
 */
class ClassLoader
{
    /**
     * Constant TRUE
     */
    const REGISTER_CLASS = true;

    /**
     * Default Cache
     */
    const DEFAULT_CACHE = 'my.cache';

    /**
     * @var \Symfony\Component\ClassLoader\UniversalClassLoader
     */
    protected $loader;

    protected $cache;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->loader = new UniversalClassLoader();
    }

    /**
     * Adding the namespaces of class to include
     *
     * @param  array      $namespaces
     * @throws \Exception
     */
    public function mapClass(array $namespaces)
    {
        if (!is_array($namespaces)) {
            throw new \Exception(sprintf('class argument has been on array, argument "%s" has not defined', $namespaces));
        }

        $this->loader->registerNamespaces($namespaces);
    }

    /**
     * Find the file if class of file is exist
     *
     * @param  string      $class
     * @return null|string
     */
    public function findClassFile($class)
    {
        $this->loader->findFile($class);
    }

    /**
     * Register the namespaces of class
     */
    public function register()
    {
        if (ClassLoader::REGISTER_CLASS) {
            $this->loader->register();
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function bootstrap()
    {
        return new static();
    }

    /**
     * Set and enable cache driver
     *
     * @param Cache $cache
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return Cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Enable cache autoload script
     *
     * @param bool $prefend
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function enableCache($prefend = true)
    {
        if ($prefend) {
            $this->cache->set(
                self::DEFAULT_CACHE,
                sprintf('enable cache from class "%s"', 'Mozart\Library\Loader\ClassLoader'),
                CacheFlags::CACHE_LIFETIME
            );
            if ($this->cache->get(self::DEFAULT_CACHE) > 3600 * 2 /2) {
                return $this->cache->flush();
            }
        } else {
            throw new \Exception('not enable cache for you are load class');
        }
    }
}
