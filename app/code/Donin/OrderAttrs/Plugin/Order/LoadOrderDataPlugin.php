<?php
declare(strict_types=1);

namespace Donin\OrderAttrs\Plugin\Order;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class LoadOrderDataPlugin
{
    /**
     * Order external fields
     */
    const DON_CUSTOM_TEXT = 'don_custom_text';

    /**
     * Order Extension Attributes Factory
     *
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;

    /**
     * OrderRepositoryPlugin constructor
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(OrderExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * Add “external_order_id” extension attribute to order data object to make it accessible in API data
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {
        $this->setAddtitionalData($order);
        return $order;
    }

    /**
     * Add “external_order_id” extension attribute to order data object to make it accessible in API data
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult)
    {
        $orders = $searchResult->getItems();
        foreach ($orders as $order) {
            $this->setAddtitionalData($order);
        }
        return $searchResult;
    }

    /**
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function setAddtitionalData(OrderInterface $order)
    {
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
        if ($attrCustomText = $order->getData(self::DON_CUSTOM_TEXT)) {
            $extensionAttributes->setExtensionAttribute(self::DON_CUSTOM_TEXT, $attrCustomText);
            $order->setExtensionAttributes($extensionAttributes);
        }
        return $order;
    }
}
