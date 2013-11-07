<?php
/*
 * The PdoDatabaseWrapper is a wrapper around the PHP PDO class.
 */
class PdoDatabaseWrapper
{
    private $stmt;
    private $dbh;

    /*
     * Create a new PdoDatabaseWrapper object
     * 
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $password
     * @return void
     */
    public function __construct($host, $dbname, $user, $password)
    {        
        // Set DSN
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );

        // Create a new PDO instanace
        $this->dbh = new PDO($dsn, $user, $password, $options);
    }

    /*
     * Prepare a query, use bind to bind dynamic values.
     * 
     * @param string $query
     * @return void
     */
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

	/**
	 * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 1.0.0)<br/>
	 * Binds a value to a parameter
	 * @link http://php.net/manual/en/pdostatement.bindvalue.php
	 * @param mixed $parameter <p>
	 * Parameter identifier. For a prepared statement using named
	 * placeholders, this will be a parameter name of the form
	 * :name. For a prepared statement using
	 * question mark placeholders, this will be the 1-indexed position of
	 * the parameter.
	 * </p>
	 * @param mixed $value <p>
	 * The value to bind to the parameter.
	 * </p>
	 * @param int $type [optional] <p>
	 * Explicit data type for the parameter using the PDO::PARAM_*
	 * constants.
	 * </p>
	 * @return void
	 */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
         $this->stmt->bindValue($param, $value, $type);
    }
    
    public function execute(){
        return $this->stmt->execute();
    }

    public function resultset(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    
    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }
    
    public function beginTransaction(){
        return $this->dbh->beginTransaction();
    }
    
    public function endTransaction(){
        return $this->dbh->commit();
    }
    
    public function cancelTransaction(){
        return $this->dbh->rollBack();
    }

    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }
    
    /*
     * The PDO class has no close function, so let's just tell the caller:
     * "Yeah, all good!"
     * 
     * @return boolean
     */
    public function close(){
        return true;
    }
}
