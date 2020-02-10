<?php
namespace Omnipay\iATS;

use Omnipay\Common\AbstractGateway;

/**
 * iATS Gateway
 *
 * Dependencies:
 * iatspayments/php library
 * https://packagist.org/packages/iatspayments/php
 *
 * @author Matt Browne
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'iATS';
    }

    public function getDefaultParameters()
    {
        return array(
            'agentCode' => '',
            'password' => '',
            'testMode' => false,
        );
    }
    
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
    
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\iATS\Message\PurchaseRequest', $parameters);
    }
}
