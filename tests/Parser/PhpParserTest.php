<?php

namespace Avoxx\Config\Tests\Parser;

use Avoxx\Config\Parser\PhpParser;

/**
 * Tests for Avoxx\Config\Parser\PhpParser.
 *
 * @package Test
 */
class PhpParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Avoxx\Config\Parser\PhpParser
     */
    protected $php;

    protected $fixtureDir = __DIR__ . '/../Fixtures';

    /**
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->php = new PhpParser;
    }

    /**
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->php = null;
    }

    /**
     * Get test config data
     *
     * @return array
     */
    protected function getTestData()
    {
        return [
            'key' => 'value',
            'array' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
        ];
    }

    /**
     * Test loading php file array
     */
    public function testLoadPhpFileArray()
    {
        $result = $this->php->parse($this->fixtureDir . '/test.php');
        $this->assertEquals($this->getTestData(), $result);
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileParserException
     */
    public function testPhpFileParseException()
    {
        $this->php->parse($this->fixtureDir . '/failure/parse-exception.php');
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\UnsupportedFileFormatException
     */
    public function testPhpFileUnsupportedFileFormatException()
    {
        $this->php->parse($this->fixtureDir . '/failure/error.php');
    }
}
