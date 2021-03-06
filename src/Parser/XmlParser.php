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

class XmlParser implements ParserInterface
{

    /**
     * Parse an XML file.
     *
     * @param string $file
     *
     * @return array
     *
     * @throws \Avoxx\Config\Exceptions\FileParserException if there is a parsing error.
     */
    public function parse($file): array
    {
        libxml_use_internal_errors(true);

        $data = simplexml_load_file($file, null, LIBXML_NOERROR);

        if ($data === false) {
            $errors = libxml_get_errors();
            $error  = array_pop($errors);

            throw FileParserException::Parser()
                ->setMessage($error->message)
                ->setCode($error->code)
                ->setType($error->level)
                ->setFile($error->file)
                ->setLine($error->line);
        }

        return (array) json_decode(json_encode($data), true);
    }
}
