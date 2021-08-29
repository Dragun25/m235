<?php

namespace Donin\OrderAttrs\Api;

use Donin\OrderAttrs\Api\Data\OrderAttributeInterface as BaseModelInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;

interface OrderRepositoryInterface
{
    /**
     * @param $id
     * @return BaseModelInterface
     * @throws \Exception
     */
    public function getById($id);

    /**
     * @param BaseModelInterface $object
     * @return BaseModelInterface
     * @throws CouldNotSaveException
     */
    public function save(BaseModelInterface $object);

    /**
     * @param BaseModelInterface $object
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(BaseModelInterface $object);
}
