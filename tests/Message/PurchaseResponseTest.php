<?php

namespace Omnipay\iATS\Message;

use Omnipay\Tests\TestCase;

class ResponseTest extends TestCase
{
    public function testSuccess()
    {
        $response = new PurchaseResponse(
            $this->getMockRequest(),
            array('TRANSACTIONID' => 'abc123', 'CUSTOMERCODE' => '123', 'AUTHORIZATIONRESULT' => 'OK')
        );

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('abc123', $response->getTransactionId());
        $this->assertSame('123', $response->getCustomerCode());
        $this->assertEmpty($response->getMessage());
    }

    public function testFailure()
    {
        $mockErrorMessage = "Credit card is invalid.";

        $response = new PurchaseResponse(
            $this->getMockRequest(),
            $mockErrorMessage
        );

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEmpty($response->getTransactionId());
        $this->assertEmpty($response->getCustomerCode());
        $this->assertSame($mockErrorMessage, $response->getMessage());
    }
}
