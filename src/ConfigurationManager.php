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
 * @date       29.05.2015
 */

namespace Bonefish\Utility;


use Bonefish\Traits\DoctrineCacheTrait;
use Doctrine\Common\Cache\Cache;

class ConfigurationManager
{

    use DoctrineCacheTrait;

    /**
     * @var array
     */
    protected $configurations = array();


    /**
     * @var \Nette\Neon\Neon
     * @Bonefish\Inject
     */
    public $neon;

    /**
     * @var string
     */
    protected $cachePrefix = 'bonefish.config';


    /**
     * @param Cache $cache
     */
    public function __construct(Cache $cache = null)
    {
        $this->cache = $cache;
    }


    /**
     * @param string $path
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getConfiguration($path)
    {
        if (!isset($this->configurations[$path])) {

            if ($this->cache !== null) {
                $cacheKey = $this->getCacheKey($path);
                $hit = $this->cache->fetch($cacheKey);

                if ($hit !== false) {
                    return $hit;
                }
            }

            if (!file_exists($path)) {
                throw new \InvalidArgumentException('Configuration ' . $path . ' does not exist!');
            }
            $config = file_get_contents($path);
            $this->configurations[$path] = $this->neon->decode($config);

            if ($this->cache !== null) {
                $this->cache->save($cacheKey, $this->configurations[$path]);
            }
        }
        return $this->configurations[$path];
    }



    /**
     * @param string $path
     * @param string $data
     * @throws \InvalidArgumentException
     */
    public function writeConfiguration($path, $data)
    {
        $file = $this->neon->encode($data, 1);

        file_put_contents($path, $file);

        if (isset($this->configurations[$path])) {
            $this->configurations[$path] = $data;
            if ($this->cache !== null) {
                $cacheKey = $this->getCacheKey($path);
                $this->cache->save($cacheKey, $this->configurations[$path]);
            }
        }
    }
} 