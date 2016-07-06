<?php

namespace Model;

trait SettableJediFactorTrait
{
    private $jediFactor;

    public function getJediFactor()
    {
        return $this->jediFactor;
    }

    public function setJediFactor($jediFactor)
    {
        $this->jediFactor = $jediFactor;
    }
}
