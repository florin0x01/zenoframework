<?
namespace ZenoFramework\Adapters;
use ZenoFramework\Adapters\SqlInclusionMode;
use ZenoFramework\Utils\SqlBuilder;

class MySqlTableAdapter implements IDataAdapter {
  private $connection;
  protected $table;

  public function __construct($connection, $table) {
    // $dsn = sprintf('mysql:dbname=%s;host=%s', $name, $host);
    // $this->connection = new \PDO($dsn, $user, $password,
    // [
    //   \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
    //   \PDO::ATTR_PERSISTENT => true
    // ]);
    //   }
    $this->connection = $connection;
    $this->table = $table;
  }
    
  public function findBy(SqlInclusionMode $mode, ...$args): array {
    list($query, $values) = SqlBuilder::SelectString($this->table, $mode, $args);
    $prepared = $this->connection->prepare($query);
    $prepared->execute($values);
    $results = $prepared->fetchAll();
    return $results;
  } 
  public function updateBy(SqlUpdateMode $mode, ...$args): array {
    list($query, $values) = SqlBuilder::UpdateString($this->table, $mode, $args);
    $prepared = $this->connection->prepare($query);
    $prepared->execute($values);
    $results = $prepared->fetchAll();
    return $results;
  }
  public function create(...$args) {
    list ($query, $values) = Sqlbuilder::InsertString($this->table, $mode, $args);
    $prepared = $this->connection->prepare($query);
    return $prepared->execute($values);
  }
  public function delete(... $args) {
    list($query, $values) = SqlBuilder::DeleteString($this->table, $mode, $args);
    $prepared = $this->connection->prepare($query);
    return $prepared->execute($values);
  }
}