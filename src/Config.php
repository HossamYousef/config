<?php

namespace Avoxx\Config;

/*
 * AVOXX- PHP Framework Components
 *
 * @author    Merlin Christen <merloxx@avoxx.org>
 * @copyright Copyright (c) 2016 - 2017 Merlin Christen
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
     * Set a configuration value.
     *
     * @param string       $key
     * @param string|array $value
     */
    public function set($key, $value)
    {
        $keys = explode('.', $key);
        $data = &$this->data;

        while ($new = array_shift($keys)) {
            $data = &$data[$new];
        }

        $this->data[$key] = $data = $value;

        if (strstr($key, '.')) {
            unset($this->data[$key]);
        }
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
        $keys = explode('.', $key);
        $data = $this->data;

        foreach ($keys as $key) {
            if (isset($data[$key])) {
                $data = $data[$key];
                continue;
            } else {
                $data = $default;
                break;
            }
        }

        return $data;
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
        $keys = explode('.', $key);
        $data = $this->data;

        foreach ($keys as $key) {
            if (isset($data[$key])) {
                $data = $data[$key];
                continue;
            } else {
                return false;
            }
        }

        return true;
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
        $this->set($key, null);
    }
}
