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

namespace Omnipay\MercadoPago\Message;

use Omnipay\Common\Message\ResponseInterface;

/**
 * @author Rafael Queiroz <rafaelfqf@gmail.com>
 */
class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{

    /**
     * @var string
     */
    protected $endpoint = "https://api.mercadopago.com";

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
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
     * @return \Omnipay\Common\Message\AbstractRequest
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
     * @return \Omnipay\Common\Message\AbstractRequest
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
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return ['access_token' => $this->getToken()];
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $url = $this->getEndpoint() . "?access_token=" . $this->getToken();
        $request = $this->httpClient->post($url, $headers, json_encode($data))->send();

        return $this->response = new Response($this, $request->json());
    }

}