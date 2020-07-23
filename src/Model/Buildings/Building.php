<?php

namespace App\Model\Buildings;

class Building
{

    //Some inital values for the buildings
    //Set these as protected so that they can be overridden in child classes
    protected $name = "a";
    protected $health = 100;
    protected $resistance = 0;
    protected $retired = false;

    /**
     * @param float $attackStrength
     * @return float|int
     */
    public function takeDamage($attackStrength)
    {
        $damage = $attackStrength - ($attackStrength * $this->getResistance());
        $this->health = $this->health - $damage;
        return $damage;
    }

    public function isAlive()
    {
        return $this->health > 0;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Building
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getHealth(): float
    {
        return $this->health;
    }

    /**
     * @param float $health
     * @return Building
     */
    public function setHealth(float $health): Building
    {
        $this->health = $health;
        return $this;
    }

    /**
     * @return float
     */
    public function getResistance(): float
    {
        return $this->resistance;
    }

    /**
     * @param int $resistance
     * @return Building
     */
    public function setResistance(int $resistance): Building
    {
        $this->resistance = $resistance;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRetired(): bool
    {
        return $this->retired;
    }

    /**
     * @param bool $retired
     * @return Building
     */
    public function setRetired(bool $retired): Building
    {
        $this->retired = $retired;
        return $this;
    }


}
