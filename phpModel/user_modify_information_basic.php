<?php
session_start();

require_once("MysqlOperation.php");
$table = "user";

if(isset($_COOKIE['username'])){
  $server = $_SESSION[$_COOKIE['username']];
  if($server){
      if($server['username'] == $_COOKIE['username'] &&
         $server['password'] == $_COOKIE['password'] &&
         $server['csym'] == $_COOKIE['csym'])
      {

          if(isset($_POST['username'])  &&
             !empty($_POST['name'])     &&
             !empty($_POST['sex'])      &&
             !empty($_POST['intro'])    &&
             !empty($_POST['phone'])    &&
             !empty($_POST['birthday']) )
          {
              $mql = new MysqlOperation($usr_base);
              $result = $mql->query("UPDATE {$table} SET
              name=\"{$_POST['name']}\", sex={$_POST['sex']},
              intro=\"{$_POST['intro']}\"  , phone=\"{$_POST['phone']}\",
              birthday=\"{$_POST['birthday']}\" where username=\"{$_POST['username']}\"");

              if($result){
                echo json_encode(array("status" => 200));
              }
          }
      }
  }
}
?>