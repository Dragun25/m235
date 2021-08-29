<?php

namespace Donin\OrderAttrs\Model\ResourceModel;

class QuoteAttr extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const TABLE_NAME = 'don_custom_text_quote';

    public function _construct()
    {
        $this->_init(self::TABLE_NAME, 'entity_id');
        $this->_isPkAutoIncrement = false;
    }
}
