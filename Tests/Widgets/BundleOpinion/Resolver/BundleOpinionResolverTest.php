<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleOpinion\Resolver;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleOpinion\ValueObject\BundleOpinionValueObjectMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\Resolver\BundleOpinionResolver;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

class BundleOpinionResolverTest extends TestCase
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
     * @var false|string
     */
    private $cwd;

    /**
     * @var string
     */
    private $fileExists;

    /**
     * @var string
     */
    private $fileNoExists;

    /**
     * @var EntityNormalizer
     */
    private $entityNormalizer;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     * @throws Exception
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $testHelper = new TestHelper();
        $this->testHelper = $testHelper;
        $this->api = $testHelper->getApi();

        $this->cwd = getcwd();
        $this->fileExists = $this->cwd . "/Tests/Widgets/BundleOpinion/BundleOpinionJson.json";
        $this->fileNoExists = $this->cwd . "/Tests/Widgets/BundleOpinion/BundleOpinionJsons.json";
        $this->entityNormalizer = new EntityNormalizer([new NormalizerMock()]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountException()
    {
        $this->expectException(ArgumentCountError::class);

        $resolver = new BundleOpinionResolver();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $resolver = new BundleOpinionResolver(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testResolveSponsorImage()
    {
        $valueObject = new BundleOpinionValueObjectMock($this->api);

        $resolver = new BundleOpinionResolver($valueObject, $this->entityNormalizer);

        $asset = $resolver->resolveSponsorImage();

        $this->assertEquals(
            [
                EntityConstants::ID_FIELD_KEY => 1, 
                EntityConstants::SEARCHABLE_FIELD_KEY => true, 
                EntityConstants::ORIENTATION_FIELD_KEY => EntityConstants::IMAGE_ORIENTATION_SQUARE
            ], 
            $asset
        );
    }

    /**
     * @dataProvider getResolveJsonFilePath
     *
     * @return void
     * @throws Exception
     */
    public function testResolveJsonFilePath($valueObject, $expected)
    {
        $resolver = new BundleOpinionResolver($valueObject, $this->entityNormalizer);
        $result = $resolver->resolveJsonFilePath();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getResolveJsonFilePath(): array
    {
        return [
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->testHelper->getApi(),
                    1,
                    "",
                    1,
                    1,
                    "ca",
                    ""
                ),
                "expected" => ""
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->testHelper->getApi(),
                    1,
                    "",
                    1,
                    1,
                    "ca",
                    "1.json",
                    "dev",
                    "@HOME_URL@/uploads/static/@SUBSITE_ACRONYM@/",
                    "",
                    "",
                    "https://foo.bar",
                    "foo"
                ),
                "expected" => "https://foo.bar/uploads/static/foo/1.json"
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->testHelper->getApi(),
                    1,
                    "",
                    1,
                    1,
                    "ca",
                    "1.json",
                    "prod",
                    "",
                    "/var/www/@SITE_PREFIX@/prod/front/@SUBSITE_ACRONYM@/current/web/uploads/static/@SUBSITE_ACRONYM@/",
                    "foo",
                    "",
                    "bar"
                ),
                "expected" => "/var/www/foo/prod/front/bar/current/web/uploads/static/bar/1.json"
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testResolveDeniedArticlesIdsThrowsArgumentCountException()
    {
        $this->expectException(ArgumentCountError::class);

        $valueObject = new BundleOpinionValueObjectMock($this->testHelper->getApi());
        $resolver = new BundleOpinionResolver($valueObject, $this->entityNormalizer);

        $resolver->resolveDeniedArticlesIds();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testResolveDeniedArticlesIdsThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $valueObject = new BundleOpinionValueObjectMock($this->testHelper->getApi());
        $resolver = new BundleOpinionResolver($valueObject, $this->entityNormalizer);

        $resolver->resolveDeniedArticlesIds(null);
    }

    /**
     * @dataProvider getResolveDeniedArticlesIds
     *
     * @return void
     * @throws Exception
     */
    public function testResolveDeniedArticlesIds($jsonFilePath, $expected)
    {
        $valueObject = new BundleOpinionValueObjectMock(
            $this->testHelper->getApi(),
            1,
            "",
            1,
            1,
            "es"
        );

        $resolver = new BundleOpinionResolver($valueObject, $this->entityNormalizer);
        $result = $resolver->resolveDeniedArticlesIds($jsonFilePath);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getResolveDeniedArticlesIds(): array
    {
        return [
            [
                "jsonFilePath" => "",
                "expected" => ""
            ],
            [
                "jsonFilePath" => $this->fileNoExists,
                "expected" => ""
            ],
            [
                "jsonFilePath" => $this->fileExists,
                "expected" => "1"
            ]
        ];
    }

    /**
     * @dataProvider getResolveArticles
     *
     * @return void
     * @throws Exception
     */
    public function testResolveArticles($valueObject, $expected)
    {
        $resolver = new BundleOpinionResolver($valueObject, $this->entityNormalizer);
        $result = $resolver->resolveArticles();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getResolveArticles(): array
    {
        return [
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->testHelper->getApi(),
                    1,
                    1
                ),
                "expected" => [
                    0 => [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->testHelper->getApi(),
                    1,
                    "",
                    0
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->testHelper->getApi(),
                    1,
                    "",
                    1,
                    1,
                    "es",
                    ""
                ),
                "expected" => [
                    0 => [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->testHelper->getApi(),
                    1,
                    "",
                    1,
                    1,
                    "es",
                    $this->fileExists
                ),
                "expected" => [
                    0 => [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ]
        ];
    }
}