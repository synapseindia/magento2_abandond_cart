<?php
/**
 * Copyright © 2018 Synapseindia. All rights reserved.
 *Author : Synapseindia
 */
namespaceSynapseindiaAbandonedcartCron;
class Abandonedcart

	{
	protected $logger;
	public

	function __construct(PsrLogLoggerInterface $loggerInterface)
		{
		$this->logger = $loggerInterface;
		}

	public

	function execute()
		{
		$om = '';
		$om = MagentoFrameworkAppObjectManager::getInstance();
		$storeScope = MagentoStoreModelScopeInterface::SCOPE_STORES;
		$module_enabled = $om->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('abandonedcart/synapseindia/enable');
		/* Sender Email */
		$admin_email = $om->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('abandonedcart/synapseindia/admin_email');
		$cron_time = $om->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('abandonedcart/synapseindia/cron_time');
		$collection = $om->get('Magento\Reports\Model\ResourceModel\Quote\Collection');
		$collection->prepareForAbandonedReport(1);
		$rows = $collection->load();
		$rows = $rows->getData();
		$logo = $om->get('\Magento\Theme\Block\Html\Header\Logo');
		$logo_url = $logo->getLogoSrc();
		$html = "<!DOCTYPE html ><html ><head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/><title>Automatic Email</title>
<meta name='viewport' content='width=device-width, initial-scale=1.0'/></head>
<body style='margin:0; padding:10px 0 0 0;' bgcolor='#F8F8F8'>
<table align='center' border='1' cellpadding='0' cellspacing='0' width='95%%'><tr>
<td align='center'>
<table align='center' border='1' cellpadding='0' cellspacing='0' width='100%'
style='text-align:center;border-collapse: separate; border-spacing: 2px 5px; box-shadow: 1px 0 1px 1px #B8B8B8;'
bgcolor='#FFFFFF'><tr>
<td align='center' style='padding: 5px 5px 5px 5px;'>
<a href='http://url-goes-here' target='_blank'>
<img src='" . $logo_url . "' alt='Logo' style='width:186px;border:0;'/>
</a><hr><br /><h3>Abandoned Cart List</h3><hr><br />
</td></tr><tr>
<td bgcolor='#E8E8E8'>
<table border='1' cellpadding='0' cellspacing='0' width='100%%' style='padding: 20px 10px 10px 10px;'><tr>
<th>Customer Name </th>
<th>Customer Email </th>
<th>Products</th>
<th>Quantity</th>
<th>Ip</th>
<th>Cart Total</th>
<th>Updated on</th>
</tr>";
		foreach($rows as $rows)
			{
			$html.= "<tr> <td>" . $rows['customer_firstname'] . ' ' . $rows['customer_lastname'] . "</td><td>" . $rows['customer_email'] . "</td><td>" . $rows['items_count'] . "</td><td>" . $rows['items_qty'] . "</td><td>" . $rows['remote_ip'] . "</td><td>" . $rows['grand_total'] . "</td><td>" . $rows['updated_at'] . "</td></tr>";
			}

		$html.= "</table></td></tr><tr><td bgcolor='#66989c' style='padding: 15px 15px 15px 15px;'>
<table border='1' cellpadding='0' cellspacing='0' width='100%%'>
<tr><td align='center'>
</td></tr></table></td></tr></table></td></tr></table></body></html>";

		// $to = "eng.vinayverma@gmail.com";
		// $subject = "This is subject";

		if ($module_enabled == 1 && $admin_email != "")
			{
			$to = $admin_email;
			$message = $html;
			$subject = "Abandoned Cart List for Admin";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers.= 'From: <Synapseabandonedcart@Synapseabandonedcart.com>' . "\r\n";
			$headers.= 'Cc: Synapseabandonedcart@Synapseabandonedcart.com' . "\r\n";
			$retval = mail($to, $subject, $message, $headers);
			if ($retval == true)
				{

				// echo "Message sent successfully...";

				}
			  else
				{

				// echo "Message could not be sent...";

				}
			}

		// test command line
		// php bin/magento cron:run --group="synapseindia_abandonedcart_cron_group"
		// $this->logger->debug('Synapseindia\Abandonedcart\Cron\Abandonedcart');

		}
	}

