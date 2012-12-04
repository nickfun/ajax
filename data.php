<?php

require 'vendor/autoload.php';

$app = new \Slim\Slim();

function intToString( $x ) {

	static $words = array(
		0	=> 'zero',
		1 	=> 'one',
		2	=> 'two',
		3 	=> 'three',
		4 	=> 'four',
		5 	=> 'five',
		6 	=> 'six',
		7 	=> 'seven',
		8 	=> 'eight',
		9	=> 'nine',
		10	=> 'ten',
		11	=> 'eleven',
		12	=> 'twelve',
		13	=> 'thirteen',
		14	=> 'fourteen',
		15	=> 'fifteen',
		16	=> 'sixteen',
		17	=> 'seventeen',
		18	=> 'eighteen',
		19	=> 'ninteen',
		20	=> 'twenty',
		30	=> 'thirty',
		40	=> 'fourty',
		50	=> 'fifty',
		60	=> 'sixty',
		70	=> 'seventy',
		80	=> 'eighty',
		90	=> 'nintey',
	);

	if( isset($words[$x]) ) {
		return $words[$x];
	}

	if( $x <= 20 ) {
		return $words[$x];
	}

	if( $x <= 99 ) {
		// get the ones
		$o = $x % 10;
		// get the tens
		$t = $x - $o;
		return $words[$t] . " " . $words[$o];
	}

	if( $x <= 999 ) {
		// get the tens
		$t = $x % 100;
		// get the hundreds
		$h = $x - $t;
		$h = $h / 100;
		return $words[$h] . " hundred " . intToString($t);
	}

	if( $x <= 999999 ) {
		$first = substr($x, 0, strlen($x)-3);
		$last  = substr($x, strlen($x)-3, 3);
		$first = intval($first);
		$last  = intval($last);

		return intToString($first) . " thousand and " . intToString($last);
	}

	return 'Number too big';
}

$app->get('/number/:num', function($num) use ($app) {
	$num = intval($num);
	$result = array(
		'answer'	=> ucwords(intToString($num)),
		'input'		=> $num,
	);
	$response = $app->response();

	$response['Content-type'] = 'application/json';
	$response['X-Powered-By'] = 'PHP 5 & Slim';

	echo json_encode($result);

});

$app->get('/source', function() {
	show_source('data.php');
});

$app->run();

