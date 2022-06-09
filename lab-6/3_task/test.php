<?php
require_once "task.php";
// Считываем данные тестов
$inputFiles = glob('data/*.dat');
$outputFiles = glob('data/*.ans');
$num=1;
foreach(array_combine($inputFiles,$outputFiles) as $input => $output) {
    $read = fopen($output, 'r');
    $right_answer="";
    while(!feof($read)){
        $str = trim(fgets($read), " \r");   //считываем правильный ответ и обрезаем перенос каретки
        if(!empty($str)){
            $right_answer.=trim($str,"\r\t");
        } 
    }
    $prog_answer = getResult($input); //получаем результат программы
    echo "\nТест $num: \n";
    echo "Верный ответ:\n$right_answer\nОтвет программы:\n$prog_answer\n";
    // break;

    $num++;
}