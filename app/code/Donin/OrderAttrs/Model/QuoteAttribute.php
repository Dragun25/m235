<?php
declare(strict_types=1);

namespace Donin\OrderAttrs\Model;

use Magento\Framework\Model\AbstractModel;
use Donin\OrderAttrs\Model\ResourceModel\QuoteAttr as BaseResource;

class QuoteAttribute extends AbstractModel implements \Donin\OrderAttrs\Api\Data\QuoteAttributeInterface
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(BaseResource::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityId()
    {
        return $this->_getData(self::ENTITY_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @return string|null
     */
    public function getCustomText()
    {
        return $this->getData(self::ATTRIBUTE_CODE_1);
    }

    /**
     * {@inheritDoc}
     */
    public function setCustomText($value)
    {
        return $this->setData(self::ATTRIBUTE_CODE_1, $value);
    }
}
