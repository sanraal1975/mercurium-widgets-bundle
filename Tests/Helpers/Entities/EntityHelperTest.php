<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntiyHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class EntityHelperTest extends TestCase
{
    /**
     * @dataProvider hasCategoryReturnFalse
     *
     * @param array $article
     * @param int $categoryId
     *
     * @return void
     */
    public function testHasCategoryReturnFalse(array $article, int $categoryId)
    {
        $helper = new EntityHelper();
        $result = $helper->hasCategory($article, $categoryId);

        $this->assertFalse($result);
    }

    /**
     * @return array[]
     */
    public function hasCategoryReturnFalse(): array
    {
        /*
         * 0 -> empty article
         * 1 -> article without categories key
         * 2 -> invalid categoryId
         */

        return [
            [
                "article" => [],
                "categoryId" => 0
            ],
            [
                "article" => [EntityConstants::ID_FIELD_KEY => []],
                "categoryId" => 0
            ],
            [
                "article" => [EntityConstants::CATEGORIES_FIELD_KEY => [0 => [EntityConstants::ID_FIELD_KEY => 2]]],
                "categoryId" => 0
            ],
            [
                "article" => [EntityConstants::CATEGORIES_FIELD_KEY => [0 => [EntityConstants::ID_FIELD_KEY => 2]]],
                "categoryId" => 3
            ]
        ];
    }

    /**
     * @dataProvider hasCategoryReturnTrue
     *
     * @param array $article
     * @param int $categoryId
     *
     * @return void
     */
    public function testHasCategoryReturnTrue(array $article, int $categoryId)
    {
        $api = new Client("https:foo.bar", "fake_token");

        $helper = new EntityHelper($api);
        $result = $helper->hasCategory($article, $categoryId);

        $this->assertTrue($result);
    }

    /**
     *
     * @return array[]
     */
    public function hasCategoryReturnTrue(): array
    {
        return [
            [
                "article" => [EntityConstants::CATEGORIES_FIELD_KEY => [0 => [EntityConstants::ID_FIELD_KEY => 2]]],
                "categoryId" => 2
            ]
        ];
    }

    /**
     *
     * @return void
     */
    public function testHasCategoryTypeErrorExceptionInvalidArticle()
    {
        $this->expectException(TypeError::class);

        $helper = new EntityHelper();
        $helper->hasCategory(null, 2);
    }

    /**
     *
     * @return void
     */
    public function testHasCategoryTypeErrorExceptionInvalidCategoryId()
    {
        $this->expectException(TypeError::class);

        $helper = new EntityHelper();
        $helper->hasCategory([], null);
    }

    /**
     *
     * @return void
     */
    public function testGetFieldReadingTimeInvalidEntity()
    {
        $this->expectException(TypeError::class);

        $helper = new EntityHelper();
        $helper->getFieldReadingTime(null, "", 2);
    }

    /**
     *
     * @return void
     */
    public function testGetFieldReadingTimeInvalidField()
    {
        $this->expectException(TypeError::class);

        $helper = new EntityHelper();
        $helper->getFieldReadingTime([], null, 2);
    }

    /**
     *
     * @return void
     */
    public function testGetFieldReadingTimeInvalidCharactersPerMinute()
    {
        $this->expectException(TypeError::class);

        $helper = new EntityHelper();
        $helper->getFieldReadingTime([], "", null);
    }

    /**
     * @dataProvider getFieldReadingTimeReturnsZero
     *
     * @return void
     */
    public function testGetFieldReadingTimeReturnsZero(array $entity, string $field, int $charactersPerMinute)
    {
        $helper = new EntityHelper();
        $result = $helper->getFieldReadingTime($entity, $field, $charactersPerMinute);

        $this->assertEquals(0, $result);
    }

    /**
     *
     * @return array[]
     */
    public function getFieldReadingTimeReturnsZero(): array
    {
        /*
         * 0 -> empty entity
         * 1 -> empty field
         * 2 -> field not found in entity
         * 3 -> characters per minute wrong value
         */

        return [
            [
                "entity" => [],
                "field" => "body",
                "charactersPerMinute" => 2
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "field" => "",
                "charactersPerMinute" => 2
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "field" => "body",
                "charactersPerMinute" => 2
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "field" => EntityConstants::ID_FIELD_KEY,
                "charactersPerMinute" => 0
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "field" => EntityConstants::ID_FIELD_KEY,
                "charactersPerMinute" => -1
            ],
        ];
    }

    /**
     *
     * @return void
     */
    public function testGetFieldReadingTimeReturnValue()
    {
        $helper = new EntityHelper();
        $result = $helper->getFieldReadingTime(
            [
                "body" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
            ],
            "body",
            3
        );

        $this->assertEquals(41, $result);
    }

    /**
     *
     * @return void
     */
    public function testGetFieldLengthReturnZero()
    {
        $helper = new EntityHelper();
        $result = $helper->getFieldLength("");

        $this->assertEquals(0, $result);
    }

    /**
     * @dataProvider getFieldLengthReturnValue()
     *
     * @return void
     */
    public function testGetFieldLengthReturnValue(string $field)
    {
        $helper = new EntityHelper();
        $result = $helper->getFieldLength($field);

        $this->assertEquals(123, $result);
    }

    /**
     *
     * @return array[]
     */
    public function getFieldLengthReturnValue(): array
    {
        /*
         * 0 -> standard value
         * 1 -> value with more than 1 space between words
         * 2 -> value with html tags
         * 2 -> value with html tags and more than 1 space between words
         */

        return [
            [
                "field" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
            ],
            [
                "field" => "Lorem  ipsum dolor sit amet,  consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
            ],
            [
                "field" => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>"
            ],
            [
                "field" => "<p>Lorem  ipsum dolor sit amet,  consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>"
            ]
        ];
    }

    /**
     * @dataProvider clearEmbedScripts
     *
     * @param string $data
     * @param string $expected
     *
     * @return void
     */
    public function testClearEmbedScripts(string $data, string $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->clearEmbedScripts($data);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function clearEmbedScripts(): array
    {
        return [
            [
                "data" => 'Hello <script src="https://platform.twitter.com"></script>twitter',
                "result" => 'Hello twitter'
            ],
            [
                "data" => 'Hello <script src="https://platform.twitter.com" async></script>twitter',
                "result" => 'Hello twitter'
            ],
            [
                "data" => 'Hello <script defer src="https://platform.twitter.com"></script>twitter',
                "result" => 'Hello twitter'
            ],
            [
                "data" => 'Hello <script src="//www.instagram.com/embed"></script>instagram',
                "result" => 'Hello instagram'
            ],
            [
                "data" => 'Hello <script src="//www.instagram.com/embed/t=1"></script>instagram',
                "result" => 'Hello instagram'
            ],
            [
                "data" => 'Hello <script defer src="//www.instagram.com/embed/t=1"></script>instagram',
                "result" => 'Hello instagram'
            ],
            [
                "data" => 'Hello <script src="//www.instagram.com/embed/t=1" async></script>instagram',
                "result" => 'Hello instagram'
            ],
            [
                "data" => 'Hello <script src="https://www.tiktok.com/embed/t=1"></script>tiktok',
                "result" => 'Hello tiktok'
            ],
            [
                "data" => 'Hello <script src="https://www.tiktok.com/embed"></script>tiktok',
                "result" => 'Hello tiktok'
            ],
            [
                "data" => 'Hello <script defer src="https://www.tiktok.com/embed/t=1"></script>tiktok',
                "result" => 'Hello tiktok'
            ],
            [
                "data" => 'Hello <script src="https://www.tiktok.com/embed/t=1" async></script>tiktok',
                "result" => 'Hello tiktok'
            ],
            [
                "data" => 'Hello <script src="https://www.facebook.com/plugins/post.php?"></script>facebook',
                "result" => 'Hello <script loading="lazy" src="https://www.facebook.com/plugins/post.php?"></script>facebook'
            ],
            [
                "data" => '',
                "result" => ''
            ],
        ];
    }

    /**
     * @dataProvider replaceYoutubeCode
     *
     * @param string $data
     * @param string $expected
     *
     * @return void
     */
    public function testReplaceYoutubeCode(string $data, string $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->replaceYoutubeCode($data);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function replaceYoutubeCode(): array
    {
        return [
            [
                "data" => '<iframe src="youtube.com/embed/embed1"></iframe>',
                "result" => '<div class="youtube-player" data-id="embed1"></div>'
            ],
            [
                "data" => '<iframe src="youtube.com/embed/embed1" allowfullscreen></iframe>',
                "result" => '<div class="youtube-player" data-id="embed1"></div>'
            ],
            [
                "data" => '<iframe allowfullscreen src="youtube.com/embed/embed1"></iframe>',
                "result" => '<div class="youtube-player" data-id="embed1"></div>'
            ],
            [
                "data" => '<iframe allowfullscreen src="youtube.com/embed/embed1" width="100"></iframe>',
                "result" => '<div class="youtube-player" data-id="embed1"></div>'
            ],
        ];
    }

    /**
     * @dataProvider getFieldReturnFalse
     *
     * @return void
     */
    public function testGetFieldReturnFalse(array $entity, string $field, $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->getField($entity, $field);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getFieldReturnFalse(): array
    {
        return [
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "field" => EntityConstants::PERMALINK_FIELD_KEY,
                "expected" => false
            ]
        ];
    }

    /**
     * @dataProvider getFieldReturnValue
     *
     * @return void
     */
    public function testGetFieldReturnValue(array $entity, string $field, $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->getField($entity, $field);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getFieldReturnValue(): array
    {
        return [
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "field" => EntityConstants::ID_FIELD_KEY,
                "expected" => 1
            ],
        ];
    }

    /**
     * @dataProvider getId
     *
     * @return void
     */
    public function testGetId(array $entity, $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->getId($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getId(): array
    {
        return [
            [
                "entity" => ["ids" => 1],
                "expected" => 0
            ],
            [
                "entity" => ["id" => 1],
                "expected" => 1
            ],
        ];
    }

    /**
     * @dataProvider getPermalinkReturnEmpty
     *
     * @return void
     */
    public function testGetPermalinkReturnEmpty(array $entity, $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->getPermalink($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getPermalinkReturnEmpty(): array
    {
        return [
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => ""
            ]
        ];
    }

    /**
     * @dataProvider getPermalinkReturnValue
     *
     * @return void
     */
    public function testGetPermalinkReturnValue(array $entity, $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->getPermalink($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getPermalinkReturnValue(): array
    {
        return [
            [
                "entity" => [EntityConstants::PERMALINK_FIELD_KEY => "https://www.google.es"],
                "expected" => "https://www.google.es"
            ],
        ];
    }

    /**
     * @dataProvider getPermalinksReturnEmpty
     *
     * @return void
     */
    public function testGetPermalinksReturnEmpty(array $entity, $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->getPermalinks($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getPermalinksReturnEmpty(): array
    {
        return [
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => []
            ]
        ];
    }

    /**
     * @dataProvider getPermalinksReturnValue
     *
     * @return void
     */
    public function testGetPermalinksReturnValue(array $entity, $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->getPermalinks($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getPermalinksReturnValue(): array
    {
        return [
            [
                "entity" => [EntityConstants::PERMALINKS_FIELD_KEY => ["ca" => "https://www.google.ca", "es" => "https://www.google.es"]],
                "expected" => ["ca" => "https://www.google.ca", "es" => "https://www.google.es"]
            ],
        ];
    }

    /**
     * @dataProvider getExpirationDateReturnEmpty
     *
     * @return void
     */
    public function testGetExpirationDateReturnEmpty(array $entity, $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->getExpirationDate($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getExpirationDateReturnEmpty(): array
    {
        return [
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => ""
            ]
        ];
    }

    /**
     * @dataProvider getExpirationDateReturnValue
     *
     * @return void
     */
    public function testGetExpirationDateReturnValue(array $entity, $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->getExpirationDate($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getExpirationDateReturnValue(): array
    {
        return [
            [
                "entity" => [EntityConstants::EXPIRATION_DATE_FIELD_KEY => "2024-01-01 00:00:00"],
                "expected" => "2024-01-01 00:00:00"
            ]
        ];
    }

    /**
     * @dataProvider getSubscriptionsReturnEmpty
     *
     * @return void
     */
    public function testGetSubscriptionsReturnEmpty(array $entity, $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->getSubscriptions($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getSubscriptionsReturnEmpty(): array
    {
        return [
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => []
            ],
        ];
    }

    /**
     * @dataProvider getSubscriptionsReturnValue
     *
     * @return void
     */
    public function testGetSubscriptionsReturnValue(array $entity, $expected)
    {
        $helper = new EntityHelper();
        $result = $helper->getSubscriptions($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getSubscriptionsReturnValue(): array
    {
        return [
            [
                "entity" => [EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => 1]]],
                "expected" => [[EntityConstants::ID_FIELD_KEY => 1]]
            ],
        ];
    }
}