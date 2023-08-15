<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers;

use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiResultsHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers
 */
class ApiResultsHelperTest extends TestCase
{

    /**
     * @dataProvider extractOneResultsFound
     *
     * @param array $data
     * @param int $position
     * @param string $key
     *
     * @return void
     */
    public function testExtractOneResultsFound(array $data, int $position, string $key)
    {
        if ($key !== "") {
            $result = ApiResultsHelper::extractOne($data, $position, $key);
        } else {
            if ($position !== -1) {
                $result = ApiResultsHelper::extractOne($data, $position);
            } else {
                $result = ApiResultsHelper::extractOne($data);
            }
        }

        $this->assertEquals(["id" => 1], $result);
    }

    /**
     * @dataProvider extractOneEmptyResults
     *
     * @param array $data
     * @param int $position
     * @param string $key
     *
     * @return void
     */
    public function testExtractOneEmptyResults(array $data, int $position, string $key)
    {
        if ($key !== "") {
            $result = ApiResultsHelper::extractOne($data, $position, $key);
        } else {
            if ($position !== -1) {
                $result = ApiResultsHelper::extractOne($data, $position);
            } else {
                $result = ApiResultsHelper::extractOne($data);
            }
        }

        $this->assertEquals([], $result);
    }

    /**
     * @dataProvider extractResultsResultsFound
     *
     * @param array $data
     * @param string $key
     *
     * @return void
     */
    public function testExtractResultsResultsFound(array $data, string $key)
    {
        if ($key !== "") {
            $result = ApiResultsHelper::extractResults($data, $key);
        } else {
            $result = ApiResultsHelper::extractResults($data);
        }

        $this->assertEquals([0 => ["id" => 1]], $result);
    }

    /**
     * @dataProvider extractResultsEmptyResults
     *
     * @param array $data
     * @param string $key
     *
     * @return void
     */
    public function testExtractResultsEmptyResults(array $data, string $key)
    {
        if ($key !== "") {
            $result = ApiResultsHelper::extractResults($data, $key);
        } else {
            $result = ApiResultsHelper::extractResults($data);
        }

        $this->assertEquals([], $result);
    }

    /**
     *
     * @return \array[][]
     */
    public function extractOneEmptyResults(): array
    {
        // position = -1 won"t be used in the test
        // key = "" won"t be used in the test

        /*
         * 0 -> empty data
         * 1 -> data with invalid key
         * 2 -> data with valid key and empty
         * 3 -> data with valid key, content and not valid position
         * 4 -> data with custom key, content, valid key and not valid position
         */

        return [
            [
                "data" => [],
                "position" => -1,
                "key" => ""
            ],
            [
                "data" => ["data" => []],
                "position" => -1,
                "key" => ""
            ],
            [
                "data" => ["results" => []],
                "position" => -1,
                "key" => ""
            ],
            [
                "data" => ["results" => [0 => ["id" => 1]]],
                "position" => 1,
                "key" => ""
            ],
            [
                "data" => ["response" => [0 => ["id" => 1]]],
                "position" => 1,
                "key" => "response"
            ],
        ];
    }

    /**
     *
     * @return array[]
     */
    public function extractOneResultsFound(): array
    {
        // position = -1 won"t be used in the test
        // key = "" won"t be used in the test

        /*
         * 0 -> data with default key and content
         * 1 -> data with default key, content and valid position
         * 2 -> data with custom key and content
         */

        return [
            [
                "data" => ["results" => [0 => ["id" => 1]]],
                "position" => -1,
                "key" => ""
            ],
            [
                "data" => ["results" => [1 => ["id" => 1]]],
                "position" => 1,
                "key" => ""
            ],
            [
                "data" => ["response" => [0 => ["id" => 1]]],
                "position" => 0,
                "key" => "response"
            ]
        ];
    }

    /**
     *
     * @return array[]
     */
    public function extractResultsEmptyResults(): array
    {
        // key = "" won"t be used in the test

        return [
            [
                "data" => [],
                "key" => ""
            ],
            [
                "data" => ["results"],
                "key" => ""
            ],
            [
                "data" => ["results" => []],
                "key" => ""
            ],
            [
                "data" => ["results" => [0 => ["id" => 1]]],
                "key" => "response"
            ],
        ];
    }

    /**
     *
     * @return array[]
     */
    public function extractResultsResultsFound(): array
    {
        // key = "" won"t be used in the test

        return [
            [
                "data" => ["results" => [0 => ["id" => 1]]],
                "key" => ""
            ],
            [
                "data" => ["results" => [0 => ["id" => 1]]],
                "key" => "results"
            ],
            [
                "data" => ["response" => [0 => ["id" => 1]]],
                "key" => "response"
            ]
        ];
    }
}