<?php

namespace Behat\Tests\Config;

use Behat\Config\Suite;
use PHPUnit\Framework\TestCase;

final class SuiteTest extends TestCase
{
    public function testSuiteCanBeConvertedIntoAnArray(): void
    {
        $suite = new Suite('first');

        $this->assertIsArray($suite->toArray());
    }

    public function testItReturnsSettings(): void
    {
        $settings = [
            'contexts' => [
                'FirstContext',
            ],
        ];

        $suite = new Suite('first', $settings);

        $this->assertEquals($settings, $suite->toArray());
    }

    public function testAddingContexts(): void
    {
        $config = new Suite('first');
        $config->withContexts('FirstContext', 'SecondContext');
        $config->addContext('ThirdContext', ['http://localhost:8080', '/var/tmp']);

        $this->assertEquals([
            'contexts' => [
                'FirstContext',
                'SecondContext',
                [
                    'ThirdContext' => [
                        'http://localhost:8080',
                        '/var/tmp'
                    ],
                ],
            ]
        ], $config->toArray());
    }

    public function testAddingPaths(): void
    {
        $config = new Suite('first');
        $config->withPaths('features/admin/first', 'features/front/first');
        $config->withPaths('features/api/first');

        $this->assertEquals([
            'paths' => [
                'features/admin/first',
                'features/front/first',
                'features/api/first',
            ]
        ], $config->toArray());
    }
}
