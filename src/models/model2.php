<?php

class Model{
  protected static $tableName = '';
  protected static $columns = [];
  protected $values = [];

  function __construct($arr, $sanitize = true){
    $this->loadFromArray($arr, $sanitize);
  }

  public function loadFromArray($arr, $sanitize = true){
    if ($arr) {
      $conn = DataBase::getConnection();
      foreach ($arr as $key => $value) {
        $cleanValue = $value;
        if ($sanitize && isset($cleanValue)) {
          $cleanValue = strip_tags(trim($cleanValue));
          $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);
          $cleanValue = mysqli_real_escape_string($conn, $cleanValue);
        }
        $this->$key = $value;
      }
      $conn->close();
    }
  }

  public function __get($key){
    return isset($this->values[$key]) ? $this->values[$key] : null;
  }

  public function __set($key, $value){
    $this->values[$key] = $value;
  }

  public function getValues(){
    return $this->values;
  }

  public static function getOne($filters = [], $columns = '*'){
    $class = get_called_class();
    $result = static::getResultSetFromSelect($filters, $columns);
    return $result ? new $class($result->fetch_assoc()) : null;
  }

  public static function get($filters = [], $columns = '*'){
    $objects = [];
    $result = static::getResultSetFromSelect($filters, $columns);
    if ($result) {
      $class = get_called_class();
        while($row = $result->fetch_assoc()){
          array_push($objects, new $class($row));
        }
    }
    return $objects;
  }

  public static function getResultSetFromSelect($filters = [], $columns = '*'){
    $sql = "select ${columns} from " . static::$tableName . ' ' . static::getFilters($filters);
    $result = DataBase::getResultFromQuery($sql);
    if (!$result || $result->num_rows === 0) {
      return null;
    }else{
      return $result;
    }

  }

  public function insert() {
    $sql = "INSERT INTO " . static::$tableName . " (" . implode(",", static::$columns) . ") VALUES (";
    foreach(static::$columns as $col){
      $sql .= static::getFormatedValue($this->$col) . ",";
    }
    $sql[strlen($sql) - 1] = ")";
    $id = DataBase::executeSQL($sql);
    $this->id = $id;
  }

  public function update() {
    $sql = "UPDATE " . static::$tableName . " SET ";
    foreach(static::$columns as $col){
      $sql .= "${col} = " . static::getFormatedValue($this->$col) . ",";
    }
    $sql[strlen($sql) - 1] = ' ';
    $sql .= "WHERE id = {$this->id}";
    DataBase::executeSQL($sql);
  }

  public static function getCount($filters = []){
    $result = static::getResultSetFromSelect($filters, 'count(*) as count');
    return $result->fetch_assoc()['count'];
  }

  public function delete(){
    static::deletebyId($this->id);
  }

  public static function deletebyId($id){
    $sql = "DELETE FROM " . static::$tableName . " WHERE id = {$id}";
    DataBase::executeSQL($sql);
  }

  private static function getFilters($filters){
    $sql = '';
    if (count($filters) > 0) {
      $sql .= " WHERE 1 = 1";
      foreach ($filters as $column => $value) {
        if ($column == 'raw') {
          $sql .= " AND {$value}";
        }else {
          $sql .= " AND ${column} =" . static::getFormatedValue($value);
        }
      }
    }
    return $sql;
  }

  private static function getFormatedValue($value){
    if (is_null($value)) {
      return "null";
    } elseif (getType($value) === 'string') {
      return "'${value}'";
    }else {
      return $value;
    }
  }
}


 ?>
