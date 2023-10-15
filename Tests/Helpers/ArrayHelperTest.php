<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\ArrayHelper;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class ArrayHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers
 */
class ArrayHelperTest extends TestCase
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
     * @dataProvider getItemsFieldValueThrowsArgumentCountErrorException
     *
     * @return void
     */
    public function testGetItemsFieldValueThrowsArgumentCountErrorException($items, $field)
    {
        $this->expectException(ArgumentCountError::class);
        $helper = new ArrayHelper();

        if (empty($items)) {
            $helper->getItemsFieldValue();
        } elseif (empty($field)) {
            $helper->getItemsFieldValue($items);
        }
    }

    /**
     * @return array
     */
    public function getItemsFieldValueThrowsArgumentCountErrorException(): array
    {
        return [
            [
                "items" => "",
                "field" => ""
            ],
            [
                "items" => [EntityConstants::ID_FIELD_KEY => $this->testHelper->getPositiveValue()],
                "field" => ""
            ]
        ];
    }

    /**
     * @dataProvider getItemsFieldValueThrowsTypeErrorException
     *
     * @return void
     */
    public function testGetItemsFieldValueThrowsTypeErrorException($items, $field)
    {
        $this->expectException(TypeError::class);
        $helper = new ArrayHelper();

        $helper->getItemsFieldValue($items, $field);
    }

    /**
     * @return array
     */
    public function getItemsFieldValueThrowsTypeErrorException(): array
    {
        return [
            [
                "items" => null,
                "field" => null
            ],
            [
                "items" => [],
                "field" => null
            ],
            [
                "items" => null,
                "field" => ""
            ]
        ];
    }

    /**
     * @dataProvider getItemsFieldValue
     *
     * @return void
     */
    public function testGetItemsFieldValue($items, $field, $expected)
    {
        $helper = new ArrayHelper();

        $result = $helper->getItemsFieldValue($items, $field);

        $this->assertEquals($expected, $result);

    }

    /**
     *
     * @return array[]
     */
    public function getItemsFieldValue(): array
    {
        return [
            [
                "items" => [],
                "field" => EntityConstants::ID_FIELD_KEY,
                "expected" => []
            ],
            [
                "items" => [[EntityConstants::ID_FIELD_KEY => 1]],
                "field" => "",
                "expected" => []
            ],
            [
                "items" => [[EntityConstants::ID_FIELD_KEY => 1]],
                "field" => EntityConstants::AUTHOR_FIELD_KEY,
                "expected" => [null]
            ],
            [
                "items" => [[EntityConstants::ID_FIELD_KEY => 1]],
                "field" => EntityConstants::ID_FIELD_KEY,
                "expected" => [1]
            ],
            [
                "items" => [[EntityConstants::ID_FIELD_KEY => 1], [EntityConstants::AUTHOR_FIELD_KEY => 1]],
                "field" => EntityConstants::ID_FIELD_KEY,
                "expected" => [1,null]
            ]
        ];

    }


}