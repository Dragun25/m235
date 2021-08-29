<?php

namespace Donin\OrderAttrs\Model;

use Donin\OrderAttrs\Api\Data\OrderAttributeInterface as BaseModelInterface;
use Donin\OrderAttrs\Api\OrderRepositoryInterface;
use Donin\OrderAttrs\Model\OrderAttributeFactory as BaseFactory;
use Donin\OrderAttrs\Model\ResourceModel\OrderAttr as BaseResource;
use \Magento\Framework\Exception\CouldNotDeleteException;
use \Magento\Framework\Exception\CouldNotSaveException;

class OrderAttributeRepository implements OrderRepositoryInterface
{
    /**
     * @var BaseResource
     */
    private $resource;

    /**
     * @var BaseFactory
     */
    private $factory;

    /**
     * @var array
     */
    protected $cache;

    /**
     * OrderRepository constructor.
     * @param BaseResource $resource
     * @param BaseFactory $factory
     */
    public function __construct(
        BaseResource $resource,
        BaseFactory $factory
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
    }

    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        $cacheNamespace = 'by_id';
        $key = $id;
        $order = $this->getFromCache($cacheNamespace, $key);
        if ($order) {
            return $order;
        }

        $object = $this->factory->create();
        $this->resource->load($object, $id);
        $this->cacheObject($cacheNamespace, $key, $object);

        return $object;
    }

    /**
     * {@inheritDoc}
     */
    public function save(BaseModelInterface $object)
    {
        try {
            $this->resource->save($object);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $object;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(BaseModelInterface $object)
    {
        try {
            $this->resource->delete($object);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @param array $data
     * @return null|string
     */
    protected function getCacheKey($data)
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Invalid data specified to get cache key');
        }

        $dataStr = '';
        array_walk_recursive($data, function ($val) use (&$dataStr) {
            $dataStr .= $val;
        });

        return sha1($dataStr);
    }

    /**
     * @param string $namespace
     * @param string $key
     * @param BaseModelInterface $object
     * @return BaseModelInterface
     */
    protected function cacheObject($namespace, $key, $object)
    {
        if ($namespace && $key) {
            $this->cache[$namespace][$key] = $object;
        }

        return $object;
    }

    /**
     * @param string $namespace
     * @param string $key
     * @return BaseModelInterface|null
     */
    protected function getFromCache($namespace, $key)
    {
        return $this->cache[$namespace][$key] ?? null;
    }
}
