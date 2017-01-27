<?php

namespace Avoxx\Config;

/*
 * AVOXX- PHP Framework Components
 *
 * @author    Merlin Christen <merloxx@avoxx.org>
 * @author    Hossam Youssef <hossam.mox@gmail.com>
 * @copyright Copyright (c) 2016 - 2017 Merlin Christen
 * @copyright Copyright (c) 2016 - 2017 Hossam Youssef
 * @license   The MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
use Avoxx\Utility\ArrayHelper;

class Config extends AbstractConfig
{

    /**
     * Create a new config instance and set a configuration file.
     *
     * @param string|array $file
     *
     * @throws \Avoxx\Config\Exceptions\FileNotFoundException if the file does not exists.
     * @throws \Avoxx\Config\Exceptions\EmptyDirectoryException if there are no files in the directory.
     * @throws \Avoxx\Config\Exceptions\UnsupportedFileFormatException if the file format is not supported.
     * @throws \Avoxx\Config\Exceptions\FileParserException if there is a parsing error.
     */
    public function __construct($file = null)
    {
        if (! is_null($file)) {
            $this->load($file);
        }
    }

    /**
     * Load a configuration file.
     *
     * @param string|array $file
     *
     * @throws \Avoxx\Config\Exceptions\EmptyDirectoryException if there are no files in the directory.
     * @throws \Avoxx\Config\Exceptions\FileNotFoundException if the file does not exists.
     * @throws \Avoxx\Config\Exceptions\FileParserException if there is a parsing error.
     * @throws \Avoxx\Config\Exceptions\UnsupportedFileFormatException if the file format is not supported.
     */
    public function load($file)
    {
        $files = $this->getFile($file);

        foreach ($files as $file) {
            $parser = $this->getFileParser($this->getFileExtension($file));
            $this->data = array_replace_recursive($this->data, (array) $parser->parse($file));
        }
    }

    /**
     * Set a configuration value.
     *
     * @param string       $key
     * @param string|array $value
     */
    public function set($key, $value)
    {
        ArrayHelper::set($this->data, $key, $value);
    }

    /**
     * Return a configuration value.
     *
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return ArrayHelper::get($this->data, $key, $default);
    }

    /**
     * Determine if a configuration key exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return ArrayHelper::has($this->data, $key);
    }

    /**
     * Remove a configuration value.
     *
     * @param string|array $key
     */
    public function remove($key)
    {
        ArrayHelper::forget($this->data, $key);
    }

    /**
     * Return all configuration values.
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Set a configuration value via ArrayAccess.
     *
     * @param string       $key
     * @param string|array $value
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Return a configuration value via ArrayAccess.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Determine if a configuration key exists via ArrayAccess.
     *
     * @param string $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Remove a configuration value via ArrayAccess.
     *
     * @param string $key
     */
    public function offsetUnset($key)
    {
        $this->remove($key);
    }
}
