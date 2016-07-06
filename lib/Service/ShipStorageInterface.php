<?php

interface ShipStorageInterface
{
    public function fetchAllShipsData();

    public function fetchSingleShipData($id);
}
