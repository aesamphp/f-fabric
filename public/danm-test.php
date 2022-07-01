<?php

$caCertPath = '/etc/pki/tls/cacert.pem';
set_time_limit(60);
$output = array();
$curlSession = curl_init();


// Sagepay Test details
curl_setopt($curlSession, CURLOPT_URL, 'https://test.sagepay.com/gateway/service/vspdirect-register.vsp');
curl_setopt($curlSession, CURLOPT_HEADER, 0);
curl_setopt($curlSession, CURLOPT_POST, 1);
curl_setopt($curlSession, CURLOPT_POSTFIELDS, 'VPSProtocol=3.00&TxType=PAYMENT&Vendor=fashionformula&VendorTxCode=TPAY-2513790883-533485814&Amount=9.00&Currency=GBP&Description=Fashion Formula Shopping Basket.&BillingSurname=Latif&BillingFirstnames=Ammaar&BillingAddress1= E3 Creative, 21&BillingCity= Manchester &BillingPostCode=M15 4PS&BillingCountry=GB&DeliverySurname=Latif&DeliveryFirstnames=Ammaar&DeliveryAddress1= E3 Creative, 21&DeliveryCity= Manchester &DeliveryPostCode=M15 4PS&DeliveryCountry=GB&CustomerName=Ammaar Latif&CustomerEMail=ammaar@e3creative.co.uk&VendorEMail=&SendEMail=0&eMailMessage=&BillingAddress2= Little Peter Street&BillingPhone=&ApplyAVSCV2=0&Apply3DSecure=0&AllowGiftAid=0&BillingAgreement=0&DeliveryAddress2= Little Peter Street&DeliveryPhone=&BasketXML=<basket><item><description>Colour Atlas - Fabric</description><quantity>1</quantity><unitNetAmount>5.00</unitNetAmount><unitTaxAmount>1.00</unitTaxAmount><unitGrossAmount>6.00</unitGrossAmount><totalGrossAmount>6.00</totalGrossAmount></item><deliveryNetAmount>2.50</deliveryNetAmount><deliveryTaxAmount>0.50</deliveryTaxAmount><deliveryGrossAmount>3.00</deliveryGrossAmount></basket>&SurchargeXML=<surcharges><surcharge><paymentType>MC</paymentType><percentage>0</percentage></surcharge><surcharge><paymentType>VISA</paymentType><fixed>0</fixed></surcharge></surcharges>&CardType=VISA&CardNumber=4929000005559&ExpiryDate=1020&CV2=123&CardHolder=Ammaar Latif&AccountType=E');
curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curlSession, CURLOPT_TIMEOUT, 30);
curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, 2);


if (!empty($caCertPath))
{
	curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($curlSession, CURLOPT_CAINFO, $caCertPath);
}
else
{
	curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, 0);
}


if($rawresponse = curl_exec($curlSession)) {

	print_r($rawresponse);

	if (curl_getinfo($curlSession, CURLINFO_HTTP_CODE) !== 200)
	{
	$output['Status'] = "FAIL";
	$output['StatusDetails'] = "Server Response: " . curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
	$output['Response'] = $rawresponse;
	}
	if (curl_error($curlSession))
	{
	$output['Status'] = "FAIL";
	$output['StatusDetail'] = curl_error($curlSession);
	$output['Response'] = $rawresponse;
	}
	print_r($output);
} else {
	echo '<pre>';
	echo "\nerrno\n";
	print_r(curl_errno($curlSession));
	echo "\ngetinfo\n";
	print_r(curl_getinfo($curlSession));
	echo "\nerror\n";
	print_r(curl_error($curlSession));
	echo '</pre>';
}
curl_close($curlSession);
?>
