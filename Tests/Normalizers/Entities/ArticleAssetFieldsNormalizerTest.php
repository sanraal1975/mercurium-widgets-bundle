<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\ArticleAssetFieldsNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class ArticleAssetFieldsNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities
 */
class ArticleAssetFieldsNormalizerTest extends TestCase
{
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

        $testHelper = new TestHelper();
        $this->api = $testHelper->getApi();
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new ArticleAssetFieldsNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($api, $normalizeImage, $normalizeVideo, $normalizeAudio)
    {
        $this->expectException(TypeError::class);

        $normalizer = new ArticleAssetFieldsNormalizer($api, $normalizeImage, $normalizeVideo, $normalizeAudio);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "api" => null,
                "normalizeImage" => true,
                "normalizeVideo" => false,
                "normalizeAudio" => false,
            ],
            [
                "api" => $this->api,
                "normalizeImage" => null,
                "normalizeVideo" => false,
                "normalizeAudio" => false,
            ],
            [
                "api" => $this->api,
                "normalizeImage" => true,
                "normalizeVideo" => null,
                "normalizeAudio" => false,
            ],
            [
                "api" => $this->api,
                "normalizeImage" => true,
                "normalizeVideo" => true,
                "normalizeAudio" => null,
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

        $normalizer = new ArticleAssetFieldsNormalizer($this->api);
        $result = $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new ArticleAssetFieldsNormalizer($this->api);
        $entity = null;
        $result = $normalizer->normalize($entity);
    }

    /**
     * @dataProvider normalizeReturnsEntity
     *
     * @param $entity
     * @param $normalizeImage
     * @param $normalizeVideo
     * @param $normalizeAudio
     * @param $expected
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntity($entity, $normalizeImage, $normalizeVideo, $normalizeAudio, $expected)
    {
        $normalizer = new ArticleAssetFieldsNormalizer($this->api, $normalizeImage, $normalizeVideo, $normalizeAudio);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnsEntity(): array
    {
        return [
            [
                "entity" => [],
                "normalizeImage" => false,
                "normalizeVideo" => false,
                "normalizeAudio" => false,
                "expected" => []
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "normalizeImage" => true,
                "normalizeVideo" => false,
                "normalizeAudio" => false,
                "expected" => [EntityConstants::ID_FIELD_KEY => 1],
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "normalizeImage" => false,
                "normalizeVideo" => true,
                "normalizeAudio" => false,
                "expected" => [EntityConstants::ID_FIELD_KEY => 1],
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "normalizeImage" => false,
                "normalizeVideo" => false,
                "normalizeAudio" => true,
                "expected" => [EntityConstants::ID_FIELD_KEY => 1],
            ]
        ];
    }
}