<?php 
 
// Product Details 
$itemNumber = "DP12345"; 
$itemName = "Demo Product"; 
$itemPrice = 75;  
$currency = "USD"; 
 
/* PayPal REST API configuration 
 * You can generate API credentials from the PayPal developer panel. 
 * See your keys here: https://developer.paypal.com/dashboard/ 
 */ 
define('PAYPAL_SANDBOX', TRUE); //TRUE=Sandbox | FALSE=Production 
define('PAYPAL_SANDBOX_CLIENT_ID', 'AefjyNHPl9Eb4rgOZMZTtGLuQ4dbVJOJ-ERAOG7kSo_cYwnXAwagAhaYQSD2B2yZlmk9ilrNmMvYim5Q'); 
define('PAYPAL_SANDBOX_CLIENT_SECRET', 'EO_6-BbhSlCh9GTjvKtXAUcPKllAk_dl249Beun0IuMol8jZLgWWJOO9TEjXkHX12u3TND-caUgKZ4Of'); 
define('PAYPAL_PROD_CLIENT_ID', 'Insert_Live_PayPal_Client_ID_Here'); 
define('PAYPAL_PROD_CLIENT_SECRET', 'Insert_Live_PayPal_Secret_Key_Here'); 
  
// Database configuration  
define('DB_HOST', '');  
define('DB_USERNAME', '');  
define('DB_PASSWORD', '');  
define('DB_NAME', ''); 
 
?>
