<?php
namespace Omnipay\iATS\Message;

use Omnipay\Common\Message\AbstractResponse,
	Omnipay\Common\Message\RequestInterface;

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
	
	function isSuccessful() {
		return (strpos(trim($this->data['AUTHORIZATIONRESULT']), 'OK') === 0);
	}
	
	function getMessage() {
		if (is_string($this->data)) {
			return $this->data;
		}
		return false;
	}
	
	function getTransactionId() {
		return $this->data['TRANSACTIONID'];
	}
	
	function getCustomerCode() {
		return $this->data['CUSTOMERCODE'];
	}
}