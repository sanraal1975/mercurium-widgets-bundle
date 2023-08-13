<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items;

use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;
use Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items\RichSnippetPerson;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\RichSnippetPublisherValueObject;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class RichSnippetPersonTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items
 */
class RichSnippetPersonTest extends TestCase
{
    /**
     * @var RichSnippetPublisherValueObject
     */
    private $richSnippetPublisherValueObject;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->richSnippetPublisherValueObject = new RichSnippetPublisherValueObject(
            "Foo",
            "www.foo.bar",
            [],
            "facebook",
            []
        );
    }

    /**
     * @dataProvider getSchema
     *
     * @param $entity
     * @param $expected
     *
     * @return void
     * @throws Exception
     */
    public function testGetSchema($entity, $expected)
    {
        $richSnippet = new RichSnippetPerson($this->richSnippetPublisherValueObject);

        $result = $richSnippet->getSchema($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     *
     * @return array[]
     */
    public function getSchema(): array
    {
        return [
            [
                "entity" => [],
                "expected" => []
            ],
            [
                "entity" => [
                    "url" => "www.foo.bar"
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_PERSON,
                    "url" => "",
                    "affiliation" => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ]
                ]
            ],
            [
                "entity" => [
                    "fullName" => "Foo Bar"
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_PERSON,
                    "url" => "",
                    "name" => "Foo Bar",
                    "affiliation" => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ]
                ]
            ],
            [
                "entity" => [
                    "name" => "Foo Bar",
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_PERSON,
                    "url" => "",
                    "givenName" => "Foo Bar",
                    "affiliation" => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ]
                ]
            ],
            [
                "entity" => [
                    "surname" => "Foo Bar",
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_PERSON,
                    "url" => "",
                    "familyName" => "Foo Bar",
                    "affiliation" => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ]
                ]
            ],
            [
                "entity" => [
                    "profession" => "Foo Bar",
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_PERSON,
                    "url" => "",
                    "jobTitle" => "Foo Bar",
                    "affiliation" => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ]
                ]
            ],
        ];
    }
}