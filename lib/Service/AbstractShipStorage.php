<?php

abstract class AbstractShipStorage
{
    abstract public function fetchAllShipsData();

    abstract public function fetchSingleShipData($id);
}