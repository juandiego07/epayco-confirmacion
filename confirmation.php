<?php

include('database.php');

$request = json_encode($_REQUEST);
$method = $_SERVER['REQUEST_METHOD'];

$p_cust_id_cliente = '93006';
$p_key = 'afe519dcb445a2b6f70559538e4af578360b5cf5';


$x_cust_id_cliente = $_REQUEST['x_cust_id_cliente'];
$x_ref_payco = $_REQUEST['x_ref_payco'];
$x_amount = $_REQUEST['x_amount'];
$x_currency_code = $_REQUEST['x_currency_code'];
$x_transaction_id = $_REQUEST['x_transaction_id'];
$x_transaction_state = $_REQUEST['x_transaction_state'];
$x_test_request = $_REQUEST['x_test_request'];

$signature = hash('sha256', $p_cust_id_cliente . '^' . $p_key . '^' . $x_ref_payco . '^' . $x_transaction_id . '^' . $x_amount . '^' . $x_currency_code);

if ($_REQUEST['x_signature'] == $signature) {
    $validate = 'Signature validate.';
} else {
    $validate = 'Signature no validate.';
};

$query = "INSERT INTO logs(method, x_cust_id_cliente, x_ref_payco, x_transaction_state, x_test_request, log) VALUES ('$method', '$x_cust_id_cliente', '$x_ref_payco', '$x_transaction_state','$x_test_request','$request')";

$db = new database();

$result = $db->saveData($query);

if ($result == 1) {
    http_response_code(200);
    $response = array(
        'success' => true,
        'data' => array(
            'message' => 'Register inserted correctly...!',
            'method' => $method,
            'signature' => $validate,
        )
    );
} else {
    http_response_code(500);
    $response = array(
        'success' => false,
        'data' => array(
            'message' => 'Error to insert register...!',
            'method' => $method,
            'signature' => $validate,
        )
    );
};

echo json_encode($response);
