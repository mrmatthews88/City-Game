<?php

namespace App\Model\Buildings;

class House extends Building
{

    //override base values
    protected $name = "House";
    protected $health = 50;
    protected $resistance = .25;


}
