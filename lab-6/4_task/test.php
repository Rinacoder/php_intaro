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
            $right_answer.=trim($str,"\r\t\n")."\n";
        } 
    }
    // if($num==6){
    $prog_answer = getResult($input); //получаем результат программы
    $prog_answer=trim($prog_answer,"\r\t\n");
    $right_answer=trim($right_answer,"\r\t\n");
    echo "\nТест $num: \n";
    if ($right_answer == $prog_answer) { //сравниваем правильный и полученный результаты
        echo "Ок\n";
        echo "Верный ответ: \n$right_answer\nОтвет программы: \n$prog_answer\n";
    } else {
        echo "Ошибка\nВерный ответ: \n$right_answer\nОтвет программы: \n$prog_answer\n";
        echo similar_text($right_answer, $prog_answer)."\n";
    }
// }
    // break;
    $num++;
}
?>