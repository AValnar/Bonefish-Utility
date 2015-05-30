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

namespace Bonefish\Utility\Bootstrap;


use Bonefish\Injection\ContainerInterface;
use Bonefish\Utility\ConfigurationManager;
use Bonefish\Utility\Environment;
use Bonefish\Utility\Tasks\ConfigurationTasks;
use Bonefish\Utility\Tasks\RegisterContainerImplementations;

class Bootstrap
{
    /**
     * @var TaskRunner
     * @Bonefish\Inject
     */
    public $taskRunner;

    /**
     * @var ContainerInterface
     * @Bonefish\Inject
     */
    public $container;

    public function bootstrap()
    {
        /** @var RegisterContainerImplementations $registerContainerImplementationsTask */
        $registerContainerImplementationsTask = $this->container->create(RegisterContainerImplementations::class);
        $this->taskRunner->addTask($registerContainerImplementationsTask);

        /** @var ConfigurationTasks $configurationTasks */
        $configurationTasks = $this->container->create(ConfigurationTasks::class);
        $this->taskRunner->addTask($configurationTasks);

        $this->taskRunner->execute();
    }
}