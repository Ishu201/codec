<?php

include '../common/dbconnection.php';
include '../model/itemmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
$obj = new item();
//$result = $obj->viewAemployee($name);

$status = $_REQUEST['status'];

if (($status=='itemdataUpdate') or ($status=='senttorepair') or ($status=='backfromrepair')){
  $id = $_REQUEST['id'];
  $name = $_REQUEST['name'];
}

if ($status=='removeStationary') {
  $id = $_REQUEST['id'];
  $name = $_REQUEST['name'];
  $itemID = $_REQUEST['itemID'];
}

switch ($status) {
    case "add":
        $msg = $obj->addItem();
        $msg = $msg.' is Successfully Added to the System';
        $newmsg = base64_encode($msg);
        header("Location:../addResource.php?msg=$newmsg&code=success");
    break;

    case "itemdataUpdate":
      $msg = $obj->edit_item();
      $newmsg = base64_encode('Item Details Updated');
      header("Location:../viewItems.php?msg=$newmsg&id=$id&name=$name");
    break;

    case "backfromrepair":
      $msg = $obj->backfrom_repair();
      $newmsg = base64_encode('Item Brought back from Repair');
      header("Location:../viewItems.php?msg=$newmsg&id=$id&name=$name");
    break;

    case "senttorepair":
      $msg = $obj->sentto_repair();
      $newmsg = base64_encode('Item Sent to a Repair Center');
      header("Location:../viewItems.php?msg=$newmsg&id=$id&name=$name");
    break;

    case "removeStationary":
      $msg = $obj->remove_stationary($itemID);
      $newmsg = base64_encode('Item is out of Stock');
      header("Location:../viewItems.php?msg=$newmsg&id=$id&name=$name");
    break;


}
