<?php
declare(strict_types=1);

namespace AmericanExpressTest\HyperledgerFabricClient\Factory;

use AmericanExpress\HyperledgerFabricClient\Factory\ChaincodeInvocationSpecFactory;
use AmericanExpress\HyperledgerFabricClient\Factory\ChaincodeProposalPayloadFactory;
use Hyperledger\Fabric\Protos\Peer\ChaincodeProposalPayload;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AmericanExpress\HyperledgerFabricClient\Factory\ChaincodeProposalPayloadFactory
 */
class ChaincodeProposalPayloadFactoryTest extends TestCase
{
    public function testFromChaincodeInvocationSpec()
    {
        $chaincodeInvocationSpec = ChaincodeInvocationSpecFactory::fromArgs([
            'foo',
            'bar',
        ]);

        $result = ChaincodeProposalPayloadFactory::fromChaincodeInvocationSpec($chaincodeInvocationSpec);

        self::assertInstanceOf(ChaincodeProposalPayload::class, $result);
        $expected = <<<'TAG'



foo
bar
TAG;
        self::assertSame($expected, $result->getInput());
    }
}