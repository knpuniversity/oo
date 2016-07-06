<?php

namespace Service;

class LoggableShipStorage implements ShipStorageInterface
{
    private $shipStorage;

    public function __construct(ShipStorageInterface $shipStorage)
    {
        $this->shipStorage = $shipStorage;
    }

    public function fetchAllShipsData()
    {
        return $this->shipStorage->fetchAllShipsData();
    }

    public function fetchSingleShipData($id)
    {
        return $this->fetchSingleShipData($id);
    }
}
