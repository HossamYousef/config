<?php

namespace Avoxx\Config\Tests\Parser;

use Avoxx\Config\Parser\YamlParser;

/**
 * Tests for Avoxx\Config\Parser\YamlParser.
 *
 * @package Test
 */
class YamlParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Avoxx\Config\Parser\YamlParser
     */
    protected $yaml;

    protected $fixtureDir = __DIR__ . '/../Fixtures';

    /**
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->yaml = new YamlParser;
    }

    /**
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->yaml = null;
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
     * Test loading Yaml file
     */
    public function testLoadYamlFile()
    {
        $result = $this->yaml->parse($this->fixtureDir . '/test.yml');
        $this->assertEquals($this->getTestData(), $result);
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileParserException
     */
    public function testYamlFileParserException()
    {
        $this->yaml->parse($this->fixtureDir . '/failure/error.yaml');
    }
}
