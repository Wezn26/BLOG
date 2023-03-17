<?php



namespace App\Resourses;

use App\Traits\Singleton;
use PDO;


/**
 * Description of Db
 *
 * @author leonid
 */
class Db 
{
    use Singleton;
    
    private $dbh;
    
    public function __construct() 
    {
        require __DIR__ . '/config.php';
        $this->dbh = new PDO(DSN);
    }
    
    public function query(string $sql, array $data = []) 
    {
        $stmt = $this->dbh->prepare($sql);
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (is_int($value)) {
                    $type = PDO::PARAM_INT;
                } else {
                    $type = PDO::PARAM_STR;
                }
                $stmt->bindValue(':'.$key, $value, $type);
            } 
        }
        $stmt->execute();
        return $stmt;
    }
    
    public function row(string $sql, array $data = []) 
    {
        $result = $this->query($sql, $data);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function column(string $sql, array $data = []) 
    {
        $result = $this->query($sql, $data);
        return $result->fetchColumn();
    }
    
    public function lastInsertId() 
    {
        return $this->dbh->lastInsertId();
    }
    
    
}
