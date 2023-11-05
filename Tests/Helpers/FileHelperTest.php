<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Helpers\FileHelper;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class FileHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers
 */
class FileHelperTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @var false|string
     */
    private $cwd;

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

        $this->cwd = getcwd();
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new FileHelper();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new FileHelper(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetThrowsExceptionMessageEntityIdGreaterThanZero()
    {
        $this->expectExceptionMessage(FileHelper::EMPTY_FILE);

        $helper = new FileHelper("");
    }

    /**
     * @dataProvider fileExistsValues
     *
     * @return void
     * @throws Exception
     */
    public function testFileExists($filePath, $expected)
    {
        $helper = new FileHelper($filePath);
        $result = $helper->fileExists();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function fileExistsValues(): array
    {
        $fileExists = $this->cwd . "/Tests/Widgets/BundleBreakingNews/Helper/BundleBreakingNews.json";
        $fileNotExists = $this->cwd . "/Tests/Widgets/BundleBreakingNews/Helper/BundleBreakingNewss.json";

        return [
            [
                "filePath" => $fileExists,
                "expected" => true
            ],
            [
                "filePath" => $fileNotExists,
                "expected" => false
            ],
        ];
    }
}