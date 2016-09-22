<?php

/**
 * Created by PhpStorm.
 * User: rojones
 * Date: 9/22/16
 * Time: 9:16 AM
 */

require_once (Dice::class);

abstract class Ship
{
    protected $fleet;
    protected $name;
    protected $size; // area of ship
    protected $length; // hull length
    protected $width; // hull width
    protected $hull_point;
    protected $pp; //power points;
    protected $speed;
    protected $handling;
    protected $shield;
    protected $direction;
    protected $moved = 0;
    protected $center = array('x'=>75, 'y'=>50);
    protected $weapons = array();
    protected $can_stop = false;
    protected $stationary = false;
    //power busts
    protected $hull_left;
    protected $moved_from_turn = 0;
    protected $collision = false;
    protected $pp_left = 0;
    protected $speed_boost = 0;

    public function __construct($fleet, $name, $size, $length, $width, $hull_point, $pp, $speed, $handling, $shield,
                                $direction, array $center, array $weapons)
    {
        if (!array_key_exists('x', $center) || !array_key_exists('y', $center))
            new ErrorException('center coordernates incorectly defined');
        else if ($direction == 'up' || $direction == 'down' || $direction == 'left' || $direction == 'right')
        {
            $this->fleet = $fleet;
            $this->name = $name;
            $this->size = $size;
            $this->length = $length;
            $this->width = $width;
            $this->hull_point = $hull_point;
            $this->hull_left = $hull_point;
            $this->pp = $pp;
            $this->speed = $speed;
            $this->handling = $handling;
            $this->shield = $shield;
            $this->center = $center;
            $this->weapons = $weapons;
        }
        else
            new ErrorException('direction not corecty specifyed use up, down left or right');
    }

    abstract public function shoot();

    public function powerShield()
    {
        if ($this->pp_left > 0)
        {
            $this->shield++;
            $this->pp_left--;
        }

    }

    public function powerSpeed()
    {
        if ($this->pp_left > 0)
        {
            $this->shield++;
            $this->pp_left--;
        }
    }

    public function repair()
    {
        if ($this->can_repair())
        {
            $dice = new Dice();
            if ($this->pp_left > 0)
            {
                $this->pp_left--;
                if ($dice->roll == 6)
                {
                    $this->hull_left++;
                }
            }
        }
        return false;
    }

    public function can_repair()
    {
        if ($this->hull_left < $this->hull_point)
        {
            return true;
        }
        return false;
    }

    public function can_turn()
    {
        if ($this->moved_from_turn >= $this->handling || $this->stationary == true)
            return true;
        return false;
    }

    public function hasPower()
    {
        if ($this->pp_left > 0)
            return true;
        return false;
    }

    public function get_turn()
    {
        if ($this->direction == 'up' || $this->direction == 'down')
            return (array('left','right'));
        if ($this->direction == 'left'|| $this->direction == 'right')
            return (array('up','down'));
    }

    public function get_hull()
    {
        return $this->hull_point;
    }

    public function damage($damage)
    {
        if ($damage > $this->shield)
        {
            $this->hull_left -= ($damage - $this->shield);
        }
        else
            $this->shield -= $damage;
    }

    public function make_turn($new_dir)
    {
        if (($new_dir == 'left' || $new_dir == 'right') && ($this->direction == 'up' || $this->direction == 'down'))
        {
            $this->direction = $new_dir;
            $this->moved_from_turn = 0;
            return (true);
        }
        else
            return (false);
    }

    public function isStationary(): bool
    {
        return $this->stationary;
    }

    public function setCan_stop()
    {
        if ($this->moved == $this->handling || $this->stationary == true)
            $this->can_stop = true;
        else
            $this->can_stop = false;
    }

    public function can_stop()
    {
        return $this->can_stop;
    }

    public function set_collision(Ship $hit){
        $this->collision = true;
        $this->stationary = true;
        if ($this->moved_from_turn > $this->handling)
        {
            $damage = $hit->get_hull();
            $this->damage($damage);
            $hit->damage($damage);
        }
    }

    public function reset()
    {
        $this->moved = 0;
        $this->pp_left = $this->pp;
        $this->shield = 0;
        $this->speed_boost = 0;
    }

    public function opperational()
    {
        if ($this->hull_point > 0)
            return true;
        else
            return false;
    }

    public function setStationary(bool $stationary)
    {
        $this->stationary = $stationary;
    }

}