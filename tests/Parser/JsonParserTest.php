<?php

namespace Avoxx\Config\Tests\Parser;

use Avoxx\Config\Parser\JsonParser;

/**
 * Tests for Avoxx\Config\Parser\JsonParser.
 *
 * @package Test
 */
class JsonParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Avoxx\Config\Parser\JsonParser
     */
    protected $json;

    protected $fixtureDir = __DIR__ . '/../Fixtures';

    /**
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->json = new JsonParser;
    }

    /**
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->json = null;
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
    public function testLoadJsonFile()
    {
        $result = $this->json->parse($this->fixtureDir . '/test.json');
        $this->assertEquals($this->getTestData(), $result);
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileParserException
     */
    public function testJsonFileParserException()
    {
        $this->json->parse($this->fixtureDir . '/failure/error.json');
    }
}
