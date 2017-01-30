<?php

namespace Avoxx\Config;

/*
 * AVOXX - PHP Framework Components
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
use Exception;
use ReflectionProperty;

trait TErrorException
{
    /**
     * @param string $message
     * @return static
     */
    public function setMessage($message)
    {
        $this->message = (string) $message;
        return $this;
    }

    /**
     * @param int $code
     * @return static
     */
    public function setCode($code)
    {
        $this->code = (int) $code;
        return $this;
    }

    /**
     * @param int $type
     * @return static
     */
    public function setType($type)
    {
        $this->severity = (int) $type;
        return $this;
    }

    /**
     * @param string $file
     * @return static
     */
    public function setFile($file)
    {
        $this->file = (string) $file;
        return $this;
    }

    /**
     * @param int $line
     * @return static
     */
    public function setLine($line)
    {
        $this->line = (int) $line;
        return $this;
    }

    /**
     * @param Exception $previous
     * @return static
     */
    public function setPrevious($previous)
    {
        // 'previous' property is private to the Exception class.
        $previousProp = new ReflectionProperty(Exception::class, "previous");
        $previousProp->setAccessible(true);
        $previousProp->setValue($this, $previous);
        $previousProp->setAccessible(false);
        return $this;
    }
}
