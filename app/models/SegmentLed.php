<?php

namespace app\models;

class SegmentLed {

	public $number_list = [];

	function __construct() {
		$this->number_list = ["0" => 6, "1" => 2, "2" => 5, "3" => 5, "4" => 4, "5" => 5, "6" => 6, "7" => 4, "8" => 7, "9" => 6];
	}

	public function calculatePowerUsage($type = 'max') 
	{
		$usage_status = (object) array('power_usage' => 0, 'time' => '');
		$times = $this->generate_hours_range(0, 86400, 60, 'H:i');
		foreach ($times as $key => $time) {
			$current_power_usage = $this->calculate_led_power($time);
			if ($type == 'max') {
				if ($current_power_usage > $usage_status->power_usage) {
					$usage_status->power_usage = $current_power_usage;
					$usage_status->time = $time;
				}
			} else {
				if ($usage_status->power_usage > $current_power_usage || $usage_status->power_usage == 0) {
					$usage_status->power_usage = $current_power_usage;
					$usage_status->time = $time;
				}
			}
		}
		return $usage_status;
	}

	public function calculate_led_power($time) 
	{
		$time = str_replace(":", "", $time);
		$number_array = str_split($time);
		$power_usage = 0;
		foreach ($number_array as $key => $number) {
			if (array_key_exists($number, $this->number_list)) {
				$power_usage = $power_usage + $this->number_list[$number];
			}
		}
		return $power_usage;
	}

	protected function generate_hours_range($start = 0, $end = 86400, $step = 3600, $format = 'H:i') 
	{
		$times = array();
		foreach (range($start, $end, $step) as $timestamp) {
			$hour_mins = gmdate('H:i', $timestamp);
			if (!empty($format)) {
				$times[$hour_mins] = gmdate($format, $timestamp);
			} else {
				$times[$hour_mins] = $hour_mins;
			}

		}
		return $times;
	}
}
