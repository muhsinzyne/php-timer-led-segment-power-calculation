<?php

use app\models\SegmentLed;

class SegmentLedTest extends PHPUnit_Framework_TestCase {
	public $segment;
	
	public function setUp() 
	{
		$this->segment = new SegmentLed();
	}

	public function test_segment_number_list_exists() 
	{
		$number_list_keys = [0,1,2,3,4,5,6,7,8,9];
		foreach ($number_list_keys as $value) {
			$this->assertArrayHasKey($value, $this->segment->number_list);
		}
	}
	public function test_led_power_usage_amount() 
	{
		// assuming the value as 16
		$this->assertEquals($this->segment->calculate_led_power('01:01'), 16);
	}

	public function test_script_response() 
	{
		$response = (array) $this->segment->calculatePowerUsage('max');
		$this->assertArrayHasKey('power_usage', $response);
		$this->assertArrayHasKey('time', $response);
	}

	public function test_script_respose_for_min_value() 
	{
		$response = $this->segment->calculatePowerUsage('min');
		$this->assertEquals($response->power_usage, 8);
		$this->assertEquals($response->time, '11:11');
	}

	
}