<?php

namespace Pgs\HashIdBundle\Tests\DependencyInjection;

use Hashids\Hashids;
use Pgs\HashIdBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfigurationRootName()
    {
        $configuration = new Configuration();
        $treeBuilder = $configuration->getConfigTreeBuilder();
        $tree = $treeBuilder->buildTree();
        $this->assertSame(Configuration::ROOT_NAME, $tree->getName());
    }

    /**
     * @dataProvider dataTestConfiguration
     */
    public function testConfigurationIfHashidsExists(array $inputConfig, array $expectedConfig)
    {
        if (!class_exists(Hashids::class)) {
            $this->markTestSkipped();
        }

        $configuration = new Configuration();

        $node = $configuration->getConfigTreeBuilder()
            ->buildTree();
        $normalizedConfig = $node->normalize($inputConfig);
        $finalizedConfig = $node->finalize($normalizedConfig);

        $this->assertSame($expectedConfig, $finalizedConfig);
    }

    public function dataTestConfiguration()
    {
        $defaultAlphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

        return [
            'default' => [
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [
                        ],
                    ],
                ],
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [
                            Configuration::NODE_CONVERTER_HASHIDS_SALT => null,
                            Configuration::NODE_CONVERTER_HASHIDS_MIN_HASH_LENGTH => 10,
                            Configuration::NODE_CONVERTER_HASHIDS_ALPHABET => $defaultAlphabet,
                        ],
                    ],
                ],
            ],
            'set salt' => [
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [
                            Configuration::NODE_CONVERTER_HASHIDS_SALT => 'test_salt',
                        ],
                    ],
                ],
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [
                            Configuration::NODE_CONVERTER_HASHIDS_SALT => 'test_salt',
                            Configuration::NODE_CONVERTER_HASHIDS_MIN_HASH_LENGTH => 10,
                            Configuration::NODE_CONVERTER_HASHIDS_ALPHABET => $defaultAlphabet,
                        ],
                    ],
                ],
            ],
            'set all' => [
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [
                            Configuration::NODE_CONVERTER_HASHIDS_SALT => 'test_salt',
                            Configuration::NODE_CONVERTER_HASHIDS_MIN_HASH_LENGTH => 10,
                            Configuration::NODE_CONVERTER_HASHIDS_ALPHABET => 'abcABC',
                        ],
                    ],
                ],
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [
                            Configuration::NODE_CONVERTER_HASHIDS_SALT => 'test_salt',
                            Configuration::NODE_CONVERTER_HASHIDS_MIN_HASH_LENGTH => 10,
                            Configuration::NODE_CONVERTER_HASHIDS_ALPHABET => 'abcABC',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataTestConfigurationIfHashidsMissing
     */
    public function testConfigurationIfHashidsMissing(array $inputConfig, array $expectedConfig)
    {
        /** @var Configuration|MockObject $configuration */
        $configuration = $this
            ->getMockBuilder(Configuration::class)
            ->setMethods(['supportsHashids'])
            ->getMock();
        $configuration->method('supportsHashids')->willReturn(false);

        $node = $configuration->getConfigTreeBuilder()
            ->buildTree();
        $normalizedConfig = $node->normalize($inputConfig);
        $finalizedConfig = $node->finalize($normalizedConfig);

        $this->assertSame($expectedConfig, $finalizedConfig);
    }

    public function dataTestConfigurationIfHashidsMissing()
    {
        return [
            'default' => [
                [
                    Configuration::NODE_CONVERTER => [
                    ],
                ],
                [
                    Configuration::NODE_CONVERTER => [
                    ],
                ],
            ],
            'custom converter' => [
                [
                    Configuration::NODE_CONVERTER => [
                        'custom' => [
                            'key' => 'foo'
                        ]
                    ],
                ],
                [
                    Configuration::NODE_CONVERTER => [
                        'custom' => [
                            'key' => 'foo'
                        ]
                    ],
                ],
            ],
        ];
    }
}
