<?php

namespace Avoxx\Config\Tests;

use Avoxx\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Avoxx\Config\Config
     */
    protected $config;

    protected $fixtureDir = './tests/Fixtures/';

    public function setUp()
    {
        $this->config = new Config($this->fixtureDir);
    }

    public function tearDown()
    {
        $this->config = null;
    }

    public function testConstructorSingleFile()
    {
        $ini = new Config($this->fixtureDir . 'test.ini');
        $json = new Config($this->fixtureDir . 'test.json');
        $php = new Config($this->fixtureDir . 'test.php');
        $xml = new Config($this->fixtureDir . 'test.xml');
        $yaml = new Config($this->fixtureDir . 'test.yml');

        $this->assertInstanceOf(Config::class, $ini);
        $this->assertInstanceOf(Config::class, $json);
        $this->assertInstanceOf(Config::class, $php);
        $this->assertInstanceOf(Config::class, $xml);
        $this->assertInstanceOf(Config::class, $yaml);
    }

    public function testConstructorMultipleFiles()
    {
        $files = [
            $this->fixtureDir . 'test.ini',
            $this->fixtureDir . 'test.json',
            $this->fixtureDir . 'test.php',
            $this->fixtureDir . 'test.xml',
            $this->fixtureDir . 'test.yml',
        ];

        $config = new Config($files);

        $this->assertInstanceOf(Config::class, $config);
    }

    public function testConstructorDirectory()
    {
        $config = new Config($this->fixtureDir);

        $this->assertInstanceOf(Config::class, $config);
    }

    public function testLoadOverride()
    {
        $expected1 = [
            'driver' => 'mysql',
            'host' => 'localhost',
            'user' => 'root',
            'pass' => 'root',
        ];

        $this->config->load($this->fixtureDir . 'db1.php');

        $this->assertEquals($expected1, $this->config->get('db'));

        $expected2 = [
            'driver' => 'pgsql',
            'host' => 'localhost',
            'user' => 'root',
            'pass' => 'root',
        ];

        $this->config->load($this->fixtureDir . 'db2.php');

        $this->assertEquals($expected2, $this->config->get('db'));
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileNotFoundException
     */
    public function testFileNotExistsThrowsException()
    {
        new Config('nope.ini');
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileNotFoundException
     */
    public function testFileArrayNotExistsThrowsException()
    {
        new Config(['nope.ini']);
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\EmptyDirectoryException
     */
    public function testEmptyDirectoryThrowsException()
    {
        new Config($this->fixtureDir . 'empty');
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\UnsupportedFileFormatException
     */
    public function testNotSupportedFileExtensionThrowsException()
    {
        return new Config($this->fixtureDir . '/failure/wrong.extension');
    }

    public function testSetNewValue()
    {
        $this->assertNull($this->config->get('foo'));

        $this->config->set('foo', 'bar');

        $this->assertEquals('bar', $this->config->get('foo'));
    }

    public function testSetNewArray()
    {
        $this->config->set('foo', [
            'bar' => '1',
            'baz' => '2'
        ]);

        $expected = [
            'bar' => '1',
            'baz' => '2'
        ];

        $this->assertTrue(is_array($this->config->get('foo')));
        $this->assertEquals($expected, $this->config->get('foo'));
    }

    public function testSetNewArrayWithDotNotation()
    {
        $this->config->set('foo.bar', '1');
        $this->config->set('foo.baz', '2');

        $expected = [
            'bar' => '1',
            'baz' => '2'
        ];

        $this->assertTrue(is_array($this->config->get('foo')));
        $this->assertEquals($expected, $this->config->get('foo'));
    }

    public function testSetOverwriteExistingValue()
    {
        $this->assertEquals('value', $this->config->get('key'));

        $this->config->set('key', 'foo');

        $this->assertEquals('foo', $this->config->get('key'));
    }

    public function testSetOverwriteExistingArrayValue()
    {
        $expected = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $this->assertTrue(is_array($this->config->get('array')));
        $this->assertEquals($expected, $this->config->get('array'));

        $this->config->set('array.key1', 'foo');

        $expected = [
            'key1' => 'foo',
            'key2' => 'value2',
        ];

        $this->assertTrue(is_array($this->config->get('array')));
        $this->assertEquals($expected, $this->config->get('array'));
    }

    public function testGetReturnsValue()
    {
        $this->assertEquals('value', $this->config->get('key'));
    }

    public function testGetReturnsDefaultValueIfKeyDoesNotExists()
    {
        $this->assertNull($this->config->get('nope'));
    }

    public function testGetWithNestedArray()
    {
        $this->assertEquals('value1', $this->config->get('array.key1'));
    }
    public function testHasReturnsTrue()
    {
        $this->assertTrue($this->config->has('key'));
        $this->assertTrue($this->config->has('array.key1'));
    }

    public function testHasReturnsFalse()
    {
        $this->assertFalse($this->config->has('nope'));
    }

    public function testRemoveReturnsNull()
    {
        $this->config->set('foo', 'bar');

        $this->assertEquals('bar', $this->config->get('foo'));

        $this->config->remove('foo');

        $this->assertNull($this->config->get('foo'));
    }

    public function testAll()
    {
        $config = new Config;
        $config->set('key', 'value');
        $config->set('array', [
            'key1' => 'value1',
            'key2' => 'value2',
        ]);

        $expected = [
            'key' => "value",
            'array' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
        ];

        $this->assertEquals($expected, $config->all());
    }

    public function testAllWithEmptyFile()
    {
        $config = new Config($this->fixtureDir . 'empty.ini');

        $this->assertTrue(empty($config->all()));
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileParserException
     */
    public function testIniFileParserException()
    {
        new Config($this->fixtureDir . 'failure/error.ini');
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileParserException
     */
    public function testJsonFileParserException()
    {
        new Config($this->fixtureDir . 'failure/error.json');
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\UnsupportedFileFormatException
     */
    public function testPhpFileUnsupportedFileFormatException()
    {
        new Config($this->fixtureDir . 'failure/error.php');
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileParserException
     */
    public function testPhpFileParseException()
    {
        new Config($this->fixtureDir . 'failure/parse-exception.php');
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileParserException
     */
    public function testXmlFileParserException()
    {
        new Config($this->fixtureDir . 'failure/error.xml');
    }

    /**
     * @expectedException \Avoxx\Config\Exceptions\FileParserException
     */
    public function testYamlFileParserException()
    {
        new Config($this->fixtureDir . 'failure/error.yaml');
    }

    public function testArrayAccess()
    {
        $this->config['foo'] = 'bar';

        $this->assertTrue(isset($this->config['foo']));
        $this->assertEquals('bar', $this->config['foo']);

        unset($this->config['foo']);

        $this->assertNull($this->config['foo']);
    }
}
