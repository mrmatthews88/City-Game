<?php


namespace App\Model;


use App\Model\Weapons\Weapon;

class Armoury
{
    private $weapons = [];
    private $count = 0;

    /**
     * @param Weapon $weapon
     */
    public function addWeapon(Weapon $weapon)
    {
        $weapon->setId(++$this->count);
        $this->weapons[$weapon->getId()] = $weapon;
        return $this;
    }

    /**
     * @return Weapon[]
     */
    public function getWeapons(){
        return $this->weapons;
    }

    /**
     * @param $id
     * @return Weapon|boolean
     */
    public function getWeapon($id)
    {
        if (isset($this->weapons[$id])) {
            return $this->weapons[$id];
        }
        return false;
    }
}