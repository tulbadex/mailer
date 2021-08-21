<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$address = explode(',', $_POST['to']);

	foreach ($address as $key) {
		echo $key;
		sleep(3);
	}
}

