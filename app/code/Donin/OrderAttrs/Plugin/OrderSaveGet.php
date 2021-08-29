<?php
declare(strict_types=1);

namespace Donin\OrderAttrs\Plugin;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Sales\Api\OrderRepositoryInterface as Subject;
use Magento\Sales\Api\Data\OrderInterface;
use Donin\OrderAttrs\Api\Data\OrderAttributeInterface;
use Donin\OrderAttrs\Model\OrderAttributeFactory;
use Donin\OrderAttrs\Api\OrderRepositoryInterface;


class OrderSaveGet
{
    /**
     * @var OrderAttributeFactory
     */
    private $orderAttributeFactory;
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    public function __construct(OrderAttributeFactory $orderAttributeFactory,
                                OrderRepositoryInterface $orderRepository)
    {
        $this->orderAttributeFactory = $orderAttributeFactory;
        $this->orderRepository = $orderRepository;
    }

    public function afterSave(
        Subject $subject,
        OrderInterface $order
    ) {
        $this->_saveAttribute($order);

        return $order;
    }

    public function _saveAttribute(OrderInterface $order)
    {
        $extensionAttributes = $order->getExtensionAttributes();
        if ($extensionAttributes !== null) {
            // нельзя использовать $extensionAttributes как массив. Это объект
//            $attributeValue = isset($extensionAttributes[OrderAttributeInterface::ATTRIBUTE_CODE_1]) ?
//                $extensionAttributes[OrderAttributeInterface::ATTRIBUTE_CODE_1]->getValue() : null;
            $attributeValue = $extensionAttributes->getDonCustomText();
            if ($attributeValue) {
                //в extension attribute нельзя сделать setExtensionAttribute
                //$extensionAttributes->setExtensionAttribute(OrderAttributeInterface::ATTRIBUTE_CODE_1, $attributeValue);
                //сделать сохранение значения DonCustomText по примеру сохранения DonCustomText для квоты

                $orderAttr = $this->orderAttributeFactory
                    ->create()
                    ->setEntityId($order->getId())
                    ->setCustomText($attributeValue);
                try {
                $this->orderRepository->save($orderAttr);
                }
                catch (\Exception $e) {
                    unset($e);
                }
            }
        }
    }
}
