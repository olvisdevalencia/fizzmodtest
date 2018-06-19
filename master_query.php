<?php
  require_once('products.class.php');

  $products = new Products();

  $file         = 'first_run.txt';
  $file_exist   = file_exists($file);

  if (!$file_exist) {
      $my_file = fopen($file, "w") or die("Unable to open file!");
      fclose($my_file);
      $products->first_run_query();
  }

  $response    =  json_encode(['success' => false, 'message' => 'We can not process it']);

  if(isset($_GET['product_id']) && $_GET['product_id'] != 0) {

     $id       = $_GET['product_id'];
     $find     = $products->get_product_by_id($id);
     $response = $find;

  }

  if(isset($_GET['get_all'])) {

    $list     = $products->get_all();
    $response = $list;

 }

 if(isset($_GET['delete_id'])) {

    $id        = $_GET['delete_id'];
    $delete    = $products->delete($id);
    $response  = json_encode(['success' => true]);

  }

  echo $response;
