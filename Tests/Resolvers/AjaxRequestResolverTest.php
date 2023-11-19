<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Resolvers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\AjaxRequestConstants;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Resolvers\AjaxRequestResolver;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\AjaxRequestValueObject;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use TypeError;

/**
 * Class AjaxRequestResolverTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Resolvers
 */
class AjaxRequestResolverTest extends TestCase
{
    const AJAX_ENTRY_POINT = "resolveAjaxAction";
    const DUMMY_METHOD = "dummy_method";
    const DUMMY_WIDGET_CLASS = "dummy_widget_class";
    const ENCODED_VALUE = "aaDK%2B0Qr8%2FusLRhyAWcrZT%2BZX1%2BcgDCL5N2Iqt57gR9XNeGvkIOF9D%2Bv2ZSvMXjGfZ2Rlv8zeQ0vDLl9dkZKFg%3D%3D";
    const MAPPING = "mapping";
    const METHOD = "method";
    const REQUEST = "request";
    const URL_SERVICE = "comitium5_common_widgets_self_call";
    const VALUE_OBJECT = "valueObject";

    /**
     * @var AjaxRequestValueObject
     */
    private $ajaxRequestValueObject;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     * @throws Exception
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $this->ajaxRequestValueObject = new AjaxRequestValueObject(
            self::URL_SERVICE,
            self::AJAX_ENTRY_POINT,
            self::DUMMY_WIDGET_CLASS,
            [EntityConstants::ID_FIELD_KEY => 1],
            []
        );
    }

    /**
     * @dataProvider resolveEncodedParametersThrowsArgumentCountErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testResolveEncodedParametersThrowsArgumentCountErrorException($valueObject, $method, $mapping)
    {
        $this->expectException(ArgumentCountError::class);

        $resolver = new AjaxRequestResolver();

        if (empty($valueObject)) {
            $resolver->resolveEncodedParameters();
        }

        if (empty($method)) {
            $resolver->resolveEncodedParameters($valueObject);
        }

        if (empty($mapping)) {
            $resolver->resolveEncodedParameters($valueObject, $method);
        }
    }

    /**
     * @return array
     */
    public function resolveEncodedParametersThrowsArgumentCountErrorException(): array
    {
        return [
            [
                self::VALUE_OBJECT => "",
                self::METHOD => "",
                self::MAPPING => ""
            ],
            [
                self::VALUE_OBJECT => $this->ajaxRequestValueObject,
                self::METHOD => "",
                self::MAPPING => ""
            ],
            [
                self::VALUE_OBJECT => $this->ajaxRequestValueObject,
                self::METHOD => self::DUMMY_METHOD,
                self::MAPPING => ""
            ],
        ];
    }

    /**
     * @dataProvider resolveEncodedParametersThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testResolveEncodedParametersThrowsTypeErrorException($valueObject, $method, $mapping)
    {
        $this->expectException(TypeError::class);

        $resolver = new AjaxRequestResolver();

        $resolver->resolveEncodedParameters($valueObject, $method, $mapping);
    }

    /**
     * @return array
     */
    public function resolveEncodedParametersThrowsTypeErrorException(): array
    {
        return [
            [
                self::VALUE_OBJECT => null,
                self::METHOD => null,
                self::MAPPING => null,
            ],
            [
                self::VALUE_OBJECT => $this->ajaxRequestValueObject,
                self::METHOD => null,
                self::MAPPING => null
            ],
            [
                self::VALUE_OBJECT => $this->ajaxRequestValueObject,
                self::METHOD => self::DUMMY_METHOD,
                self::MAPPING => null
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testResolveEncodedParameters()
    {
        $resolver = new AjaxRequestResolver();

        $parameters = $resolver->resolveEncodedParameters($this->ajaxRequestValueObject, self::DUMMY_METHOD, []);

        $this->assertEquals(self::ENCODED_VALUE, $parameters);
    }

    /**
     * @dataProvider resolveDecodedParametersThrowsArgumentCountErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testResolveDecodedParametersThrowsArgumentCountErrorException($request, $mapping)
    {
        $this->expectException(ArgumentCountError::class);

        $resolver = new AjaxRequestResolver();

        if (empty($request)) {
            $resolver->resolveDecodedParameters();
        }

        if (empty($mapping)) {
            $resolver->resolveDecodedParameters($request);
        }
    }

    /**
     * @return array
     */
    public function resolveDecodedParametersThrowsArgumentCountErrorException(): array
    {
        return [
            [
                self::REQUEST => "",
                self::MAPPING => ""
            ],
            [
                self::REQUEST => new Request(),
                self::MAPPING => ""
            ],
        ];
    }

    /**
     * @dataProvider resolveDecodedParametersThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testResolveDecodedParametersThrowsTypeErrorException($request, $mapping)
    {
        $this->expectException(TypeError::class);

        $resolver = new AjaxRequestResolver();

        $resolver->resolveDecodedParameters($request, $mapping);
    }

    /**
     * @return array
     */
    public function resolveDecodedParametersThrowsTypeErrorException(): array
    {
        return [
            [
                self::REQUEST => null,
                self::MAPPING => null
            ],
            [
                self::REQUEST => new Request(),
                self::MAPPING => null
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testResolveDecodedParametersThrowsException()
    {
        $this->expectException(Exception::class);

        $request = new Request();

        $resolver = new AjaxRequestResolver();

        $result = $resolver->resolveDecodedParameters($request, []);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testResolveDecodedParameters()
    {
        $request = new Request();

        $request->attributes->set(AjaxRequestConstants::PARAMETERS, self::ENCODED_VALUE);

        $resolver = new AjaxRequestResolver();

        $result = $resolver->resolveDecodedParameters($request, []);

        $expected = [
            EntityConstants::ID_FIELD_KEY => 1,
            AjaxRequestConstants::PARAMETERS => [
                AjaxRequestConstants::METHOD => [
                    AjaxRequestConstants::VALUE => self::DUMMY_METHOD
                ],
                AjaxRequestConstants::EXTRA_PARAMETERS => [
                    AjaxRequestConstants::VALUE => []
                ]
            ],
            AjaxRequestConstants::EDITOR => false
        ];

        $this->assertEquals($expected, $result);
    }
}