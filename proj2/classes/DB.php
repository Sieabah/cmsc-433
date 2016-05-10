<?php

/**
 * Class DB
 *
 * This class is the implementation of an ORM (rudimentary), meaning it allows dealing with
 *  the database is an OOP way
 *
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class DB
{
    //Holds the DB connection (between all instances)
    private static $connection = null;

    //What table does this model belong to?
    protected $table = null;

    //Wheres and bindings for ORM features
    protected $wheres = [];
    protected $bindings = [];

    /**
     * build_connection
     * Builds the DB connection and returns it
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return PDO
     */
    private function build_connection()
    {
        $handler = new PDO(
            'mysql:host='.config('db.host').';dbname='.config('db.database'),
            config('db.username'),
            config('db.password'));
        $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $handler;
    }

    /**
     * get_connection
     * Returns the a connection if it exists, or creates a new one
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return PDO
     */
    protected function get_connection()
    {
        if(is_null(DB::$connection))
        {
            return DB::$connection = $this->build_connection();
        }
        return DB::$connection;
    }

    /**
     * get_last_insert
     * Gets the ID of the last inserted row
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return string
     */
    protected function get_last_insert(){
        return $this->get_connection()->lastInsertId();
    }

    /**
     * query
     * Runs given query with parameterized arguments on the DB
     * @param $statement {string} SQL query
     * @param array $arguments {Array} Values
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return PDOStatement
     */
    public function query($statement, $arguments=[])
    {
        //Try to execute the query
        try {
            $conn = $this->get_connection();

            $query = $conn->prepare($statement);
            $query->execute($arguments);

            return $query;
        } catch(PDOException $e){
            //Explain what went wrong and die
            die($e->getMessage());
        }
    }

    /**
     * raw
     * Run the raw SQL statement directly on the DB
     * @param $statement {String} SQL query
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return PDOStatement
     */
    public function raw($statement){
        try{
            $conn = $this->get_connection();

            return $conn->query($statement);
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }

    /**
     * all
     * Returns all rows for the given table
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return array
     */
    public function all()
    {
        return $this->query('SELECT * FROM `'.$this->table.'`')->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * create
     * Create a row in the DB
     * @param $arr {Array} Array of parameters
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return string
     */
    public function create($table, $arr = null){
        if(is_array($table))
            $arr = $table;

        if(!is_null($this->table))
            $table = $this->table;

        $args = [];

        $str = 'INSERT INTO `'.$table.'` ';

        //Build the query
        $parameters = [];
        $columns = [];
        foreach($arr as $value => $parameter){
            $args[] = $parameter;
            $parameters[] = '?';
            $columns[] = '`'.$value.'`';
        }

        //Build the remainder of the query
        $str .= "(".implode(", ", $columns).") VALUES (".implode(", ", $parameters).");";

        $this->query($str, $args);
        return $this->get_last_insert();
    }
}

//Load the DB into the App container
app()->db = (new DB());