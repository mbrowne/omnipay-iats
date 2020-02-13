<?php

namespace Omnipay\iATS\Message;

use Omnipay\Omnipay;
use Omnipay\iATS\Gateway;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->gateway = Omnipay::create('iATS');
        $this->gateway->initialize(['testMode'  => true]);
    }

    public function testCreditCardSuccess()
    {
        // card numbers ending in even number should be successful
        $options = array(
            'amount' => '10.00',
            'currency' => 'CAD',
            'card' => $this->getValidCard(),
        );
        $options['card']['number'] = '4111111111111111';
        $options['card']['cvv'] = '111';

        $response = $this->gateway->purchase($options)->send();

        $this->assertInstanceOf('\Omnipay\iATS\Message\PurchaseResponse', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionId());
        $this->assertEmpty($response->getMessage());
    }

    public function testCreditCardFailure()
    {
        // card numbers ending in odd number should be declined
        $options = array(
            'amount' => '10.00',
            'card' => $this->getValidCard(),
        );
        $options['card']['number'] = '4111111111111111';
        $options['card']['cvv'] = '112';

        $response = $this->gateway->purchase($options)->send();

        $this->assertInstanceOf('\Omnipay\iATS\Message\PurchaseResponse', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEmpty($response->getTransactionId());
        $this->assertSame("Service cannot be used with this Method of Payment or Currency.", $response->getMessage());
    }
}
