<?php
namespace Omnipay\iATS\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * iATS Authorize Response
 */
class PurchaseResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }
    
    public function isSuccessful()
    {
        return $this->data['AUTHORIZATIONRESULT'] == true;
    }
    
    public function getMessage()
    {
        if (is_string($this->data)) {
            return $this->data;
        }
        return false;
    }
    
    public function getTransactionId()
    {
        return $this->data['TRANSACTIONID'];
    }
    
    public function getCustomerCode()
    {
        return $this->data['CUSTOMERCODE'];
    }
}
