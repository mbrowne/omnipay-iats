<?php

namespace Omnipay\iATS;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase()
    {
        $options = array(
            'amount' => '10.00',
            'card' => $this->getValidCard(),
        );
        $request = $this->gateway->purchase($options);

        $this->assertInstanceOf('\Omnipay\iATS\Message\PurchaseRequest', $request);
        print_r($request->getData());
        $this->assertArrayHasKey('amount', $request->getData());
    }
}
