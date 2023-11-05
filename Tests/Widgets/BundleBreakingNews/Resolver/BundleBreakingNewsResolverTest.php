<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleBreakingNews\Resolver;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleBreakingNews\BundleBreakingNewsValueObjectMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Resolver\BundleBreakingNewsResolver;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class BundleBreakingNewsResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleBreakingNews\Resolver
 */
class BundleBreakingNewsResolverTest extends TestCase
{
    /**
     * @var BundleBreakingNewsValueObjectMock
     */
    private $valueObjectDev;

    /**
     * @var false|string
     */
    private $cwd;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $this->valueObjectDev = new BundleBreakingNewsValueObjectMock("dev");

        $this->cwd = getcwd();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $resolver = new BundleBreakingNewsResolver();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $resolver = new BundleBreakingNewsResolver(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testResolveContentThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $resolver = new BundleBreakingNewsResolver($this->valueObjectDev);
        $resolver->resolveContent();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testResolveContentThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $resolver = new BundleBreakingNewsResolver($this->valueObjectDev);
        $resolver->resolveContent(null);
    }

    /**
     * @dataProvider resolveContent
     *
     * @return void
     * @throws Exception
     */
    public function testResolveContent($filePath, $expected)
    {
        $resolver = new BundleBreakingNewsResolver($this->valueObjectDev);
        $result = $resolver->resolveContent($filePath);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function resolveContent(): array
    {
        $fileExists = $this->cwd . "/Tests/Widgets/BundleBreakingNews/Helper/BundleBreakingNews.json";
        $fileNotExists = $this->cwd . "/Tests/Widgets/BundleBreakingNews/Helper/BundleBreakingNewss.json";

        return [
            [
                "filePath" => "",
                "expected" => ""
            ],
            [
                "filePath" => $fileNotExists,
                "expected" => ""
            ],
            [
                "filePath" => $fileExists,
                "expected" => '{"es":1}'
            ]
        ];
    }
}