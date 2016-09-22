<?php
class Dice
{
	public function roll()
	{
		return rand(1, 6) . PHP_EOL;
	}

	public function t_roll($num_dice)
	{
		return (rand(1, 6) * $num_dice) . PHP_EOL;
	}

	public function a_roll($num_dice)
	{
		$roll_array = array();
		while (--$num_dice >= 0)
			$roll_array[] = rand(1, 6);
		return ($roll_array);
	}
}

?>
