<?php
require("MysqlOpeation.php");
$table = "user";
if(isset($_POST['username'])){
    $username = $_POST['username'];

    $mql    = new MysqlOpeation($usr_base);
    $result = $msq->query("SELECT * FROM {$table} WHERE username=\"{$username}\";");

    if($result){
        //判断是否被注册
        if($result->num_rows != 0)
        {
            echo json_encode(array("status"=>101, "descrip" => "已经被注册"));
        }
        else
        {
            echo json_encode(array("status"=>100, "descrip" => "注册成功"));
        }
    }
  }
 ?>
