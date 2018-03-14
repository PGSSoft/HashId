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
     * @dataProvider dataTestConfiguration
     *
     * @param array $inputConfig
     * @param array $expectedConfig
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
            [
                [],
                [
                    Configuration::NODE_SALT => null,
                    Configuration::NODE_MIN_HASH_LENGTH => 10,
                    Configuration::NODE_ALPHABET => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
                ],
            ],
            [
                [
                    Configuration::NODE_SALT => 'test_salt',
                ],
                [
                    Configuration::NODE_SALT => 'test_salt',
                    Configuration::NODE_MIN_HASH_LENGTH => 10,
                    Configuration::NODE_ALPHABET => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
                ],
            ],
            [
                [
                    Configuration::NODE_SALT => 'test_salt',
                    Configuration::NODE_MIN_HASH_LENGTH => 10,
                    Configuration::NODE_ALPHABET => 'abcABC',
                ],
                [
                    Configuration::NODE_SALT => 'test_salt',
                    Configuration::NODE_MIN_HASH_LENGTH => 10,
                    Configuration::NODE_ALPHABET => 'abcABC',
                ],
            ],
        ];
    }
}
