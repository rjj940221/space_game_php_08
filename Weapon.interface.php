<?php

/**
 * Created by PhpStorm.
 * User: rojones
 * Date: 9/22/16
 * Time: 1:19 PM
 */
interface Weapon
{
    public function inRange($board) : array; // returns a list of ships in range
    public function addCharge($points); // addes extra charge to weapon for that turn
    public function resetCharge(); // sets the charge stat to the defalt charge of the weapon
    public function shoot(); // only works if weapon has charge

}