<?php

namespace Avoxx\Config\Contracts;

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

interface ConfigInterface
{

    /**
     * Load a configuration file.
     *
     * @param string|array $file
     *
     * @throws \Avoxx\Config\Exceptions\FileNotFoundException if the file does not exists.
     * @throws \Avoxx\Config\Exceptions\EmptyDirectoryException if there are no files in the directory.
     * @throws \Avoxx\Config\Exceptions\UnsupportedFileExtensionException if the file extension is not supported.
     * @throws \Avoxx\Config\Exceptions\UnsupportedFileFormatException if the file format is not supported.
     * @throws \Avoxx\Config\Exceptions\FileParserException if there is a parsing error.
     */
    public function load($file);

    /**
     * Set a configuration value.
     *
     * @param string       $key
     * @param string|array $value
     */
    public function set($key, $value);

    /**
     * Return a configuration value.
     *
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Determine if a configuration key exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * Remove a configuration value.
     *
     * @param string|array $key
     */
    public function remove($key);

    /**
     * Return all configuration values.
     *
     * @return array
     */
    public function all();
}
