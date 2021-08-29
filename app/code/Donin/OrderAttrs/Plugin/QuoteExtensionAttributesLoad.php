<?php

namespace Donin\OrderAttrs\Plugin;

use Donin\OrderAttrs\Api\Data\QuoteAttributeInterface;
use Donin\OrderAttrs\Api\QuoteRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\QuoteRepository\LoadHandler;

class QuoteExtensionAttributesLoad
{
    /**
     * @var QuoteRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * QuoteExtensionAttributes constructor.
     * @param QuoteRepositoryInterface $quoteRepository
     */
    public function __construct(QuoteRepositoryInterface $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @param LoadHandler $subject
     * @param CartInterface $resultItem
     * @return CartInterface
     * @throws \Exception
     */
    public function afterLoad(
        LoadHandler $subject,
        CartInterface $resultItem
    ) {
        /** @var \Magento\Quote\Api\Data\CartExtensionInterface|null $extensionAttributes */
        $extensionAttributes = $resultItem->getExtensionAttributes();
        if ($extensionAttributes && $extensionAttributes->getDonCustomText()) {
            return $resultItem;
        }

        /** @var QuoteAttributeInterface $model */
        $model = $this->quoteRepository->getById($resultItem->getEntityId());

        $extensionAttributes->setDonCustomText($model->getCustomText());
        $resultItem->setExtensionAttributes($extensionAttributes);

        return $resultItem;
    }
}
