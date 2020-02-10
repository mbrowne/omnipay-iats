<?php
namespace Omnipay\iATS\Message;

use Omnipay\Common\Message\AbstractRequest;
use iATS;

/**
 * iATS Authorize Request
 */
class PurchaseRequest extends AbstractRequest
{
    //Test user ID and password from http://home.iatspayments.com/developers/test-credentials,
    //used when testMode is enabled.
    public $testUser = 'TEST88';
    public $testPassword = 'TEST88';

    public function setAgentCode($value)
    {
        return $this->setParameter('agentCode', $value);
    }

    public function getAgentCode()
    {
        return $this->getParameter('agentCode');
    }
    
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function getData()
    {
        $this->validate('amount', 'card');
        $card = $this->getCard();
        $card->validate();
        
        // Create and populate the request object.
        $data = array(
          'recurring' => false,
          'mop' => $this->iatsCreditCardMop($card->getBrand()), //method of payment (Visa, Mastercard, etc.)
          'customerIPAddress' => $_SERVER['REMOTE_ADDR'],
          'firstName' => $card->getFirstName(),
          'lastName' => $card->getLastName(),
          'companyName' => $card->getCompany(),
          'address' => $card->getBillingAddress1(). "\n". $card->getBillingAddress2(),
          'city' => $card->getBillingCity(),
          'state' => $card->getBillingState(),
          'zipCode' => $card->getBillingPostcode(),
          'country' => $card->getBillingCountry(),
          'phone' => $card->getPhone(),
          'email' => $card->getEmail(),
          'total' => $this->getAmount(),
          'creditCardNum' => $card->getNumber(),
          'creditCardExpiry' => $card->getExpiryDate('m').'/'.$card->getExpiryDate('y'),
          'cvv2' => $card->getCvv(),
          'currency' => $this->getCurrency());
        return $data;
    }
    
    /**
     * Converts an Omnipay credit card type to an iATS-compatible credit card type ("method of payment" or MOP).
     */

    private function iatsCreditCardMop($type)
    {
        $mop = array(
      'visa' => 'VISA',
      'mastercard' => 'MC',
      'amex' => 'AMX',
      'discover' => 'DSC',
    );
        return $mop[$type];
    }

    public function sendData($data)
    {
        if ($this->getTestMode()) {
            //Use test credentials from http://home.iatspayments.com/developers/test-credentials
            $processLink = new iATS\ProcessLink($this->testUser, $this->testPassword);
        } else {
            $processLink = new iATS\ProcessLink($this->getAgentCode(), $this->getPassword());
        }

        $result = $processLink->processCreditCard($data);
        return $this->response = new PurchaseResponse($this, $result);
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }
}
