<?php
/**
 * Copyright © 2018 Synapseindia. All rights reserved.
 *Author : Synapseindia
 */
namespace Synapseindia\Abandonedcart\Model\Config;

class source implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {

        return [
            ['value' => 5, 'label' => __('5 Min')],
            ['value' => 10, 'label' => __('10 Min')],
            ['value' => 15, 'label' => __('15 Min')],
			['value' => 20, 'label' => __('20 Min')],
			['value' => 25, 'label' => __('25 Min')],
			['value' => 30, 'label' => __('30 Min')],
			['value' => 60, 'label' => __('1 Hour')],
			['value' => 120, 'label' => __('2 Hours')],
			['value' => 1440, 'label' => __('1 Day')],
				   
        ];
    }
}
?>