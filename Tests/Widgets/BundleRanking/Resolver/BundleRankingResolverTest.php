<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleRanking\Resolver;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleRanking\ValueObject\BundleRankingValueObjectMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Resolver\BundleRankingResolver;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class BundleRankingResolverTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleRanking\Resolver
 */
class BundleRankingResolverTest extends TestCase
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
        $this->fileExists = $this->cwd . "/Tests/Widgets/BundleRanking/BundleRankingJson.json";
        $this->fileNoExists = $this->cwd . "/Tests/Widgets/BundleRanking/BundleRankingJsons.json";
        $this->entityNormalizer = new EntityNormalizer([new NormalizerMock()]);
    }

    /**
     * @dataProvider getResolveJsonFilePath
     *
     * @return void
     * @throws Exception
     */
    public function testResolveJsonFilePath($valueObject, $expected)
    {
        $resolver = new BundleRankingResolver($valueObject, $this->entityNormalizer);
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
                "valueObject" => new BundleRankingValueObjectMock(
                    $this->testHelper->getApi(),
                    "es",
                    "",
                    1,
                    "dev",
                    "@HOME_URL@/uploads/static/@SUBSITE_ACRONYM@/",
                    "/var/www/@SITE_PREFIX@/prod/front/@SUBSITE_ACRONYM@/current/web/uploads/static/@SUBSITE_ACRONYM@/",
                    "https://www.foo.bar",
                    "foo",
                    "bar"
                ),
                "expected" => ""
            ],
            [
                "valueObject" => new BundleRankingValueObjectMock(
                    $this->testHelper->getApi(),
                    "es",
                    "BundleRankingJson.json",
                    1,
                    "dev",
                    "@HOME_URL@/uploads/static/@SUBSITE_ACRONYM@/",
                    "/var/www/@SITE_PREFIX@/prod/front/@SUBSITE_ACRONYM@/current/web/uploads/static/@SUBSITE_ACRONYM@/",
                    "https://www.foo.bar",
                    "foo",
                    "bar"
                ),
                "expected" => "https://www.foo.bar/uploads/static/foo/BundleRankingJson.json"
            ],
            [
                "valueObject" => new BundleRankingValueObjectMock(
                    $this->testHelper->getApi(),
                    "es",
                    "BundleRankingJson.json",
                    1,
                    "prod",
                    "@HOME_URL@/uploads/static/@SUBSITE_ACRONYM@/",
                    "/var/www/@SITE_PREFIX@/prod/front/@SUBSITE_ACRONYM@/current/web/uploads/static/@SUBSITE_ACRONYM@/",
                    "https://www.foo.bar",
                    "foo",
                    "bar"
                ),
                "expected" => "/var/www/bar/prod/front/foo/current/web/uploads/static/foo/BundleRankingJson.json"
            ]
        ];
    }

    /**
     * @dataProvider getResolveArticles
     *
     * @return void
     * @throws Exception
     */
    public function testResolveArticles($valueObject, $jsonFilePath, $expected)
    {
        $resolver = new BundleRankingResolver($valueObject, $this->entityNormalizer);
        $result = $resolver->resolveArticles($jsonFilePath);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getResolveArticles(): array
    {
        return [
            [
                "valueObject" => new BundleRankingValueObjectMock(
                    $this->testHelper->getApi(),
                    "es",
                    "",
                    1,
                    "dev",
                    "@HOME_URL@/uploads/static/@SUBSITE_ACRONYM@/",
                    "/var/www/@SITE_PREFIX@/prod/front/@SUBSITE_ACRONYM@/current/web/uploads/static/@SUBSITE_ACRONYM@/",
                    "https://www.foo.bar",
                    "foo",
                    "bar"
                ),
                "jsonFilePath" => "",
                "expected" => []
            ],
            [
                "valueObject" => new BundleRankingValueObjectMock(
                    $this->testHelper->getApi(),
                    "es",
                    "BundleRankingJson.json",
                    1,
                    "dev",
                    "@HOME_URL@/uploads/static/@SUBSITE_ACRONYM@/",
                    "/var/www/@SITE_PREFIX@/prod/front/@SUBSITE_ACRONYM@/current/web/uploads/static/@SUBSITE_ACRONYM@/",
                    "https://www.foo.bar",
                    "foo",
                    "bar"
                ),
                "jsonFilePath" => $this->fileNoExists,
                "expected" => []
            ],
            [
                "valueObject" => new BundleRankingValueObjectMock(
                    $this->testHelper->getApi(),
                    "es",
                    "BundleRankingJson.json",
                    1,
                    "prod",
                    "@HOME_URL@/uploads/static/@SUBSITE_ACRONYM@/",
                    "/var/www/@SITE_PREFIX@/prod/front/@SUBSITE_ACRONYM@/current/web/uploads/static/@SUBSITE_ACRONYM@/",
                    "https://www.foo.bar",
                    "foo",
                    "bar"
                ),
                "jsonFilePath" => $this->fileExists,
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