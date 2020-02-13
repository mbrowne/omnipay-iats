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
        if (is_string($this->data) || !$this->data['AUTHORIZATIONRESULT']) {
            return false;
        }

        return (strpos(trim($this->data['AUTHORIZATIONRESULT']), 'OK') === 0);
    }
    
    public function getMessage()
    {
        if (is_string($this->data)) {
            return $this->data;
        }

        return null;
    }
    
    public function getTransactionId()
    {
        if (is_string($this->data) || !$this->data['TRANSACTIONID']) {
            return null;
        }

        return $this->data['TRANSACTIONID'];
    }
    
    public function getCustomerCode()
    {
        if (is_string($this->data) || !$this->data['CUSTOMERCODE']) {
            return null;
        }

        return $this->data['CUSTOMERCODE'];
    }
}
