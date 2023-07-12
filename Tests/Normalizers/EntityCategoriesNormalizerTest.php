<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAuthorNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityCategoriesNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntityCategoriesNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
 */
class EntityCategoriesNormalizerTest extends TestCase
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
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        new EntityCategoriesNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $api
     * @param $field
     * @param $quantity
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException($api, $field, $quantity)
    {
        $this->expectException(TypeError::class);

        $helper = new EntityCategoriesNormalizer($api, $field, $quantity);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "api" => null,
                "field" => null,
                "quantity" => null
            ],
            [
                "api" => $this->testHelper->getApi(),
                "field" => null,
                "quantity" => null
            ],
            [
                "api" => $this->testHelper->getApi(),
                "field" => "categories",
                "quantity" => null
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageEmptyField()
    {
        $this->expectExceptionMessage(EntityCategoriesNormalizer::EMPTY_FIELD);

        new EntityCategoriesNormalizer($this->testHelper->getApi(), "");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageQuantityEqualGreaterThanZero()
    {
        $this->expectExceptionMessage(EntityCategoriesNormalizer::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $quantity = $this->testHelper->getZeroOrNegativeValue();

        new EntityCategoriesNormalizer($this->testHelper->getApi(), "categories", $quantity);
    }
}