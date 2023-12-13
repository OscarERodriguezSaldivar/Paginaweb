<?php 
// Include the configuration file 
require_once 'Paypal_Config.php'; 
 
// Include the database connection file 
include_once 'Paypal_DBConnect.php'; 

include_once 'Carrito.php'; 
 
// Include the PayPal API library 
require_once 'PaypalCheckout.class.php'; 
$paypal = new PaypalCheckout; 
 
$response = array('status' => 0, 'msg' => 'Transaction Failed!'); 
if(!empty($_POST['paypal_order_check']) && !empty($_POST['order_id'])){ 
    // Validate and get order details with PayPal API 
    try {  
        $order = $paypal->validate($_POST['order_id']); 
    } catch(Exception $e) {  
        $api_error = $e->getMessage();  
    } 
     
    if(!empty($order)){ 
        $order_id = $order['id']; 
        $intent = $order['intent']; 
        $order_status = $order['status']; 
        $order_time = date("Y-m-d H:i:s", strtotime($order['create_time'])); 
 
        if(!empty($order['purchase_units'][0])){ 
            $purchase_unit = $order['purchase_units'][0]; 
 
            $item_number = $purchase_unit['custom_id']; 
            $item_name = $purchase_unit['description']; 
             
            if(!empty($purchase_unit['amount'])){ 
                $currency_code = $purchase_unit['amount']['currency_code']; 
                $amount_value = $purchase_unit['amount']['value']; 
            } 
 
            if(!empty($purchase_unit['payments']['captures'][0])){ 
                $payment_capture = $purchase_unit['payments']['captures'][0]; 
                $transaction_id = $payment_capture['id']; 
                $payment_status = $payment_capture['status']; 
            } 
 
            if(!empty($purchase_unit['payee'])){ 
                $payee = $purchase_unit['payee']; 
                $payee_email_address = $payee['email_address']; 
                $merchant_id = $payee['merchant_id']; 
            } 
        } 
 
        $payment_source = ''; 
        if(!empty($order['payment_source'])){ 
            foreach($order['payment_source'] as $key=>$value){ 
                $payment_source = $key; 
            } 
        } 
 
        if(!empty($order['payer'])){ 
            $payer = $order['payer']; 
            $payer_id = $payer['payer_id']; 
            $payer_name = $payer['name']; 
            $payer_given_name = !empty($payer_name['given_name'])?$payer_name['given_name']:''; 
            $payer_surname = !empty($payer_name['surname'])?$payer_name['surname']:''; 
            $payer_full_name = trim($payer_given_name.' '.$payer_surname); 
            $payer_full_name = filter_var($payer_full_name, FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH); 
 
            $payer_email_address = $payer['email_address']; 
            $payer_address = $payer['address']; 
            $payer_country_code = !empty($payer_address['country_code'])?$payer_address['country_code']:''; 
        } 
 
        if(!empty($order_id) && $order_status == 'COMPLETED'){ 
            // Check if any transaction data is exists already with the same TXN ID 
            $sqlQ = "SELECT id FROM transactions WHERE transaction_id = ?"; 
            $stmt = $db->prepare($sqlQ);  
            $stmt->bind_param("s", $transaction_id); 
            $stmt->execute(); 
            $stmt->bind_result($row_id); 
            $stmt->fetch(); 
             
            $payment_id = 0; 
            if(!empty($row_id)){ 
                $payment_id = $row_id; 
            }else{ 
                // Insert transaction data into the database 
                $sqlQ = "INSERT INTO transactions (item_number,item_name,item_price,item_price_currency,payer_id,payer_name,payer_email,payer_country,merchant_id,merchant_email,order_id,transaction_id,paid_amount,paid_amount_currency,payment_source,payment_status,created,modified) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())"; 
                $stmt = $db->prepare($sqlQ); 
                $stmt->bind_param("ssdsssssssssdssss", $item_number, $item_name, $totalPrecio, $currency, $payer_id, $payer_full_name, $payer_email_address, $payer_country_code, $merchant_id, $payee_email_address, $order_id, $transaction_id, $amount_value, $currency_code, $payment_source, $payment_status, $order_time); 
                $insert = $stmt->execute(); 
                 
                if($insert){ 
                    $payment_id = $stmt->insert_id; 
                } 
            } 
 
            if(!empty($payment_id)){ 
                $ref_id_enc = base64_encode($transaction_id); 
                $response = array('status' => 1, 'msg' => 'Transaction completed!', 'ref_id' => $ref_id_enc); 
            } 
        } 
    }else{ 
        $response['msg'] = $api_error; 
    } 
} 
echo json_encode($response); 
?>
Payment Status (payment-status.php)
Based on the status return by the order.capture(), the buyer is redirected to this page.

Fetch transaction data from the database using PHP and MySQL.
Display transaction details on the web page.
<?php 
// Include the configuration file  
require_once 'Paypal_Config.php'; 
 
// Include the database connection file  
require_once 'Paypal_DBConnect.php'; 
 
$payment_ref_id = $statusMsg = ''; 
$status = 'error'; 
 
// Check whether the payment ID is not empty 
if(!empty($_GET['checkout_ref_id'])){ 
    $payment_txn_id  = base64_decode($_GET['checkout_ref_id']); 
     
    // Fetch transaction data from the database 
    $sqlQ = "SELECT id,payer_id,payer_name,payer_email,payer_country,order_id,transaction_id,paid_amount,paid_amount_currency,payment_source,payment_status,created FROM transactions WHERE transaction_id = ?"; 
    $stmt = $db->prepare($sqlQ);  
    $stmt->bind_param("s", $payment_txn_id); 
    $stmt->execute(); 
    $stmt->store_result(); 
 
    if($stmt->num_rows > 0){ 
        // Get transaction details 
        $stmt->bind_result($payment_ref_id, $payer_id, $payer_name, $payer_email, $payer_country, $order_id, $transaction_id, $paid_amount, $paid_amount_currency, $payment_source, $payment_status, $created); 
        $stmt->fetch(); 
         
        $status = 'success'; 
        $statusMsg = 'Your Payment has been Successful!'; 
    }else{ 
        $statusMsg = "Transaction has been failed!"; 
    } 
}else{ 
    header("Location: Paypal_index.php"); 
    exit; 
} 
?>

<?php if(!empty($payment_ref_id)){ ?>
    <h1 class="<?php echo $status; ?>"><?php echo $statusMsg; ?></h1>
    
    <h4>Payment Information</h4>
    <p><b>Reference Number:</b> <?php echo $payment_ref_id; ?></p>
    <p><b>Order ID:</b> <?php echo $order_id; ?></p>
    <p><b>Transaction ID:</b> <?php echo $transaction_id; ?></p>
    <p><b>Paid Amount:</b> <?php echo $paid_amount.' '.$paid_amount_currency; ?></p>
    <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>
    <p><b>Date:</b> <?php echo $created; ?></p>
    
    <h4>Payer Information</h4>
    <p><b>ID:</b> <?php echo $payer_id; ?></p>
    <p><b>Name:</b> <?php echo $payer_name; ?></p>
    <p><b>Email:</b> <?php echo $payer_email; ?></p>
    <p><b>Country:</b> <?php echo $payer_country; ?></p>
    
    <h4>Product Information</h4>
    <p><b>Name:</b> <?php echo $itemName; ?></p>
    <p><b>Price:</b> <?php echo $itemPrice.' '.$currency; ?></p>
<?php }else{ ?>
    <h1 class="error">Your Payment been failed!</h1>
    <p class="error"><?php echo $statusMsg; ?></p>
<?php }?>