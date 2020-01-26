<?php

namespace Pgs\HashIdBundle\Tests\DependencyInjection;

use Pgs\HashIdBundle\DependencyInjection\Configuration;
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
     * @dataProvider dataTestConfiguration*
     */
    public function testConfiguration(array $inputConfig, array $expectedConfig)
    {
        $configuration = new Configuration();

        $node = $configuration->getConfigTreeBuilder()
            ->buildTree();
        $normalizedConfig = $node->normalize($inputConfig);
        $finalizedConfig = $node->finalize($normalizedConfig);

        $this->assertSame($expectedConfig, $finalizedConfig);
    }

    public function dataTestConfiguration()
    {
        return [
            'default' => [
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [

                        ]
                    ]
                ],
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [
                            Configuration::NODE_CONVERTER_HASHIDS_SALT => null,
                            Configuration::NODE_CONVERTER_HASHIDS_MIN_HASH_LENGTH => 10,
                            Configuration::NODE_CONVERTER_HASHIDS_ALPHABET => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
                        ]
                    ]
                ],
            ],
            'set salt' => [
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [
                            Configuration::NODE_CONVERTER_HASHIDS_SALT => 'test_salt',
                        ]
                    ]
                ],
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [
                            Configuration::NODE_CONVERTER_HASHIDS_SALT => 'test_salt',
                            Configuration::NODE_CONVERTER_HASHIDS_MIN_HASH_LENGTH => 10,
                            Configuration::NODE_CONVERTER_HASHIDS_ALPHABET => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
                        ]
                    ]
                ],
            ],
            'set all' => [
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [
                            Configuration::NODE_CONVERTER_HASHIDS_SALT => 'test_salt',
                            Configuration::NODE_CONVERTER_HASHIDS_MIN_HASH_LENGTH => 10,
                            Configuration::NODE_CONVERTER_HASHIDS_ALPHABET => 'abcABC',
                        ]
                    ]
                ],
                [
                    Configuration::NODE_CONVERTER => [
                        Configuration::NODE_CONVERTER_HASHIDS => [
                            Configuration::NODE_CONVERTER_HASHIDS_SALT => 'test_salt',
                            Configuration::NODE_CONVERTER_HASHIDS_MIN_HASH_LENGTH => 10,
                            Configuration::NODE_CONVERTER_HASHIDS_ALPHABET => 'abcABC',
                        ]
                    ]
                ],
            ],
        ];
    }
}
