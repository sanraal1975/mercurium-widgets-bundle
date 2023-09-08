<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\PollNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAssetNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityCategoriesNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class PollNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities
 */
class PollNormalizerTest extends TestCase
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
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new PollNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $api
     * @param $pollNormalizer
     * @param $imageNormalizer
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException($api, $pollNormalizer, $imageNormalizer)
    {
        $this->expectException(TypeError::class);

        $normalizer = new PollNormalizer($api, $pollNormalizer, $imageNormalizer);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "api" => null,
                "pollNormalizer" => "",
                "imageNormalizer" => "",
            ],
            [
                "api" => $this->api,
                "pollNormalizer" => "",
                "imageNormalizer" => "",
            ],
            [
                "api" => $this->api,
                "pollNormalizer" => null,
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

        $normalizer = new PollNormalizer($this->api);

        $entity = $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new PollNormalizer($this->api);

        $entity = null;
        $entity = $normalizer->normalize($entity);
    }

    /**
     * @dataProvider normalize
     *
     * @param $entity
     * @param $expected
     * @param $pollNormalizer
     * @param $assetNormalizer
     *
     * @return void
     * @throws Exception
     */
    public function testNormalize($entity, $expected, $pollNormalizer, $assetNormalizer)
    {
        $normalizer = new PollNormalizer(
            $this->api,
            $pollNormalizer,
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
                "pollNormalizer" => null,
                "assetNormalizer" => null,
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                ],
                "pollNormalizer" => null,
                "assetNormalizer" => null,
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => [EntityConstants::ID_FIELD_KEY => 1],
                "pollNormalizer" => new EntityNormalizer(
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
                "pollNormalizer" => null,
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
                "pollNormalizer" => new EntityNormalizer(
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