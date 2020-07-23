<?php

namespace App\Model\Weapons;

class Weapon
{

    protected $id = 0;
    protected $name;
    protected $accuracy = 100;
    protected $damage = 20;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Weapon
     */
    public function setId(int $id): Weapon
    {
        $this->id = $id;
        return $this;
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
     * @return Weapon
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getAccuracy(): int
    {
        return $this->accuracy;
    }

    /**
     * @param int $accuracy
     * @return Weapon
     */
    public function setAccuracy(int $accuracy): Weapon
    {
        $this->accuracy = $accuracy;
        return $this;
    }

    /**
     * @return int
     */
    public function getDamage(): int
    {
        return $this->damage;
    }

    /**
     * @param int $damage
     * @return Weapon
     */
    public function setDamage(int $damage): Weapon
    {
        $this->damage = $damage;
        return $this;
    }



}
