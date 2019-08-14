<?php
require "vendor/autoload.php";

use app\models\SegmentLed;

$segment = new SegmentLed();
if(isset($_GET['type'])) {
	$type = $_GET['type'];
} else {
	$type = 'max';
}

if(in_array($type, ['min', 'max'])) {
	$result = (array) $segment->calculatePowerUsage($type); // min max
	$result = array_merge(array('status'=> 200, 'message'=> ''), array('data' => $result));
} else {
	$result = array('status' => 400, 'message' => 'Request input only support with min or max');
}

header('Content-Type: application/json');
echo json_encode($result);	