<?php

namespace Avoxx\Config\Parser;

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
use Avoxx\Config\Contracts\ParserInterface;
use Avoxx\Config\Exceptions\FileParserException;
use Avoxx\Config\Exceptions\UnsupportedFileFormatException;
use Exception;
use ParseError;

class PhpParser implements ParserInterface
{

    /**
     * Parse a PHP file.
     *
     * @param string $file
     *
     * @return array
     *
     * @throws \Avoxx\Config\Exceptions\FileParserException if there is a parsing error.
     * @throws \Avoxx\Config\Exceptions\UnsupportedFileFormatException if the config file content is invalid.
     */
    public function parse($file): array
    {
        try {
            $data = require $file;
        } catch (ParseError $e) {
            throw FileParserException::Parser()
                ->setMessage('PHP file threw an exception')
                ->setPrevious($e);
        } catch (Exception $e) {
            throw FileParserException::Parser()
                ->setMessage('PHP file threw an exception')
                ->setPrevious($e);
        }

        if (!is_array($data)) {
            throw new UnsupportedFileFormatException($file);
        }

        return (array) $data;
    }
}
