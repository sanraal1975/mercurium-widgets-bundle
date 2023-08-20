<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntityNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
 */
class EntityNormalizerTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntityNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $parameter
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $normalizer = new EntityNormalizer($parameter);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "parameter" => 1,
            ],
            [
                "parameter" => null,
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageNormalizersArrayNotBeEmpty()
    {
        $this->expectExceptionMessage(EntityNormalizer::EMPTY_NORMALIZERS_ARRAY);

        $normalizer = new EntityNormalizer([]);
    }

    /**
     * @dataProvider normalize
     *
     * @return void
     * @throws Exception
     */
    public function testNormalize($entity, $expected)
    {
        $normalizer = new EntityNormalizer([new NormalizerMock()]);

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
                "entity" => [],
                "expected" => []
            ],
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1],
                "expected" => [BundleConstants::ID_FIELD_KEY => 1]
            ],
        ];
    }
}