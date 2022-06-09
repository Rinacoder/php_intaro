<?php
$array_info = parse_ini_file('config/parameters.ini', true);
$main_info = 'mysql:host='.$array_info['host'].';dbname='.$array_info['name'];
    $login = $array_info['login'];
    $password = $array_info['password'];
    //print_r ($array_info);
    $connection = null;
    
 //= new PDO($main_info, $login,  $password);
try 
		{
			$connection = new PDO($main_info, $login, '');
		}
		 catch (PDOException $e) 
		{
			print "Has errors: " . $e->getMessage(); die();
		}

?>