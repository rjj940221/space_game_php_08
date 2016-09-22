<?php

/**
 * Created by PhpStorm.
 * User: rojones
 * Date: 9/22/16
 * Time: 1:19 PM
 */
interface Weapon
{
    public function inRange() : array;
    public function addCharge($points);
    public function shoot();

}