<?php

include_once './cores/api/config.php';
include_once './models/Disburse.php';
include_once './routes/Request.php';
include_once './routes/Router.php';

$router = new Router(new Request);

$router->get('/', function($req) {
	$data = array(
		'status' => '200',
		'message' => 'The request has succeeded.'
	);
	return json_encode($data);
});

$router->post('/', function($req) {
	$body = $req->getBody();
	$encoded_auth = base64_encode(CONFIG_SECRET_KEY . ':');
	$disburse = new Disburse();
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => CONFIG_BASE_URL . '/disburse',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => 'bank_code=' . $body['bank_code'] . '&account_number=' . $body['account_number'] . '&amount=' . $body['amount'] . '&remark=' . $body['remark'],
		CURLOPT_HTTPHEADER => array(
			'content-type: application/x-www-form-urlencoded',
			'Authorization: Basic ' . $encoded_auth
		)
	));
	$res = curl_exec($curl);
	$data = json_decode($res, true);
	curl_close($curl);
	if ($disburse->sqlInsert($data)) {
		return json_encode($data);
	}
	return json_encode(array(
		'status' => '500',
		'message' => "The server has encountered a situation it doesn't know how to handle."
	));
});

$id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

$router->get('/?id=' . $id, function($req) {
	$params = $req->getParams();
	$encoded_auth = base64_encode(CONFIG_SECRET_KEY . ':');
	$disburse = new Disburse();
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => CONFIG_BASE_URL . '/disburse/' . $params['id'],
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_POSTFIELDS => '',
		CURLOPT_HTTPHEADER => array(
			'content-type: application/x-www-form-urlencoded',
			'Authorization: Basic ' . $encoded_auth
		)
	));
	$res = curl_exec($curl);
	$data = json_decode($res, true);
	curl_close($curl);
	if ($disburse->sqlUpdate($data)) {
		return json_encode($data);
	}
	return json_encode(array(
		'status' => '500',
		'message' => "The server has encountered a situation it doesn't know how to handle."
	));
});

?>
