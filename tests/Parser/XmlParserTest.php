<?php

namespace Avoxx\Config\Tests\Parser;

use Avoxx\Config\Parser\XmlParser;

/**
 * Tests for Avoxx\Config\Parser\XmlParser.
 *
 * @package Test
 */
class XmlParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Avoxx\Config\Parser\XmlParser
     */
    protected $xml;

    protected $fixtureDir = __DIR__ . '/../Fixtures';

    /**
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->xml = new XmlParser;
    }

    /**
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->xml = null;
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
     * Test loading xml file
     */
    public function testLoadXmlFile()
    {
        $result = $this->xml->parse($this->fixtureDir . '/test.xml');
        $this->assertEquals($this->getTestData(), $result);
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileParserException
     */
    public function testXmlFileParserException()
    {
        $this->xml->parse($this->fixtureDir . '/failure/error.xml');
    }
}
