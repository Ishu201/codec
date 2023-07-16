<?php

class item {

// all in item master
  public function viewItem_master() {
      $con = $GLOBALS['con'];
      $sql = "SELECT * FROM item_master";
      $result = $con->query($sql);
      return $result;
  }

// single record in item master
  public function viewItem_masterSelected($id) {
      $con = $GLOBALS['con'];
      $sql = "SELECT * FROM item_master WHERE item_master_id='$id'";
      $result = $con->query($sql);
      return $result;
  }

// item list according to a master item id
  public function viewIndividual_ItemSelected($id) {
      $con = $GLOBALS['con'];
      $sql = "SELECT * FROM item WHERE item_master_id='$id'";
      $result = $con->query($sql);
      return $result;
  }

// maintenance list records of a single item
  public function maintenance_ItemSelected($id) {
      $con = $GLOBALS['con'];
      $sql = "SELECT * FROM item_maintenance WHERE itemID='$id'";
      $result = $con->query($sql);
      return $result;
  }

// data of a single item
  public function viewIndividual_ItemDataSelected($id) {
      $con = $GLOBALS['con'];
      $sql = "SELECT * FROM item WHERE itemID='$id'";
      $result = $con->query($sql);
      return $result;
  }

  public function get_remainning($id){
    $con = $GLOBALS['con'];
    $sql = "SELECT * FROM item WHERE value!=0 AND item_master_id='$id'";
    $result = $con->query($sql);
    $rowcount= mysqli_num_rows($result);
    return $rowcount;
  }

  function addItem() {
     $con = $GLOBALS['con'];
     $masterID = $_POST['masterID'];
    $category = $_POST['category'];
    $itemName = $_POST['itemName'];
    $descript = $_POST['descript'];
    $brandName = $_POST['brandName'];
    $vendor = $_POST['vendor'];
    $shopLocation = $_POST['shopLocation'];
    $qty = $_POST['qty'];
    $unitPrice = $_POST['unitPrice'];
    $totalPrice = $_POST['totalPrice'];
    $warrentDate = $_POST['warrentDate'];
    $purchaseDate = $_POST['purchaseDate'];

    $method = $_POST['method'];

    if (!empty($_FILES["image"]["name"])) {
        // Get file info
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg','webp');
        if (in_array($fileType, $allowTypes)) {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));
        }
    }

          $sql = "INSERT INTO item_master (item_master_id,category,image,itemName,descript,brandName,vendor,shopLocation,qty,totalPrice,warrentDate,purchaseDate)
          VALUES('$masterID','$category','$imgContent','$itemName','$descript','$brandName','$vendor','$shopLocation','$qty','$totalPrice','$warrentDate','$purchaseDate')";
          $result = $con->query($sql) or die($con->error);
          $msg = $itemName;

          for ($i=1; $i <= $qty ; $i++) {
            $sql2 = "INSERT INTO item(item_master_id,value) VALUES ('$masterID','$unitPrice')";
            $result2 = $con->query($sql2) or die($con->error);
          }

          $sql2 = "INSERT INTO expenses (type,amount,account,paidDate,method)
          VALUES('Product Purchase','$totalPrice','General','$purchaseDate','$method')";
          $result2 = $con->query($sql2) or die($con->error);

      return $msg;
  }

  function edit_item(){
    $con = $GLOBALS['con'];
    $itemID = $_POST['itemID'];
    $allocation = $_POST['Allocation'];
    $defects = $_POST['defects'];
    $quality = $_POST['quality'];
    $value = $_POST['value'];
    $stat ='';

    if ($quality == 0) {
      $stat = ",status='Out of Use'";
      $allocation = 'Damaged Stock';
    }

    $sql2 = "UPDATE item SET value='$value',allocation='$allocation',quality='$quality',defects='$defects' $stat WHERE itemID='$itemID'";
    $result2 = $con->query($sql2) or die($con->error);
  }

  function sentto_repair(){
    $con = $GLOBALS['con'];
    $itemID = $_POST['itemID'];
    $reason = $_POST['reason'];
    $startDate = $_POST['startDate'];
    $shop = $_POST['shop'];
    $shopLocation = $_POST['shopLocation'];

    $sql2 = "INSERT INTO item_maintenance (itemID,reason,startDate,shop,shopLocation)
    VALUES('$itemID','$reason','$startDate','$shop','$shopLocation')";
    $result2 = $con->query($sql2) or die($con->error);

    $sql3 = "UPDATE item SET status='Repair',defects='$reason',allocation='In the Stock' WHERE itemID='$itemID'";
    $result3 = $con->query($sql3) or die($con->error);

    return $itemID;
  }


  function backfrom_repair(){
    $con = $GLOBALS['con'];
    $itemID = $_POST['itemID'];
    $mainID = $_POST['mainID'];
    $deliveredDate = $_POST['deliveredDate'];
    $status = $_POST['stat'];

// if the repair is successfull
    if($status == 'Successfull'){
      $method = $_POST['method'];
      $cost = $_POST['cost'];

      $sql4 = "INSERT INTO expenses (type,amount,account,paidDate,method)
      VALUES('Product Maintenance','$cost','General Account','$deliveredDate','$method')";
      $result4 = $con->query($sql4) or die($con->error);

      $sql3 = "UPDATE item SET status='Working',defects='No'  WHERE itemID='$itemID'";
      $result3 = $con->query($sql3) or die($con->error);
    }

// if the repair is Unsuccessfull
     else{
      $quality = $_POST['quality'];
      $value = $_POST['value'];
      if ($quality == 0) {
        $value = 0;
        $sql3 = "UPDATE item SET quality='$quality',value='$value',status='Out of Use', allocation='Damaged Stock'  WHERE itemID='$itemID'";
        $result3 = $con->query($sql3) or die($con->error);
      }else{
        $sql3 = "UPDATE item SET quality='$quality',value='$value',status='Working'  WHERE itemID='$itemID'";
        $result3 = $con->query($sql3) or die($con->error);
      }
    }

    $sql2 = "UPDATE item_maintenance SET deliveredDate='$deliveredDate',cost='$cost',status='$status' WHERE maintenanceID='$mainID'";
    $result2 = $con->query($sql2) or die($con->error);

  }

  function remove_stationary($id){
    $con = $GLOBALS['con'];
    $val =0;
    $sql3 = "UPDATE item SET value='$val',allocation='Out of Stock'  WHERE itemID='$id'";
    $result3 = $con->query($sql3) or die($con->error);
  }


}

 ?>
