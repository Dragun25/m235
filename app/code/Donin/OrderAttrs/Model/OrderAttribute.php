<?php
declare(strict_types=1);

namespace Donin\OrderAttrs\Model;

use Donin\OrderAttrs\Model\ResourceModel\OrderAttr as BaseResource;
//use Magento\Framework\Model\AbstractModel;
//use Donin\OrderAttrs\Model\ResourceModel\QuoteAttr as BaseResource;

class OrderAttribute extends \Magento\Framework\Model\AbstractModel implements \Donin\OrderAttrs\Api\Data\OrderAttributeInterface
{
//    /**
//     * @return string|null
//     */
//    public function getCustomField()
//    {
//        return $this->getData(self::ATTRIBUTE_CODE_1);
//    }
//
//    /**
//     * @param $value
//     * @return string|null
//     */
//    public function setCustomField($value)
//    {
//        return $this->setData(self::ATTRIBUTE_CODE_1,$value);
//    }
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
