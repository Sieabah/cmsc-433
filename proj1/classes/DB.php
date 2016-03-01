<?php

class DB extends BaseClass
{
    const inject = true;
    private $config;

    public function __construct($config)
    {
        $this->config = $config->db;
    }

    protected function get_connection()
    {
        return null;
    }

    public function query()
    {
        return null;
    }

    public function all()
    {
        return null;
    }
}