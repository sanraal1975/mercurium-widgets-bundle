<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items;

use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;
use Comitium5\MercuriumWidgetsBundle\Factories\RichSnippetsFactory;
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

        $factory = new RichSnippetsFactory();
        $this->richSnippetPublisherValueObject = $factory->createRichSnippetPublisherValueObject(
            'Foo',
            'www.foo.bar',
            [],
            'facebook',
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
                'entity' => [],
                'expected' => []
            ],
            [
                'entity' => [
                    'url' => 'www.foo.bar'
                ],
                'expected' => [
                    '@type' => RichSnippetsConstants::TYPE_PERSON,
                    'url' => '',
                    'affiliation' => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ]
                ]
            ],
            [
                'entity' => [
                    'fullName' => 'Foo Bar'
                ],
                'expected' => [
                    '@type' => RichSnippetsConstants::TYPE_PERSON,
                    'url' => '',
                    'name' => 'Foo Bar',
                    'affiliation' => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ]
                ]
            ],
            [
                'entity' => [
                    'name' => 'Foo Bar',
                ],
                'expected' => [
                    '@type' => RichSnippetsConstants::TYPE_PERSON,
                    'url' => '',
                    'givenName' => 'Foo Bar',
                    'affiliation' => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ]
                ]
            ],
            [
                'entity' => [
                    'surname' => 'Foo Bar',
                ],
                'expected' => [
                    '@type' => RichSnippetsConstants::TYPE_PERSON,
                    'url' => '',
                    'familyName' => 'Foo Bar',
                    'affiliation' => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ]
                ]
            ],
            [
                'entity' => [
                    'profession' => 'Foo Bar',
                ],
                'expected' => [
                    '@type' => RichSnippetsConstants::TYPE_PERSON,
                    'url' => '',
                    'jobTitle' => 'Foo Bar',
                    'affiliation' => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ]
                ]
            ],
            [
                'entity' => [
                    'tipologies' => ['Foo Bar'],
                ],
                'expected' => [
                    '@type' => RichSnippetsConstants::TYPE_PERSON,
                    'url' => '',
                    'affiliation' => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ],
                    'contactPoint' => [
                        '@type' => RichSnippetsConstants::TYPE_CONTACT_POINT,
                        'contactType' => 'Foo Bar'
                    ]
                ]
            ],
            [
                'entity' => [
                    'permalink' => 'www.foo.bar',
                    'tipologies' => ['Foo Bar'],
                ],
                'expected' => [
                    '@type' => RichSnippetsConstants::TYPE_PERSON,
                    'url' => 'www.foo.bar',
                    'affiliation' => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ],
                    'contactPoint' => [
                        '@type' => RichSnippetsConstants::TYPE_CONTACT_POINT,
                        'contactType' => 'Foo Bar',
                        'url' => 'www.foo.bar',
                    ]
                ]
            ],
            [
                'entity' => [
                    'permalink' => 'www.foo.bar',
                    'email' => 'foo@bar.com',
                    'tipologies' => ['Foo Bar'],
                ],
                'expected' => [
                    '@type' => RichSnippetsConstants::TYPE_PERSON,
                    'url' => 'www.foo.bar',
                    'email' => 'foo@bar.com',
                    'affiliation' => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ],
                    'contactPoint' => [
                        '@type' => RichSnippetsConstants::TYPE_CONTACT_POINT,
                        'contactType' => 'Foo Bar',
                        'url' => 'www.foo.bar',
                        'email' => 'foo@bar.com',
                    ]
                ]
            ],
            [
                'entity' => [
                    'biography' => 'lorem ipsum',
                ],
                'expected' => [
                    '@type' => RichSnippetsConstants::TYPE_PERSON,
                    'url' => '',
                    'description' => 'lorem ipsum',
                    'affiliation' => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ],
                ]
            ],
            [
                'entity' => [
                    'socialNetworks' => [["url" => "www.foo.bar"]],
                ],
                'expected' => [
                    '@type' => RichSnippetsConstants::TYPE_PERSON,
                    'url' => '',
                    'sameAs' => ["www.foo.bar"],
                    'affiliation' => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ],
                ]
            ],
            [
                'entity' => [
                    'asset' => [
                        'url' => "www.foo.bar"
                    ],
                ],
                'expected' => [
                    '@type' => RichSnippetsConstants::TYPE_PERSON,
                    'url' => '',
                    'affiliation' => [
                        '@type' => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                        'name' => 'Foo',
                        'url' => 'www.foo.bar',
                        'logo' => [],
                        'sameAs' => []
                    ],
                    'image' => [
                        '@type' => RichSnippetsConstants::TYPE_IMAGE,
                        'url' => 'www.foo.bar',
                        'width' => 0,
                        'height' => 0,
                    ],
                ]
            ],
        ];
    }
}