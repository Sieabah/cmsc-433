<?php

class DB extends BaseClass
{
    const inject = true;
    private static $connection = null;

    protected $table = null;

    protected $wheres = [];
    protected $bindings = [];

    public function __construct($config)
    {
    }

    private function build_connection()
    {
        $handler = new PDO(
            'mysql:host='.config('db.host').';dbname='.config('db.database'),
            config('db.username'),
            config('db.password'));
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

    protected function get_last_insert(){
        return $this->get_connection()->lastInsertId();
    }

    public function query($statement, $arguments=[])
    {
        try {
            $conn = $this->get_connection();

            $query = $conn->prepare($statement);
            $query->execute($arguments);

            return $query;
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function raw($statement){
        try{
            $conn = $this->get_connection();

            return $conn->query($statement);
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function newQuery(){
        $this->bindings = [];
        $this->wheres = [];

        return $this;
    }

    public function select($column, $value){
        return null;
    }

    public function all()
    {
        return $this->query('SELECT * FROM `'.$this->table.'`')->fetchAll(PDO::FETCH_OBJ);
    }

    public function create($arr){
        $args = [];

        $str = 'INSERT INTO `'.$this->table.'` ';

        $parameters = [];
        $columns = [];
        foreach($arr as $value => $parameter){
            $args[] = $parameter;
            $parameters[] = '?';
            $columns[] = '`'.$value.'`';
        }

        $str .= "(".implode(", ", $columns).") VALUES (".implode(", ", $parameters).");";

        $this->query($str, $args);
        return $this->get_last_insert();
    }
}