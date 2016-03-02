<?php

class DB extends BaseClass
{
    const inject = true;
    private $config;
    private static $connection = null;

    protected $table;

    public function __construct($config)
    {
        $this->config = $config->db;
        $this->table = null;
    }

    private function build_connection()
    {
        $handler = new PDO(
            'mysql:host='.$this->config['host'].';dbname='.$this->config['database'],
            $this->config['username'],
            $this->config['password']);
        $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $handler;
    }

    protected function get_connection()
    {
        if(is_null(DB::$connection))
        {
            return DB::$connection = $this->build_connection();
        }
        return DB::$connection;
    }

    public function query($statement, $arguments=[])
    {
        try {
            $conn = $this->get_connection();

            $query = $conn->prepare($statement);
            return $query->execute($arguments);
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function all()
    {
        var_dump($this->table);
        return $this->query('SELECT * FROM classes');
    }
}