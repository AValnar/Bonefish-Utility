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

namespace Bonefish\Utility\Configuration;

use Bonefish\Injection\Annotations as Bonefish;

class ConfigurationManager implements ConfigurationManagerInterface
{

    /**
     * @var \Nette\Neon\Neon
     * @Bonefish\Inject
     */
    public $neon;


    /**
     * @param string $path
     * @param bool $useCache
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getConfiguration($path, $useCache = true)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException('Configuration ' . $path . ' does not exist!');
        }
        $config = file_get_contents($path);

        return $this->neon->decode($config);
    }

    /**
     * @param ...$configurations
     * @throws \BadFunctionCallException
     * @return array
     */
    public function mergeConfigurations(...$configurations)
    {
        if (count($configurations) < 2) {
            throw new \BadFunctionCallException('At least two configurations have to be supplied to merge.');
        }

        return array_merge_recursive(...$configurations);
    }

    /**
     * @param string $path
     * @param array $data
     * @throws \InvalidArgumentException
     */
    public function writeConfiguration($path, array $data)
    {
        $file = $this->neon->encode($data, 1);

        file_put_contents($path, $file);
    }
} 