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
        if (isSuccessful()) {
            return null;
        }

        return $this->data;
    }
    
    public function getTransactionId()
    {
        if (!isSuccessful() || !$this->data['TRANSACTIONID']) {
            return null;
        }

        return $this->data['TRANSACTIONID'];
    }
    
    public function getCustomerCode()
    {
        if (!isSuccessful() || !$this->data['CUSTOMERCODE']) {
            return null;
        }

        return $this->data['CUSTOMERCODE'];
    }
}
