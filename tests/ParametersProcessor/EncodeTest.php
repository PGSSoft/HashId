<?php


namespace Pgs\HashIdBundle\Tests\ParametersProcessor;

use Hashids\HashidsInterface;
use Pgs\HashIdBundle\ParametersProcessor\Encode;
use PHPUnit\Framework\TestCase;

class EncodeTest extends TestCase
{

    /**
     * @dataProvider encodeParametersDataProvider
     */
    public function testEncode(array $parametersToEncode, array $routeParameters, array $expected)
    {
        $encodeParametersProcessor = new Encode($this->getHashidMock(), $parametersToEncode);
        $processedParameters = $encodeParametersProcessor->process($routeParameters);
        $this->assertSame($expected, $processedParameters);
        $this->assertEquals(count($parametersToEncode) > 0, $encodeParametersProcessor->needToProcess());
    }

    protected function getHashidMock()
    {
        $mock = $this->getMockBuilder(HashidsInterface::class)->setMethods(['encode'])->getMockForAbstractClass();
        $mock
            ->method('encode')
            ->withAnyParameters()
            ->willReturn('encoded');

        return $mock;
    }

    public function encodeParametersDataProvider()
    {
        return [
            [
                ['id'],
                ['id' => 10, 'slug' => 'slug'],
                ['id' => 'encoded', 'slug' => 'slug']
            ],
            [
                [],
                ['id' => 10, 'slug' => 'slug'],
                ['id' => 10, 'slug' => 'slug'],
            ],
            [
                ['foo'],
                ['id' => 10, 'slug' => 'slug'],
                ['id' => 10, 'slug' => 'slug'],
            ],
        ];
    }
}