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


final class TaskRunner implements TaskRunnerInterface
{
    /**
     * @var Task[]
     */
    protected $tasks;

    /**
     * @return Task
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task[] $tasks
     * @return self
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
        return $this;
    }

    /**
     * @param Task $task
     * @return self
     */
    public function addTask($task)
    {
        $this->tasks[] = $task;
        return $this;
    }

    public function execute()
    {
        /** @var Task $task */
        foreach($this->getTasks() as $key => $task)
        {
            if (!$task->runTask()) {
                throw new \RuntimeException('Task #' . $key .' ' . get_class($task) . ' failed.');
            }

            unset($this->tasks[$key]);
        }
    }
}