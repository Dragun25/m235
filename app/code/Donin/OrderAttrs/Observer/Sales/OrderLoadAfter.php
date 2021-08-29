<?php
declare(strict_types=1);

namespace Donin\OrderAttrs\Observer\Sales;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;

class OrderLoadAfter implements ObserverInterface
{
    /**
     * @var OrderInterface
     */
    private $extension;
    /**
     * @var OrderExtensionFactory
     */
    private $orderExtensionFactory;

    public function __construct(
        OrderInterface $extension,
        OrderExtensionFactory $orderExtensionFactory
    )
    {
        $this->extension = $extension;
        $this->orderExtensionFactory = $orderExtensionFactory;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $extensionAttributes = $order->getExtensionAttributes();
        if ($extensionAttributes === null) {
            $extensionAttributes = $this->orderExtensionFactory->create();
        }
//        $attr = '';
//        $extensionAttributes->setExtensionAttribute('don_custom_text',$attr);
        $order->setExtensionAttributes($extensionAttributes);
    }

}
