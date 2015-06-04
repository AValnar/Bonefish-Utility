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

namespace Bonefish\Utility\Factory;


use Bonefish\Utility\Environment;
use Bonefish\Injection\FactoryInterface;

class EnvironmentFactory implements FactoryInterface
{
    protected $allowedOptions = [
        'basePath' => 'setBasePath',
        'devMode' => 'setDevMode',
        'configurationPath' => 'setConfigurationPath',
        'packagePath' => 'setPackagePath',
        'cachePath' => 'setCachePath',
        'logPath' => 'setLogPath'
    ];

    /**
     * Return an object with fully injected dependencies
     *
     * @param array $parameters
     * @return mixed
     */
    public function create(array $parameters = [])
    {
        $environment = new Environment();

        foreach ($parameters as $key => $value)
        {
            if (array_key_exists($key, $this->allowedOptions)) {
                $method = $this->allowedOptions[$key];
                $this->{$method}($value);
            }
        }

        if ($environment->getBasePath() == null)
        {
            $basePath = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
            $environment->setBasePath($basePath);
        }

        return $environment;
    }
}