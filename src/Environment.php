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

class Environment
{

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $packagePath = '/Packages';

    /**
     * @var string
     */
    protected $configurationPath = '/Configuration';

    /**
     * @var string
     */
    protected $cachePath = '/Cache';

    /**
     * @var string
     */
    protected $logPath  = '/Log';

    /**
     * @var bool
     */
    protected $devMode;

    /**
     * @return boolean
     */
    public function isDevMode()
    {
        return $this->devMode;
    }

    /**
     * @param boolean $devMode
     * @return self
     */
    public function setDevMode($devMode)
    {
        $this->devMode = $devMode;
        return $this;
    }

    /**
     * @param string $basePath
     * @return self
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param string $packagePath
     * @return self
     */
    public function setPackagePath($packagePath)
    {
        $this->packagePath = $packagePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getPackagePath()
    {
        return $this->packagePath;
    }

    /**
     * @return string
     */
    public function getFullPackagePath()
    {
        return $this->basePath . $this->packagePath;
    }

    /**
     * @param string $configurationPath
     * @return self
     */
    public function setConfigurationPath($configurationPath)
    {
        $this->configurationPath = $configurationPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfigurationPath()
    {
        return $this->configurationPath;
    }

    /**
     * @return string
     */
    public function getFullConfigurationPath()
    {
        return $this->basePath . $this->configurationPath;
    }

    /**
     * @param string $logPath
     * @return self
     */
    public function setLogPath($logPath)
    {
        $this->logPath = $logPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogPath()
    {
        return $this->logPath;
    }

    /**
     * @return string
     */
    public function getFullLogPath()
    {
        return $this->basePath . $this->logPath;
    }

    /**
     * @param string $cachePath
     * @return self
     */
    public function setCachePath($cachePath)
    {
        $this->cachePath = $cachePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getCachePath()
    {
        return $this->cachePath;
    }

    /**
     * @return string
     */
    public function getFullCachePath()
    {
        return $this->basePath . $this->cachePath;
    }
}