<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\VideoHelperMock;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class VideoHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class VideoHelperTest  extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->testHelper = new TestHelper();
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetLast()
    {
        $factory = new ApiServiceFactory($this->testHelper->getApi());
        $service = $factory->createAssetApiService();

        $helper = new VideoHelperMock($service);

        $result = $helper->getLast();
        $expected = ["id" => 1, "searchable" => true];

        $this->assertEquals($expected, $result);
    }

}