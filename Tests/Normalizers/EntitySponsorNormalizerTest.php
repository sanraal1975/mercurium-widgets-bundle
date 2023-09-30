<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntitySponsorNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntitySponsorNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
 */
class EntitySponsorNormalizerTest extends TestCase
{
    /**
     * @var ClientMock
     */
    private $api;

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
        $this->api = $testHelper->getApi();
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntitySponsorNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($api, $assetField, $textField)
    {
        $this->expectException(TypeError::class);

        $normalizer = new EntitySponsorNormalizer($api, $assetField, $textField);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "api" => null,
                "assetField" => null,
                "textField" => null,
            ],
            [
                "api" => $this->api,
                "assetField" => null,
                "textField" => null,
            ],
            [
                "api" => $this->api,
                "assetField" => "",
                "textField" => null,
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntitySponsorNormalizer($this->api, "", "");
        $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new EntitySponsorNormalizer($this->api, "", "");
        $normalizer->normalize(null);
    }

    /**
     * @dataProvider normalize
     *
     * @param $assetField
     * @param $textField
     * @param $entity
     * @param $expected
     *
     * @return void
     * @throws Exception
     */
    public function testNormalize($assetField, $textField, $entity, $expected)
    {
        $normalizer = new EntitySponsorNormalizer($this->api, $assetField, $textField);
        $result = $normalizer->normalize($entity);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalize(): array
    {
        return [
            [
                "assetField" => "",
                "textField" => "",
                "entity" => [],
                "expected" => []
            ],
            [
                "assetField" => EntityConstants::IMAGE_FIELD_KEY,
                "textField" => "",
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_SPONSOR => false
                ]
            ],
            [
                "assetField" => EntityConstants::IMAGE_FIELD_KEY,
                "textField" => "",
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::IMAGE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_SPONSOR => true,
                    EntityConstants::IMAGE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::ORIENTATION_FIELD_KEY => "is-horizontal"
                    ]
                ]
            ],
            [
                "assetField" => EntityConstants::IMAGE_FIELD_KEY,
                "textField" => "sponsorText",
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    "sponsorText" => "sponsor"
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_SPONSOR => true,
                    "sponsorText" => "sponsor"
                ]
            ],
        ];
    }
}