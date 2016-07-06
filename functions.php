<?php

require_once __DIR__.'/lib/Ship.php';
require_once __DIR__.'/lib/BattleManager.php';

function get_ships()
{
    $ships = array();

    $ship = new Ship('Jedi Starfighter');
    //$ship->setName('Jedi Starfighter');
    $ship->setWeaponPower(5);
    $ship->setJediFactor(15);
    $ship->setStrength(30);
    $ships['starfighter'] = $ship;

    $ship2 = new Ship('CloakShape Fighter');
    $ship2->setWeaponPower(2);
    $ship2->setJediFactor(2);
    $ship2->setStrength(70);
    $ships['cloakshape_fighter'] = $ship2;

    $ship3 = new Ship('Super Star Destroyer');
    $ship3->setWeaponPower(70);
    $ship3->setJediFactor(0);
    $ship3->setStrength(500);
    $ships['super_star_destroyer'] = $ship3;

    $ship4 = new Ship('RZ-1 A-wing interceptor');
    $ship4->setWeaponPower(4);
    $ship4->setJediFactor(4);
    $ship4->setStrength(50);
    $ships['rz1_a_wing_interceptor'] = $ship4;

    return $ships;

    /*
    return array(
        'starfighter' => array(
            'name' => 'Jedi Starfighter',
            'weapon_power' => 5,
            'jedi_factor' => 15,
            'strength' => 30,
        ),
        'cloakshape_fighter' => array(
            'name' => 'CloakShape Fighter',
            'weapon_power' => 2,
            'jedi_factor' => 2,
            'strength' => 70,
        ),
        'super_star_destroyer' => array(
            'name' => 'Super Star Destroyer',
            'weapon_power' => 70,
            'jedi_factor' => 0,
            'strength' => 500,
        ),
        'rz1_a_wing_interceptor' => array(
            'name' => 'RZ-1 A-wing interceptor',
            'weapon_power' => 4,
            'jedi_factor' => 4,
            'strength' => 50,
        ),
    );
    */
}

function didJediDestroyShipUsingTheForce(Ship $ship)
{
    $jediHeroProbability = $ship->getJediFactor() / 100;

    return mt_rand(1, 100) <= ($jediHeroProbability*100);
}
