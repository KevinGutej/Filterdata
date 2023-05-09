<?php

if(!empty($_POST["user"]) && isset($_POST["user"])) {
    if(!empty($_POST["password"]) && isset($_POST["password"])) {
      $connection = new mysqli("localhost", "root" , "" , "system");
    if($connection->errorno == 0) {
        $userUsername = $_POST["user"];
      $userPassword = $_POST["password"];
      $sanitizedUsername = $connection->real_escape_string($userUsername);
      $sanitizedPassword = $connection->real_escape_string($userPassword);
      $sqlRequest = "SELECT username, password FROM user_accounts WHERE username = '$sanitizedUsername' AND password = '$sanitizedPassword'";";
      $result = $connection->query($sqlRequest);
      if($result->num_rows == 1) {
          header('location:success.php');
        exit();
            }else{
          header('location: loginForm.php');
      }
    }
  }
}
