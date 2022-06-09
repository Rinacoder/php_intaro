<?php
// Отправка данных в бд
function storeMess(object $connection,string $name,string $email,string $tel,string $comm):void
{
    $sql = "INSERT INTO `user`(`name`, `email`, `phone`, `comment`, `datetime`) VALUES (:name,:email,:tel,:comm,:dt)";

	$params = [
		"name" => $name,
		"email" => $email,
		"tel" => $tel,
		"comm" => $comm,
		"dt" => date("Y-m-d H:i:s")
	];  
	$connection->prepare($sql)->execute($params);
	
}

//Проверка на наличие email в бд
function fetchUserByEmail(object $connection, string $email)
{
    $sql = "SELECT * FROM user WHERE email = :email";
	$params =["email" => $email];

	$fetchUser = $connection->prepare($sql);
	$fetchUser->execute($params);
	return $user = $fetchUser->fetch(PDO::FETCH_ASSOC);
    
}

?>