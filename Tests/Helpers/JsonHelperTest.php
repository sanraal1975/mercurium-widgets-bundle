<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\JsonHelper;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class JsonHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers
 */
class JsonHelperTest extends TestCase
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
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $testHelper = new TestHelper();
        $this->testHelper = $testHelper;
    }

    /**
     * @dataProvider getLocaleIdsThrowsArgumentCountErrorException
     *
     * @return void
     */
    public function testGetLocaleIdsThrowsArgumentCountErrorException($jsonContent, $locale)
    {
        $this->expectException(ArgumentCountError::class);
        $helper = new JsonHelper();

        if (empty($jsonContent)) {
            $helper->getLocaleIds();
        } elseif (empty($locale)) {
            $helper->getLocaleIds($jsonContent);
        }
    }

    /**
     * @return array
     */
    public function getLocaleIdsThrowsArgumentCountErrorException(): array
    {
        return [
            [
                "jsonContent" => null,
                "locale" => null
            ],
            [
                "jsonContent" => "",
                "locale" => null
            ],
            [
                "jsonContent" => null,
                "locale" => ""
            ]
        ];
    }

    /**
     * @dataProvider getLocaleIdsThrowsTypeErrorException
     *
     * @return void
     */
    public function testGetLocaleIdsThrowsTypeErrorException($jsonContent, $locale)
    {
        $this->expectException(TypeError::class);
        $helper = new JsonHelper();

        $helper->getLocaleIds($jsonContent, $locale);
    }

    /**
     * @return array
     */
    public function getLocaleIdsThrowsTypeErrorException(): array
    {
        return [
            [
                "items" => null,
                "field" => null
            ],
            [
                "items" => "",
                "field" => null
            ],
            [
                "items" => null,
                "field" => ""
            ]
        ];
    }

    /**
     * @dataProvider getLocaleIds
     *
     * @return void
     */
    public function testGetLocaleIds($jsonContent, $locale, $expected)
    {
        $helper = new JsonHelper();
        $result = $helper->getLocaleIds($jsonContent, $locale);

        $this->assertEquals($expected, $result);

    }

    /**
     *
     * @return array[]
     */
    public function getLocaleIds(): array
    {
        return [
            [
                "jsonContent" => "",
                "locale" => "",
                "expected" => []
            ],
            [
                "jsonContent" => '{"es":[{"id":53},{"id":52},{"id":51}]}',
                "locale" => "",
                "expected" => []
            ],
            [
                "jsonContent" => '{"es":[{"id":53},{"id":52},{"id":51}]}',
                "locale" => "ca",
                "expected" => []
            ],
            [
                "jsonContent" => '{"es":[{"id":53},{"id":52},{"id":51}]}',
                "locale" => "es",
                "expected" => [[EntityConstants::ID_FIELD_KEY=>53],[EntityConstants::ID_FIELD_KEY=>52],[EntityConstants::ID_FIELD_KEY=>51]]
            ]
        ];
    }


}