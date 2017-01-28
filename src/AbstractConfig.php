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
use ArrayAccess;
use Avoxx\Config\Contracts\ConfigInterface;
use Avoxx\Config\Exceptions\EmptyDirectoryException;
use Avoxx\Config\Exceptions\FileNotFoundException;
use Avoxx\Config\Exceptions\UnsupportedFileExtensionException;

abstract class AbstractConfig implements ArrayAccess, ConfigInterface
{

    /**
     * The configuration data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * The parser class wrapper.
     *
     * @var string
     */
    protected $parser = 'Avoxx\\Config\\Parser\\%sParser';

    /**
     * Get a configuration file.
     *
     * @param $file
     *
     * @return array
     *
     * @throws \Avoxx\Config\Exceptions\EmptyDirectoryException if there are no files in the directory.
     * @throws \Avoxx\Config\Exceptions\FileNotFoundException if the file does not exists.
     */
    protected function getFile($file)
    {
        if (is_array($file)) {
            return $this->getArrayFiles($file);
        }

        if (is_dir($file)) {
            return $this->getDirFiles($file);
        }

        if (! file_exists($file)) {
            throw new FileNotFoundException($file);
        }

        return [$file];
    }

    /**
     * Get all files from an array.
     *
     * @param array $files
     *
     * @return array
     *
     * @throws \Avoxx\Config\Exceptions\EmptyDirectoryException if there are no files in the directory.
     * @throws \Avoxx\Config\Exceptions\FileNotFoundException if the file does not exists.
     */
    protected function getArrayFiles(array $files)
    {
        $fileArray = [];

        foreach ($files as $file) {
            try {
                $fileArray = array_merge($files, $this->getFile($file));
            } catch (FileNotFoundException $e) {
                throw $e;
            }
        }

        return $fileArray;
    }

    /**
     * Get all files from a directory.
     *
     * @param $dir
     *
     * @return array
     *
     * @throws \Avoxx\Config\Exceptions\EmptyDirectoryException if there are no files in the directory.
     */
    protected function getDirFiles($dir)
    {
        $files = glob("{$dir}/*.*");

        if (empty($files)) {
            throw new EmptyDirectoryException($dir);
        }

        return $files;
    }

    /**
     * Get the file parser instance.
     *
     * @param string $fileExtension
     *
     * @return \Avoxx\Config\Contracts\ParserInterface
     *
     * @throws \Avoxx\Config\Exceptions\UnsupportedFileExtensionException if the file extension is not supported.
     */
    protected function getFileParser($fileExtension)
    {
        $parser = str_replace('Yml', 'Yaml', ucfirst($fileExtension));
        $parser = sprintf($this->parser, $parser);

        if (! class_exists($parser)) {
            throw new UnsupportedFileExtensionException($fileExtension);
        }

        return new $parser;
    }

    /**
     * Get the file extension.
     *
     * @param string $file
     *
     * @return mixed
     */
    protected function getFileExtension($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }
}
