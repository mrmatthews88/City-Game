<?php

namespace App\Model;

use App\Model\Buildings\Building;
use App\Model\Weapons\Weapon;

class Town
{


    private $output = [];
    private $objectiveMet = false;

    //Some inital values for the buildings
    //Set these as protected so that they can be overridden in child classes
    private $name = 'Town';
    private $buildings = [];
    private $turnNumber = 0;
    private $totalDamage = 0;


    /**
     * @param string $name
     * @return Town
     */
    public function setName(string $name): Town
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Building[]
     */
    public function getBuildings()
    {
        return $this->buildings;
    }

    /**
     * @return Building[]
     * find valid targets, not attacking destroyed buildings
     */
    public function getAliveBuildings()
    {
        return \array_filter($this->buildings, function ($building) {
            /**
             * @var $building Building
             */
            return $building->isAlive();
        });
    }

    /**
     * @param array $buildings
     * @return Town
     */
    public function setBuildings(array $buildings): Town
    {
        $this->buildings = $buildings;
        return $this;
    }

    /**
     * @param Building $building
     */
    public function addBuilding(Building $building)
    {
        $this->buildings[] = $building;
        return $this;
    }


    /**
     * @return int
     */
    public function getTurnNumber(): int
    {
        return $this->turnNumber;
    }

    /**
     * @param int $turnNumber
     * @return Town
     */
    public function setTurnNumber(int $turnNumber): Town
    {
        $this->turnNumber = $turnNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalDamage(): int
    {
        return $this->totalDamage;
    }

    /**
     * @param int $totalDamage
     * @return Town
     */
    public function setTotalDamage(int $totalDamage): Town
    {
        $this->totalDamage = $totalDamage;
        return $this;
    }

    /**
     * @param string $text
     */
    public function addOutput(string $text)
    {
        if (!isset($this->output[$this->turnNumber])) {
            $this->output[$this->turnNumber] = [];
        }
        $this->output[$this->turnNumber][] = $text;
    }

    /**
     * @param Weapon $weapon
     */
    public function attackRandomBuilding($weapon)
    {
        $buildings = $this->getAliveBuildings();
        if (!$buildings) {
            throw new \Exception("No buildings in the town");
        }
        /**
         * @var $building Building
         */
        $building = $buildings[\array_rand($buildings)];

        $this->addOutput("You attack {$building->getName()} with your {$weapon->getName()}");

        //Using a random chance to see if we hit our selected building
        // if random chance is higher than our accuracy then we have missed
        $randomChance = \mt_rand(1, 100);
        if ($randomChance < $weapon->getAccuracy()) {

            // pass through our weapon damage
            $damage = $building->takeDamage($weapon->getDamage());

            // add the damage on to the total, just to show as some stats at the end of the game
            $this->totalDamage += $damage;

            // test whether the building is now destroyed, to vary the output message
            if ($building->getHealth() <= 0) {
                $this->addOutput("You dealt {$damage} damage which has destroyed the building");
            } else {
                $this->addOutput("You dealt {$damage} damage");
            }


        } else {
            $this->addOutput("You have missed.");
        }


    }

    /**
     * @return array
     */
    public function getOutput(): array
    {
        return $this->output;
    }

    /**
     * @param array $output
     * @return Town
     */
    public function setOutput(array $output): Town
    {
        $this->output = $output;
        return $this;
    }

    public function getLatestOutput()
    {
        if (isset($this->output[$this->turnNumber])) {
            return \implode("\n", $this->output[$this->turnNumber]);
        } else {
            return "Please select a weapon to attack the town";
        }
    }

    public function incrementTurn()
    {
        $this->turnNumber++;
    }

    public function isObjectiveMet()
    {
        if ($this->objectiveMet) return true;
        $remaining = [
            'Castle' => false,
            'House' => false,
            'Farm' => false
        ];

        foreach ($this->getBuildings() as $building) {
            if (isset($remaining[$building->getName()])) {
                if ($building->getHealth() > 0) {
                    $remaining[$building->getName()] = true;
                }
            }
        }

        if (!$remaining['Castle'] || (!$remaining['House'] && !$remaining['Farm'])) {
            return $this->objectiveMet = true;
        }
        return false;
    }

}
