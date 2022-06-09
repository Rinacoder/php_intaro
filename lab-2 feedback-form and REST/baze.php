<?php

require "conect.php";
global $connection;

$id = 6;

$sth = $connection -> prepare("SELECT * FROM user");
$sth->execute();
$array = $sth -> fetchALL(PDO::FETCH_ASSOC);

//$stmt = "SELECT * FROM film";




?>
<table>

<tr>
  <th>id</th>
  <th>name</th>
  <th>email</th>
  <th>phone</th>
  <th>comment</th>
</tr>

  <?php 
  for ($i = 0; $i < count($array); $i++) {
    $id = $array[$i]['id'];
    $name = $array[$i]['name']  ;
    $email = $array[$i]['email']  ;
    $phone = $array[$i]['phone']  ;
    $comment = $array[$i]['comment'] ;
    print('<tr>
    <td>'.$id.'</td>
    <td>'.$name.'</td>
    <td>'.$email.'</td>
    <td>'.$phone.'</td>
    <td>'.$comment.'</td>
    </tr>');
}
  ?>


</table>