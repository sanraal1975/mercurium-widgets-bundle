<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHeader\Resolver;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces\BundleHeaderValueObjectInterface;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\ValueObject\BundleHeaderValueObject;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Resolver\BundleHeaderResolver;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;
use ReflectionClass;

/**
 * Class BundleHeaderResolverTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHeader\Resolver
 */
class BundleHeaderResolverTest extends TestCase
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
     * @var BundleHeaderValueObjectInterface
     */
    private $valueObject;

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
        $this->valueObject = new BundleHeaderValueObject(
            $this->api,
            ["ca","es"],
            "foo",
            [
                EntityConstants::ID_FIELD_KEY=>1,
                EntityConstants::PERMALINK_FIELD_KEY=>"https://foo.bar",
                EntityConstants::PERMALINKS_FIELD_KEY=>["ca"=>"https://foo.bar","es"=>"https://bar.foo"]                
            ],
            [
                EntityConstants::ID_FIELD_KEY=>1,
                EntityConstants::PERMALINK_FIELD_KEY=>"https://foo.bar",
                EntityConstants::PERMALINKS_FIELD_KEY=>["ca"=>"https://foo.bar","es"=>"https://bar.foo"],                
                EntityConstants::SEARCHABLE_FIELD_KEY=>true,
            ],
            1,
            1,
            1,
            1,
            1,
            "Foo Bar",
            "https://foo.bar"
        );
    }

    /**
     * @dataProvider getTestResolveLocaleUrls
     *
     * @return void
     */
    public function testResolveLocaleUrls($valueObject,$expected)
    {
        $resolver = new BundleHeaderResolver($valueObject);
        $reflectedClass=new ReflectionClass(BundleHeaderResolver::class);
        $method=$reflectedClass->getMethod('resolveLocaleUrls');
        $method->setAccessible(true);
        $result=$method->invoke($resolver);

        $this->assertEquals($expected,$result);
    }

    /**
     * 
     */
    public function getTestResolveLocaleUrls()
    {
        return [
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [],
                    [],
                    1,
                    1,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca","es"],
                    "foo",
                    [],
                    [],
                    1,
                    1,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca","es"],
                    "foo",
                    [],
                    [
                        EntityConstants::ID_FIELD_KEY=>1,
                        EntityConstants::PERMALINK_FIELD_KEY=>"https://entity.foo.bar",
                        EntityConstants::PERMALINKS_FIELD_KEY=>["ca"=>"https://entity.foo.bar","es"=>"https://entity.bar.foo"],                
                        EntityConstants::SEARCHABLE_FIELD_KEY=>true,
                    ],
                    1,
                    1,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => ["ca"=>"https://entity.foo.bar","es"=>"https://entity.bar.foo"]
            ],
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca","es"],
                    "foo",
                    [
                        EntityConstants::ID_FIELD_KEY=>1,
                        EntityConstants::PERMALINK_FIELD_KEY=>"https://page.foo.bar",
                        EntityConstants::PERMALINKS_FIELD_KEY=>["ca"=>"https://page.foo.bar","es"=>"https://page.bar.foo"]                
                    ],
                    [],
                    1,
                    1,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => ["ca"=>"https://page.foo.bar","es"=>"https://page.bar.foo"]
            ]
        ];
    }

    /**
     * @dataProvider getTestResolveIsHome
     *
     * @return void
     */
    public function testResolveIsHome($valueObject,$expected)
    {
        $resolver = new BundleHeaderResolver($valueObject);
        $reflectedClass=new ReflectionClass(BundleHeaderResolver::class);
        $method=$reflectedClass->getMethod('resolveIsHome');
        $method->setAccessible(true);
        $result=$method->invoke($resolver);

        $this->assertEquals($expected,$result);
    }

    /**
     * 
     */
    public function getTestResolveIsHome()
    {
        return [
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [],
                    [],
                    1,
                    1,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => false
            ],
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [
                        EntityConstants::PERMALINK_FIELD_KEY=>"https://page.foo.bar",
                    ],
                    [],
                    1,
                    1,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => false
            ],
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [
                        EntityConstants::ID_FIELD_KEY=>2,
                    ],
                    [],
                    1,
                    1,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => false
            ],
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [
                        EntityConstants::ID_FIELD_KEY=>1,
                    ],
                    [],
                    1,
                    1,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => true
            ],
       ];
    }

    /**
     * @dataProvider getTestResolveSearchPage
     *
     * @return void
     */
    public function testResolveSearchPage($valueObject,$expected)
    {
        $resolver = new BundleHeaderResolver($valueObject);
        $reflectedClass=new ReflectionClass(BundleHeaderResolver::class);
        $method=$reflectedClass->getMethod('resolveSearchPage');
        $method->setAccessible(true);
        $result=$method->invoke($resolver);

        $this->assertEquals($expected,$result);
    }

    /**
     * 
     */
    public function getTestResolveSearchPage()
    {
        return [
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [],
                    [],
                    1,
                    0,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [],
                    [],
                    1,
                    1,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => [
                    EntityConstants::ID_FIELD_KEY=>1,
                    EntityConstants::SEARCHABLE_FIELD_KEY=>true,
                ]
            ],
      ];
    }

    /**
     * @dataProvider getTestResolveRegisterPage
     *
     * @return void
     */
    public function testResolveRegisterPage($valueObject,$expected)
    {
        $resolver = new BundleHeaderResolver($valueObject);
        $reflectedClass=new ReflectionClass(BundleHeaderResolver::class);
        $method=$reflectedClass->getMethod('resolveRegisterPage');
        $method->setAccessible(true);
        $result=$method->invoke($resolver);

        $this->assertEquals($expected,$result);
    }

    /**
     * 
     */
    public function getTestResolveRegisterPage()
    {
        return [
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [],
                    [],
                    1,
                    1,
                    0,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [],
                    [],
                    1,
                    1,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => [
                    EntityConstants::ID_FIELD_KEY=>1,
                    EntityConstants::SEARCHABLE_FIELD_KEY=>true,
                ]
            ],
      ];
    }

    /**
     * @dataProvider getTestResolveLoginPage
     *
     * @return void
     */
    public function testResolveLoginPage($valueObject,$expected)
    {
        $resolver = new BundleHeaderResolver($valueObject);
        $reflectedClass=new ReflectionClass(BundleHeaderResolver::class);
        $method=$reflectedClass->getMethod('resolveLoginPage');
        $method->setAccessible(true);
        $result=$method->invoke($resolver);

        $this->assertEquals($expected,$result);
    }

    /**
     * 
     */
    public function getTestResolveLoginPage()
    {
        return [
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [],
                    [],
                    1,
                    1,
                    1,
                    0,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [],
                    [],
                    1,
                    1,
                    1,
                    1,
                    1,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => [
                    EntityConstants::ID_FIELD_KEY=>1,
                    EntityConstants::SEARCHABLE_FIELD_KEY=>true,
                ]
            ],
      ];
    }

    /**
     * @dataProvider getTestResolveNavItems
     *
     * @return void
     */
    public function testResolveNavItems($valueObject,$expected)
    {
        $resolver = new BundleHeaderResolver($valueObject);
        $reflectedClass=new ReflectionClass(BundleHeaderResolver::class);
        $method=$reflectedClass->getMethod('resolveNavItems');
        $method->setAccessible(true);
        $result=$method->invoke($resolver);

        $this->assertEquals($expected,$result);
    }

    /**
     * 
     */
    public function getTestResolveNavItems()
    {
        return [
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [],
                    [],
                    1,
                    1,
                    1,
                    1,
                    0,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [],
                    [],
                    1,
                    1,
                    1,
                    1,
                    TestHelper::MENU_WITHOUT_ITEMS,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHeaderValueObject(
                    $this->api,
                    ["ca"],
                    "foo",
                    [],
                    [],
                    1,
                    1,
                    1,
                    1,
                    TestHelper::MENU_WITH_ITEMS,
                    "Foo Bar",
                    "https://foo.bar"
                ),
                "expected" => [
                    [
                        "title" => "foo",
                        "permalink" => "/bar"
                    ]
                ]
            ],
        ];
    }

    /**
     * @dataProvider getTestResolveRichSnippets
     */
    public function testResolveRichSnippets($items,$expected)
    {
        $valueObject = new BundleHeaderValueObject(
            $this->api,
            ["ca"],
            "foo",
            [],
            [],
            1,
            1,
            1,
            1,
            TestHelper::MENU_WITHOUT_ITEMS,
            "Foo Bar",
            "https://foo.bar"
        );

        $resolver = new BundleHeaderResolver($valueObject);
        $reflectedClass=new ReflectionClass(BundleHeaderResolver::class);
        $method=$reflectedClass->getMethod('resolveRichSnippets');
        $method->setAccessible(true);
        $result=$method->invoke($resolver,$items);

        $this->assertEquals($expected,$result);
    }

    /**
     * 
     */
    public function getTestResolveRichSnippets()
    {
        return [
            [
                "items" => [],
                "expected" => ""
            ],
            [
                "items" => [
                    [
                        "title" => "foo",
                        "permalink" => "/foo"
                    ]
                ],
                "expected" => '<script type="application/ld+json">{"@context":"https://www.schema.org","@graph":[{"@id":"https://foo.bar - Foo Bar","@type":"SiteNavigationElement","name":"foo","url":"https://foo.bar/foo"}]}</script>'
            ]
        ];
    }

    /**
     * 
     */
    public function testResolve()
    {
        $valueObject = new BundleHeaderValueObject(
            $this->api,
            ["ca","es"],
            "foo",
            [
                EntityConstants::ID_FIELD_KEY=>1,
                EntityConstants::PERMALINK_FIELD_KEY=>"https://page.foo.bar",
                EntityConstants::PERMALINKS_FIELD_KEY=>["ca"=>"https://page.foo.bar","es"=>"https://page.bar.foo"],                
                EntityConstants::SEARCHABLE_FIELD_KEY=>true,
            ],
            [
                EntityConstants::ID_FIELD_KEY=>1,
                EntityConstants::PERMALINK_FIELD_KEY=>"https://entity.foo.bar",
                EntityConstants::PERMALINKS_FIELD_KEY=>["ca"=>"https://entity.foo.bar","es"=>"https://entity.bar.foo"],                
                EntityConstants::SEARCHABLE_FIELD_KEY=>true,
            ],
            1,
            1,
            1,
            1,
            TestHelper::MENU_WITH_ITEMS,
            "Foo Bar",
            "https://foo.bar"
        );

        $resolver = new BundleHeaderResolver($valueObject);
        $result = $resolver->resolve();

        $expected=[
            "locales" => ["ca","es"],
            "localeUrls" => ["ca"=>"https://entity.foo.bar","es"=>"https://entity.bar.foo"],
            "isHome" => true,
            "searchPage" => [
                EntityConstants::ID_FIELD_KEY=>1,
                EntityConstants::SEARCHABLE_FIELD_KEY=>true,
            ],
            "registerPage" => [
                EntityConstants::ID_FIELD_KEY=>1,
                EntityConstants::SEARCHABLE_FIELD_KEY=>true,
            ],
            "loginPage" => [
                EntityConstants::ID_FIELD_KEY=>1,
                EntityConstants::SEARCHABLE_FIELD_KEY=>true,
            ],
            "navItems" => [
                [
                    "title" => "foo",
                    "permalink" => "/bar"
                ]
            ],
            "richSnippets" => '<script type="application/ld+json">{"@context":"https://www.schema.org","@graph":[{"@id":"https://foo.bar - Foo Bar","@type":"SiteNavigationElement","name":"foo","url":"https://foo.bar/bar"}]}</script>'
        ];

        $this->assertEquals($expected,$result);
    }    
}