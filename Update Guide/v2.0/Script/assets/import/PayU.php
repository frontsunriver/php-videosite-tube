<?php

date_default_timezone_set('UTC');
// "ORDER_PNAME[0]" => "Test Ürünü",
// "CC_NUMBER" => "4355084355084358",
//    "EXP_MONTH" => "12",
//    "EXP_YEAR" => "2022",
//    "CC_CVV" => "000",
//    "CC_OWNER" => "000",
$MERCHANT = $pt->config->payu_merchant_id;
if($pt->config->payu_mode == '1'){
	$MERCHANT = "OPU_TEST";
}
$arParams = array(

   "MERCHANT" => $MERCHANT,
   "LANGUAGE" => "TR",
   "ORDER_REF" =>  rand(1, 10000000),
   "ORDER_DATE" => date('Y-m-d H:i:s'),
   "PAY_METHOD" => "CCVISAMC",
   "BACK_REF" => "http://www.backref.com.tr",
   "PRICES_CURRENCY" => "TRY",

   "ORDER_PCODE[0]" => rand(1, 10000000),
   "ORDER_PRICE[0]" => "5",
   "ORDER_VAT[0]"=>"18",
   "ORDER_PRICE_TYPE[0]"=>"NET",
   "ORDER_QTY[0]" => "1",

   

   "BILL_FNAME" => $pt->config->payu_buyer_name,
   "BILL_LNAME" => $pt->config->payu_buyer_surname,
   "BILL_EMAIL" => $pt->config->payu_buyer_email,
   "BILL_PHONE" => $pt->config->payu_buyer_gsm_number,
   "BILL_COUNTRYCODE" => "TR",
);

