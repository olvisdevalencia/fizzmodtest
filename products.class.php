<?php

include 'database.class.php';
/**
 * Products class
 * I'M SORRY FOR NOT USE CSS CLASS.
 */
class Products extends Database {

  public $db;

  function __construct()
  {
    $mysql    = new Database();
    $this->db = $mysql->connect();
  }

  /**
   *
   * Method to check if first run and populate database
   */
  public function first_run_query()
  {

    $data   = file_get_contents('pub/products.json');
    $data   = json_decode($data);

    foreach ($data as $key => $value) {

      $sql_query="INSERT INTO products (`name`,`price`,`status`) VALUES('".$value->name."','".$value->price."', 1)";
      mysqli_query($this->db,$sql_query);

    }

  }

  /**
   *
   * Method to find an active products by id
   */
  public function get_product_by_id($id)
  {

    if (mysqli_connect_errno()) {

      echo json_encode(['success' => false, 'message' => "Connect failed: %s\n", mysqli_connect_error()]);
      exit;
    }

    $sql_query    = "SELECT * FROM products WHERE status = 1 and id=".$id;

    $result_set   = mysqli_query($this->db,$sql_query);
    $fetched_row  = mysqli_fetch_array($result_set,MYSQLI_ASSOC);

    if (!$fetched_row) {
      echo json_encode(['success' => false, 'message' => "There is not result"]);
      exit;
    }

    $fetched_row['success'] = true;
    echo json_encode($fetched_row);

    $this->db->close();

  }

  /**
   *
   * Method to fetch all active products
   */
  public function get_all()
  {

    if (mysqli_connect_errno()) {

      echo json_encode(['success' => false, 'message' => "Connect failed: %s\n", mysqli_connect_error()]);
      exit;
    }

    $sql_query    = "SELECT * FROM products WHERE status = 1";
    $rows         = [];
    $result_set   = mysqli_query($this->db,$sql_query);

    while($row = mysqli_fetch_array($result_set)) {
      $rows[] = $row;
    }

    if (!$rows) {
      echo json_encode(['success' => false, 'message' => "There is not result"]);
      exit;
    }

    $fetched_row['success'] = true;
    echo json_encode($rows);

    $this->db->close();

  }

 /**
  *
  * Method to delete a product
  */
  public function delete($id)
  {

    $sql = $this->db;

    if (mysqli_connect_errno()) {

      echo json_encode(['success' => false, 'message' => "Connect failed: %s\n", mysqli_connect_error()]);
      exit;
    }

    $sql_query  = "UPDATE products SET status = -1 WHERE id = $id";
    $result = $sql->query($sql_query);

    if (!$result) {
      echo json_encode(['success' => false, 'message' => "Could not delete this product"]);
      exit;
    }

    $this->db->close();
  }

}
