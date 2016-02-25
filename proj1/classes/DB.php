<?php

class DB extends BaseClass
{
    const inject = true;
    private $config;

    public function __construct($config){
        $this->config = $config->db;
    }

    public function query(){

    }

    public function all(){

    }
}