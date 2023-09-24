<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\ActivityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAssetNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityCategoriesNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class ActivityNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities
 */
class ActivityNormalizerTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @var ClientMock
     */
    private $api;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);
        $this->testHelper = new TestHelper();

        $this->api = $this->testHelper->getApi();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $activityNormalizer
     * @param $imageNormalizer
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException($activityNormalizer, $imageNormalizer)
    {
        $this->expectException(TypeError::class);

        $normalizer = new ActivityNormalizer($activityNormalizer, $imageNormalizer);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "activityNormalizer" => "",
                "imageNormalizer" => "",
            ],
            [
                "activityNormalizer" => null,
                "imageNormalizer" => "",
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

        $normalizer = new ActivityNormalizer();

        $entity = $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new ActivityNormalizer();

        $entity = null;
        $entity = $normalizer->normalize($entity);
    }

    /**
     * @dataProvider normalize
     *
     * @param $entity
     * @param $expected
     * @param $activityNormalizer
     * @param $assetNormalizer
     *
     * @return void
     * @throws Exception
     */
    public function testNormalize($entity, $expected, $activityNormalizer, $assetNormalizer)
    {
        $normalizer = new ActivityNormalizer(
            $activityNormalizer,
            $assetNormalizer
        );

        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function normalize(): array
    {
        return [
            [
                "entity" => [],
                "expected" => [],
                "activityNormalizer" => null,
                "assetNormalizer" => null,
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                ],
                "activityNormalizer" => null,
                "assetNormalizer" => null,
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => [EntityConstants::ID_FIELD_KEY => 1],
                "activityNormalizer" => new EntityNormalizer(
                    [
                        new EntityCategoriesNormalizer($this->api)
                    ]
                ),
                "assetNormalizer" => null,
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSET_FIELD_KEY => []
                ],
                "activityNormalizer" => null,
                "assetNormalizer" => new EntityNormalizer(
                    [
                        new EntityCategoriesNormalizer($this->api)
                    ]
                ),
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSET_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSET_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                    ]
                ],
                "activityNormalizer" => new EntityNormalizer(
                    [
                        new EntityAssetNormalizer($this->api, EntityConstants::ASSET_FIELD_KEY)
                    ]
                ),
                "assetNormalizer" => new EntityNormalizer(
                    [
                        new EntityCategoriesNormalizer($this->api)
                    ]
                ),
            ],
        ];
    }
}