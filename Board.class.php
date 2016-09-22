<?php

/**
 * Created by PhpStorm.
 * User: rojones
 * Date: 9/22/16
 * Time: 9:48 AM
 */
class board
{
    private $_board = array(array()); // 150 X 100
    private $_imperial;
    private $onslught;

    public function __construct()
    {
        $this->place_obj(75,50,3,6);
        $this->place_obj(45,80,3,6);
        $this->place_obj(100,20,3,2);
        $this->place_obj(75,50,4,6);
        $this->place_obj(75,10,3,1);
        $this->place_obj(75,60,3,6);
    }

    public function place_obj($locX, $locY, $x, $y)
    {
        for ($i = 0; $i < $x; $x++)
        {
            for ($j = 0; $j < $y; $j++)
                $this->_board[$i + $locX][$j + $locY] = "obj";
        }
    }

}