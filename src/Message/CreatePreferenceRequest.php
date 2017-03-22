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

/**
 * @author Rafael Queiroz <rafaelfqf@gmail.com>
 */
class CreatePreferenceRequest extends AbstractRequest
{

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint() . "/checkout/preferences";
    }

    /**
     * @return array
     */
    public function getData() {
        $data = [
            'items' => $this->getItems(),
        ];

        return $data;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->getParameter('items');
    }

    /**
     * @param array
     */
    public function setItems($items)
    {
        return $this->setParameter('items', $items);
    }

}