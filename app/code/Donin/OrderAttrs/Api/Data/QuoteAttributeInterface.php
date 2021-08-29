<?php

namespace Donin\OrderAttrs\Api\Data;

interface QuoteAttributeInterface
{
    const ATTRIBUTE_CODE_1 = 'custom_text';

    const ENTITY_ID = 'entity_id';

    /**
     * @return integer|null
     */
    public function getEntityId();

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId);

    /**
     * Return custom text
     *
     * @return string|null
     */
    public function getCustomText();

    /**
     * Set custom text
     *
     * @param $value
     * @return mixed
     */
    public function setCustomText($value);
}
