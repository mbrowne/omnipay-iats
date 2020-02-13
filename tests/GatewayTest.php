<?php

namespace Omnipay\iATS;

use Omnipay\iATS\Message\PurchaseRequest;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = Omnipay::create('iATS');
        $this->gateway->initialize(['testMode'  => true]);   
    }

    public function testPurchase()
    {
        $options = array(
            'amount' => '10.00',
            'card' => $this->getValidCard(),
        );
        $request = $this->gateway->purchase($options);

        $this->assertInstanceOf('\Omnipay\iATS\Message\PurchaseRequest', $request);
        $this->assertArrayHasKey('total', $request->getData());
    }
}
