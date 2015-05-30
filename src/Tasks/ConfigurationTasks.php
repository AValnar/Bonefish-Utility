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
use Bonefish\Utility\Bootstrap\TaskRunner;
use Bonefish\Utility\ConfigurationManager;
use Bonefish\Utility\Environment;

class ConfigurationTasks implements Task
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
     * @var TaskRunner
     * @Bonefish\Inject
     */
    public $taskRunner;

    /**
     * Run this specific task
     *
     * @return bool Return if task was successful
     */
    public function runTask()
    {
        $configurationPath = $this->environment->getFullConfigurationPath();
        $configuration = $this->configurationManager->getConfiguration($configurationPath . '/Configuration.neon');

        if (!isset($configuration['tasks'])) {
            return true;
        }

        foreach($configuration['tasks'] as $taskClassName)
        {
            /** @var Task $task */
            $task = $this->container->create($taskClassName);
            $this->taskRunner->addTask($task);
        }

        return true;
    }

}