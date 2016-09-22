<?php
require_once ('Board.class.php');
require_once ('Dice.class.php');
require_once ('Ship.class.php');
class Railgun implements Weapon
{
    private $_charge = 5;
    private $_charge_boost = 0;
    private $_r_short = 3;
    private $_r_med = 7;
    private $_r_long = 10;
    private $_ship;

    public  function has_charge()
    {
        if ($this->_charge_boost > 0)
            return (true);
        return (false);
    }

    public function __construct($ship)
    {
        $this->_ship = $ship;
        $this->_charge_boost = $this->_charge;
    }

    public function inRange(Board $board)
    {
        $x = $this->_ship->get_location()['x'];
        $y = $this->_ship->get_location()['y'];
        $inc_x = 0;
        $inc_y = 0;

        switch ($this->_ship->get_direction())
        {
            case 'up':
                $y -= $this->_ship->get_length() / 2;
                $inc_y = -1;
                break;
            case 'down':
                $y += $this->_ship->get_length() / 2;
                $inc_y = 1;
                break;
            case 'left':
                $x -= $this->_ship->get_length() / 2;
                $inc_x = -1;
                break;
            case 'right':
                $x += $this->_ship->get_length() / 2;
                $inc_x = 1;
                break;
        }
        for ($i = 0 ; $i < $this->_r_long; $i++)
        {
            $x += $inc_x;
            $y += $inc_y;
            if (($at = $board->get_index($x, $y)) !== false){
                   if ($at instanceof Ship) {
                       if ($at->get_fleet() != $this->_ship->get_fleet()) {
                           $range = 0;
                           if ($i < $this->_r_short)
                               $range = "short";
                           elseif ($i < $this->_r_med)
                               $range = 'med';
                           else
                               $range = 'long';
                           return (array('target' => $at, 'range' => $range));
                       }
                       else
                           break;
                   }
            }
            else
                break;
        }
        // returns a list of ships in range given an instance of board
        return (null);
    }

    public function addCharge($points)
    {
        $this->_charge_boost += $points;
        // addes extra charge to weapon for that turn
    }

    public function resetCharge()
    {
        $this->_charge_boost = $this->_charge;
        // sets the charge stat to the defalt charge of the weapon
    }

    public function shoot(Ship $target, $range)
    {
        if ($this->_charge_boost > 0)
        {
            $conn = 7;
            $dice = new Dice();
            switch ($range)
            {
                case 'short' :
                    $conn = 3;
                    break;
                case 'med' :
                    $conn = 4;
                    break;
                case 'long' :
                    $conn = 5;
                    break;
            }
            if ($dice->roll() > $conn)
                $target->damage(1);

            $this->_charge_boost--;

        }
        // // only works if weapon has charge
    }
}

?>