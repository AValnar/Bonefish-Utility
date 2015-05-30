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

namespace Bonefish\Utility\Tasks;

use Bonefish\Injection\ContainerInterface;
use Bonefish\Utility\Bootstrap\Task;
use Bonefish\Utility\ConfigurationManager;
use Bonefish\Utility\Environment;

class RegisterContainerImplementations implements Task
{
    /**
     * @var Environment
     * @Bonefish\Inject
     */
    public $environment;

    /**
     * @var ConfigurationManager
     * @Bonefish\Inject
     */
    public $configurationManager;

    /**
     * @var ContainerInterface
     * @Bonefish\Inject
     */
    public $container;

    /**
     * Run this specific task
     *
     * @return bool Return if task was successful
     */
    public function runTask()
    {
        $configurationPath = $this->environment->getFullConfigurationPath();
        $configuration = $this->configurationManager->getConfiguration($configurationPath . '/Configuration.neon');

        foreach($configuration['implementations'] as $interface => $implementation)
        {
            $this->container->setInterfaceImplementation($interface, $implementation);
        }

        return true;
    }

}