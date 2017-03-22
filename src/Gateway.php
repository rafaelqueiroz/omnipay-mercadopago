<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace Omnipay\MercadoPago;

use Omnipay\Common\AbstractGateway;

/**
 * @author Rafael Queiroz <rafaelfqf@gmail.com>
 */
class Gateway extends AbstractGateway
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'MercadoPago';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'clientId' => '',
            'clientSecret' => '',
            'token' => '',
        ];
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->getParameter('clientId');
    }

    /**
     * @param $clientId
     * @return $this
     */
    public function setClientId($clientId)
    {
        return $this->setParameter('clientId', $clientId);
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->getParameter('clientSecret');
    }

    /**
     * @param $clientSecret
     * @return $this
     */
    public function setClientSecret($clientSecret)
    {
        return $this->setParameter('clientSecret', $clientSecret);
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        if (!$this->hasToken()) {
            $response = $this->createToken()->send();
            if ($response->isSuccessful()) {
                $data = $response->getData();
                $this->setToken($data['access_token']);
            }
        }

        return $this->getParameter('token');
    }

    /**
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        return $this->setParameter('token', $token);
    }

    /**
     * @return bool
     */
    public function hasToken()
    {
        return !empty ($this->getParameter('token'));
    }

    /**
     * @param string $class
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function createRequest($class, array $parameters)
    {
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        if (!$this->hasToken() && $class != \Omnipay\MercadoPago\Message\TokenRequest::class) {
            $this->getToken();
        }

        return parent::createRequest($class, $parameters);
    }

    /**
     * @link https://www.mercadopago.com.br/developers/en/api-docs/basics/authentication/
     * @return \Omnipay\MercadoPago\Message\TokenRequest
     */
    public function createToken()
    {
        return $this->createRequest(\Omnipay\MercadoPago\Message\TokenRequest::class, []);
    }

    /**
     * @link https://www.mercadopago.com.br/developers/en/api-docs/basic-checkout/checkout-preferences/
     * @return \Omnipay\MercadoPago\Message\CreatePreferenceRequest
     */
    public function createPreference(array $options = array())
    {
        return $this->createRequest(\Omnipay\MercadoPago\Message\CreatePreferenceRequest::class, $options);
    }

}