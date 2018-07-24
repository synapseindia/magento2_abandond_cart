<?php
/**
 * Copyright © 2018 Synapseindia. All rights reserved.
 *Author : Synapseindia
 */
namespace Synapseindia\Abandonedcart\Controller\Adminhtml\Index;


class Index extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
	}
}

?>