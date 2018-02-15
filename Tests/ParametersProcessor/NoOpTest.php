<?php


namespace Pgs\HashIdBundle\Tests\ParametersProcessor;


use Hashids\HashidsInterface;
use Pgs\HashIdBundle\ParametersProcessor\NoOp;
use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorInterface;
use PHPUnit\Framework\TestCase;

class NoOpTest extends TestCase
{
    /**
     * @var ParametersProcessorInterface
     */
    protected $parametersProcessor;

    protected function setUp()
    {
        $this->parametersProcessor = new NoOp($this->getHashidMock(), []);
    }

    /**
     * @dataProvider prepareParameters
     */
    public function testAreParametersNotChanged(array $parametersToProcess, array $parameters, array $expected)
    {
        $processedParameters = $this->parametersProcessor->setParametersToProcess($parametersToProcess)->process($parameters);

        $this->assertEquals($expected, $processedParameters);
    }

    public function testSetParametersToProcess()
    {
        $this->parametersProcessor->setParametersToProcess(['foo', 'bar']);
        $this->assertSame([], $this->parametersProcessor->getParametersToProcess());
    }

    public function testSetParametersToProcessReturnType()
    {
        $result = $this->parametersProcessor->setParametersToProcess(['foo', 'bar']);
        $this->assertEquals(true, $result instanceof ParametersProcessorInterface);
    }

    public function testConstructor()
    {
        $parametersProcessor = new NoOp($this->getHashidMock(), ['foo', 'bar']);
        $this->assertSame([], $parametersProcessor->getParametersToProcess());
    }

    protected function getHashidMock()
    {
        return $this->getMockBuilder(HashidsInterface::class)->getMock();
    }

    public function prepareParameters()
    {
        return [
            [
                [],
                [],
                []
            ],
            [
                ['id'],
                [
                    'id' => 10,
                    'slug' => 'test'
                ],
                [
                    'id' => 10,
                    'slug' => 'test'
                ]
            ]
        ];
    }
}