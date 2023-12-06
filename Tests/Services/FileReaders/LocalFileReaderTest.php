<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Services\FileReaders;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Services\FileReaders\LocalFileReader;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Services\FileReaders\LocalFileReaderMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class LocalFileReaderTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Services\FileReaders
 */
class LocalFileReaderTest extends TestCase
{
    const SUCCESS_READING_FILE = "/tests/Services/FileReaders/LocalFileReaderTestFile.txt";

    const FAILURE_READING_FILE = "/tests/Services/FileReaders/FooBar.txt";

    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $testHelper = new TestHelper();
        $this->testHelper = $testHelper;
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $fileReader = new LocalFileReader();
    }

    /**
     * @return void
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $fileReader = new LocalFileReader(null);
    }

    /**
     * @return void
     */
    public function testValidateThrowsExceptionMessageUrlNotBeEmpty()
    {
        $this->expectExceptionMessage(LocalFileReader::EMPTY_URL);

        $fileReader = new LocalFileReader("");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testReadSuccess()
    {
        $currentDirectory = getcwd();
        $testFilePath = $currentDirectory . self::SUCCESS_READING_FILE;

        $fileReader = new LocalFileReader($testFilePath);
        $contents = $fileReader->read();
        $this->assertEquals("hello world!", $contents);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testReadReturnEmpty()
    {
        $currentDirectory = getcwd();
        $testFilePath = $currentDirectory . self::SUCCESS_READING_FILE;

        $fileReader = new LocalFileReaderMock($testFilePath);
        $contents = $fileReader->read();
        $this->assertEmpty($contents);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetContentsSuccess()
    {
        $currentDirectory = getcwd();
        $testFilePath = $currentDirectory . self::SUCCESS_READING_FILE;

        $fileReader = new LocalFileReader($testFilePath);
        $contents = $fileReader->getContents();
        $this->assertEquals("hello world!", $contents);
    }
}