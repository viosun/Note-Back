<?php
  require_once("MysqlOperation.php");
  $table = "user";
  /*[100 注册成功] [101 用户已经存在] [500]数据库错误*/
  if(isset($_POST['username']) &&
     isset($_POST['password']) &&
     isset($_POST['name'])     &&
     isset($_POST['sex'] )){

    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $name = $_POST['name'];
    $sex  = $_POST['sex'] ;
    $intro = $_POST['intro'];
    $phone = $_POST['phone'];
    $mql = new MysqlOperation($usr_base);

    if($mql){
      $result = $mql->query("SELECT * from {$table} WHERE username=\"{$username}\"");

      if($result){
        if($result->num_rows != 0){ //判断是否已经注册过了
          echo json_encode(array("status"=>101));
        }else{  //加入新的用户
          $create_table = $mql->query("
          CREATE TABLE IF NOT EXISTS {$art_base}.{$username}(
            id INT NOT NULL AUTO_INCREMENT,
            create_date DATETIME NOT NULL,
            change_date DATETIME NOT NULL,
            title VARCHAR(100) NOT NULL,
            tags VARCHAR(100) NOT NULL,
            content MEDIUMTEXT,
            PRIMARY KEY(id)
          )
          ");

          if($create_table){
            $insert_member = $mql->query("
            INSERT INTO {$table}(username, password, name, sex, intro, phone)
            VALUES(\"{$username}\", \"{$password}\", \"{$name}\", {$sex},
            \"{$intro}\", \"{$phone}\");
            ");

            //插入成功返回刚刚注册的 用户名 和 密码
            if($insert_member){
              echo json_encode(array(
                "status"  =>100,
                "username"=>$username,
                "password"=>$password,
                "name"    =>$name,
                "sex"     =>$sex,
                "intro"   =>$intro,
                "phone"   =>$phone
              ));
            }
          }else{
            echo json_encode(array("status" => 500));
          }
        }
      }
    }
  }
?>