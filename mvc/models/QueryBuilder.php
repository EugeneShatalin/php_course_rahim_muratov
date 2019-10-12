<?php

class QueryBuilder {
  
  protected $pdo;
  public function __construct($pdo)
  {
      $this->pdo = $pdo;
  }

  public function getDataFromTwoTables_DESC ($table1, $table2, $nameColumnTable1, $nameColumnTable2) 
    {    
    $sql = "SELECT * FROM $table1 LEFT JOIN $table2 ON $table1.$nameColumnTable1=$table2.$nameColumnTable2 ORDER BY date DESC";
    $result = $this->pdo->query($sql);
   
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAll($table) 
  {
    $sql = "SELECT * FROM $table";
    $result = $this->pdo->query($sql);
   
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }
  
  public function create ($table, $date)
  {
      $keys = implode(',', array_keys($date));
      $tags = ":" . implode(', :', array_keys($date));

      $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$tags})";

      $statement = $this->pdo->prepare($sql);
      $statement->execute($date);

  }
  public function getRequestWithCondition($requiredValues, $table, $condition) 
  {
    $sql = "SELECT $requiredValues FROM $table WHERE $condition";
    
    $result = $this->pdo->query($sql);
   
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function update($table, $date, $condition)
  {
    foreach ($date as $key => $value); 

    $sql = "UPDATE {$table} SET {$key} = '{$value}' WHERE $condition";       
    
    $statement = $this->pdo->prepare($sql);
    $statement->execute($date);
  }

  public function delete($table, $id)
  {
    $sql = "DELETE FROM comments WHERE id = '$id'";
    
    $statement = $this->pdo->prepare($sql);
    $statement->execute($date);
  }
  public function getRequestWithConditionAND($requiredValues, $table, $condition, $and) 
  {
    $sql = "SELECT $requiredValues FROM $table WHERE $condition AND $and";
    
    $result = $this->pdo->query($sql);
   
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

}