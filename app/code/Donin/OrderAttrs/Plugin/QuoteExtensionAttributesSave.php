<?php

namespace Donin\OrderAttrs\Plugin;

use Donin\OrderAttrs\Api\QuoteRepositoryInterface;
use Donin\OrderAttrs\Model\QuoteAttributeFactory;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\QuoteRepository\SaveHandler;

class QuoteExtensionAttributesSave
{
    /**
     * @var QuoteRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var QuoteAttributeFactory
     */
    protected $quoteAttributeFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * QuoteExtensionAttributes constructor.
     * @param QuoteRepositoryInterface $quoteRepository
     * @param QuoteAttributeFactory $quoteAttributeFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        QuoteRepositoryInterface $quoteRepository,
        QuoteAttributeFactory $quoteAttributeFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->quoteAttributeFactory = $quoteAttributeFactory;
        $this->logger = $logger;
    }

    /**
     * @param SaveHandler $subject
     * @param CartInterface $quote
     * @return CartInterface
     * @throws \Exception
     */
    public function beforeSave(
        SaveHandler $subject,
        CartInterface $quote
    ) {
        /** @var  \Magento\Quote\Api\Data\CartExtension|null $extensionAttributes */
        $extensionAttributes = $quote->getExtensionAttributes();
        if (!$extensionAttributes || !$extensionAttributes->getDonCustomText()) {
            return null;
        }

        try {
            /** @var \Donin\OrderAttrs\Api\Data\QuoteAttributeInterface|null $donCustomText */
            $donCustomText = $extensionAttributes->getDonCustomText();
            if ($donCustomText) {
                $quoteAttr = $this->quoteAttributeFactory
                    ->create()
                    ->setEntityId($quote->getId())
                    ->setCustomText($donCustomText);

                $this->quoteRepository->save($quoteAttr);
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return null;
    }
}
