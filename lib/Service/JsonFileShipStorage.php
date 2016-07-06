<?php

class JsonFileShipStorage
{
    private $filename;

    public function __construct($jsonFilePath)
    {
        $this->filename = $jsonFilePath;
    }

    public function fetchAllShipsData()
    {
        $jsonContents = file_get_contents($this->filename);

        return json_decode($jsonContents, true);
    }

    public function fetchSingleShipData($id)
    {
        $ships = $this->fetchAllShipsData();

        foreach ($ships as $ship) {
            if ($ship['id'] == $id) {
                return $ship;
            }
        }

        return null;
    }
}
