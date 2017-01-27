<?php

namespace Avoxx\Config\Tests\Parser;

use Avoxx\Config\Parser\IniParser;

/**
 * Tests for Avoxx\Config\Parser\IniParser.
 *
 * @package Test
 */
class IniParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Avoxx\Config\Parser\IniParser
     */
    protected $ini;

    protected $fixtureDir = __DIR__ . '/../Fixtures';

    /**
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->ini = new IniParser;
    }

    /**
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->ini = null;
    }

    /**
     * Get test config data
     *
     * @return string
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
     * Test loading ini file
     */
    public function testLoadIniFile()
    {
        $result = $this->ini->parse($this->fixtureDir . '/test.ini');
        $this->assertEquals($this->getTestData(), $result);
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileParserException
     */
    public function testIniFileParserException()
    {
        $this->ini->parse($this->fixtureDir . '/failure/error.ini');
    }
}
