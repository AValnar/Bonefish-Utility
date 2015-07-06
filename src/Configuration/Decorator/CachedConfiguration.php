<?php
/**
 * Copyright (C) 2015  Alexander Schmidt
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * @author     Alexander Schmidt <mail@story75.com>
 * @copyright  Copyright (c) 2015, Alexander Schmidt
 * @date       08.06.2015
 */

namespace Bonefish\Utility\Configuration\Decorator;

use Bonefish\Traits\CacheHelperTrait;
use Bonefish\Utility\Configuration\ConfigurationInterface;
use Doctrine\Common\Cache\Cache;
use Bonefish\Injection\Annotations as Bonefish;

final class CachedConfiguration implements ConfigurationInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var array
     */
    protected $configurations = [];

    use CacheHelperTrait;

    /**
     * @param ConfigurationInterface $configuration
     * @param Cache $cache
     * @Bonefish\Inject
     */
    public function __construct(ConfigurationInterface $configuration, Cache $cache)
    {
        $this->configuration = $configuration;
        $this->cache = $cache;
        $this->setCachePrefix('bonefish.config.');
    }

    /**
     * @param string $path
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getConfiguration($path)
    {
        if (!isset($this->configurations[$path])) {

            $cacheKey = $this->getCacheKey($path);
            $hit = $this->cache->fetch($cacheKey);

            if ($hit !== false) {
                return $hit;
            }

            $this->configurations[$path] = $this->configuration->getConfiguration($path);

            $this->cache->save($cacheKey, $this->configurations[$path]);
        }

        return $this->configurations[$path];
    }

    /**
     * @param ...$configurations
     * @throws \BadFunctionCallException
     * @return array
     */
    public function mergeConfigurations(...$configurations)
    {
        return $this->configuration->mergeConfigurations(...$configurations);
    }

    /**
     * @param string $path
     * @param array $data
     * @throws \InvalidArgumentException
     */
    public function writeConfiguration($path, array $data)
    {
        $this->configuration->writeConfiguration($path, $data);

        if (isset($this->configurations[$path])) {
            $this->configurations[$path] = $data;
            $cacheKey = $this->getCacheKey($path);
            $this->cache->save($cacheKey, $this->configurations[$path]);
        }
    }
}