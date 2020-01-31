<?php
//fetch.php

if(isset($_POST['action']))
{

	$output = '';

	if($_POST["action"] == 'country')
	{
		$result = DB::select("
		SELECT state FROM cities
		WHERE country = :country
		GROUP BY state
		");
		$output .= '<option value="">Select State</option>';
		foreach($result as $row)
		{
			$output .= '<option value="'.$row->state.'">'.$row->state.'</option>';
		}
	}
	if($_POST["action"] == 'state')
	{
		$result = DB::select("
		SELECT city FROM country_state_city
		WHERE state = :state
		");
		foreach($result as $row)
		{
			$output .= '<option value="'.$row->city.'">'.$row->city.'</option>';
		}


	}
	echo $output;
}

?>
