--TEST--
http client event base
--SKIPIF--
<?php 
include "skipif.inc";
skip_online_test();
?>
--FILE--
<?php
echo "Test\n";

$client1 = new http\Client;
$client2 = new http\Client;

$client1->configure(["use_eventloop" => true]);
$client2->configure(["use_eventloop" => true]);

$client1->enqueue(new http\Client\Request("GET", "http://www.google.ca/"));
$client2->enqueue(new http\Client\Request("GET", "http://www.google.co.uk/"));

$client1->send();

if (($r = $client1->getResponse())) {
	var_dump($r->getTransferInfo("response_code"));
}
if (($r = $client2->getResponse())) {
	var_dump($r->getTransferInfo("response_code"));
}

?>
DONE
--EXPECT--
Test
int(200)
DONE
