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
     * @var \Symfony\Component\ClassLoader\UniversalClassLoader
     */
    protected $loader;

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
     * Enable debugging cache and store key of cache
     * if lifetime of cache less than limited flush automatic
     *
     * @param   bool       $enable
     * @return  ApcCache
     * @throws  \Exception
     */
    public function enableCache($enable = true)
    {
        if (!function_exists('apc_cache_info') && !extension_loaded('apc')) {
            throw new \Exception(
                sprintf('doest not find cache "%s" , fix this to clear', 'APC')
            );
        }

        if ($enable) {
            $this->addCache('class.cache',
                sprintf('Enable class loader cache from "%s"', 'Mozart\\Library\\Loader\\ClassLoader'),
                $lifeTime = 3600
            );

            if ($this->hasCache('class.cache') && $this->fetchCache('class.cache') > $lifeTime) {
                return $this->flushCache();
            }
        } else {
            throw new \InvalidArgumentException('invalid argument to enable cache');
        }
    }

    /**
     * Adding and save the storing cache parameters
     *
     * @param   string  $id
     * @param   null    $content
     * @param   int     $lifeTime
     * @return  bool
     */
    protected function addCache($id, $content = null, $lifeTime = 0)
    {
        return (Boolean) apc_store($id, $content, $lifeTime);
    }

    /**
     * Flushing cache if contains the key of cache exist
     *
     * @return bool
     */
    protected function flushCache()
    {
        return apc_clear_cache();
    }

    /**
     * Fetch the id key of string cache parameter
     *
     * @param  string $id
     * @return null
     */
    protected function fetchCache($id)
    {
        return apc_fetch($id) ? : null;
    }

    /**
     * Has cache string id key
     *
     * @param  string         $id
     * @return bool|\string[]
     */
    protected function hasCache($id)
    {
        return apc_exists($id);
    }
}
