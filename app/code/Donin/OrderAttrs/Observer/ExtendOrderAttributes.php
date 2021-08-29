<?php
declare(strict_types=1);

namespace Donin\OrderAttrs\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Quote\Api\Data\CartInterface;

class ExtendOrderAttributes implements ObserverInterface
{
    /**
     * List of attributes that should be added to an Order from Quote.
     *
     * @var array
     */
    private $attributes = [
        'don_custom_text'
    ];

    /**
     * @param Observer $observer
     * @return void|null
     */
    public function execute(Observer $observer)
    {
        // event sales_model_service_quote_submit_before
        // Add the attribute 'DonCustomText' from Quote to Order

        /** @var CartInterface $quote */
        $quote = $observer->getEvent()->getQuote();
        if (!$quote || !$quote->getId()) {
            return null;
        }
        /** @var \Magento\Quote\Api\Data\CartExtension|null $quoteExtensionAttributes */
        $quoteExtensionAttributes = $quote->getExtensionAttributes();
        if (!$quoteExtensionAttributes || !$quoteExtensionAttributes->getDonCustomText()) {
            return null;
        }
        /** @var \Magento\Sales\Api\Data\OrderInterface $order */
        $order = $observer->getEvent()->getOrder();

        if ($orderExtensionAttributes = $order->getExtensionAttributes()) {
            $orderExtensionAttributes->setDonCustomText($quoteExtensionAttributes->getDonCustomText());
        }
        // extension attributes нельзя получить через  getData()
//        foreach ($this->attributes as $attribute) {
//            if ($quote->hasData($attribute)) {
//                $order->setData($attribute, $quote->getData($attribute));
//            }
//        }
    }
}
