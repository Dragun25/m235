<?php

namespace Donin\OrderAttrs\Plugin\Checkout\Model;

class ShippingInformationManagement
{
    /**
     * @var \Magento\Quote\Model\QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var \Donin\OrderAttrs\Model\QuoteAttributeFactory
     */
    protected $doninExtAttrQuoteFactory;

    /**
     * ShippingInformationManagement constructor.
     * @param \Magento\Quote\Model\QuoteRepository $quoteRepository
     //* @param \Acidgreen\ApiShipping\Model\QuoteFactory $apishippingQuoteFactory
     */
    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Donin\OrderAttrs\Model\QuoteAttributeFactory $doninExtAttrQuoteFactory
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->doninExtAttrQuoteFactory = $doninExtAttrQuoteFactory;
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
                                                              $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        /** @var \Magento\Checkout\Api\Data\ShippingInformationExtension $extensionAttributes */
        if (!$extensionAttributes = $addressInformation->getExtensionAttributes()) {
            return;
        }
        try {
            $quote = $this->quoteRepository->getActive($cartId);
            //save CustomText into Quote
            $quote->getExtensionAttributes()->setDonCustomText($extensionAttributes->getDonCustomText());
        } catch (\Exception $e) {
            unset($e);
        }
    }
}