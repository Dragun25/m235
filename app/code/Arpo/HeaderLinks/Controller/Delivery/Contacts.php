<?php

namespace Arpo\HeaderLinks\Contoller\Delivery;


class Contacts extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;

    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
//        $resultPage = $this->_resultPageFactory->create();
//        $resultPage->getConfig()->getTitle()->prepend(__('Custom Front View'));
//
//        return $resultPage;
        return 1234;
    }
}
