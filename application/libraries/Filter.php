<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Filter
{
	public function sanitaze_input($input)
	{
		$remove[] = "'";
		$remove[] = '"';
		$remove[] = "%";
		$remove[] = "<";
		$remove[] = ">";
		return str_replace($remove, "", strip_tags(trim($input)));
	}

	public function only_number($string)
	{
		return preg_replace('/[^0-9]/', '', $string);
	}
}
