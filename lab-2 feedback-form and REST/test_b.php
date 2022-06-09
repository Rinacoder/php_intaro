<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>test B</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">


</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Tenth navbar example">
<div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarsExample08">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="test_1.php">Задание 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="test_2.php">Задание 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="test_b.php">Задание B</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="test_c.php">Задание C</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container ">
<a href="index.php"><button type="button" class="btn btn-dark btn-lg btn-block m-1 m-3">На главную</button></a>

<?php
function task_b($ip){
    $result="";
    $all_blocks_amount=8;
    $full_blocks_amount=0;
    $first_check_ip=explode("::",$ip);//определение участков с ::
    foreach($first_check_ip as $second_check_ip){
        $blocks=explode(":",$second_check_ip);
        $full_blocks_amount+=count($blocks); //количество блоков без ::
    }
    $empty_blocks_amount=$all_blocks_amount-$full_blocks_amount;//пустые блоки
    if($ip[0]==":" && $ip[1]==":"){//заполнение ip при :: в начале адреса
        for($i=0;$i<$empty_blocks_amount;$i++){
            $result.="0000:";
        }
        $empty_blocks_amount=0;
    }
    foreach($first_check_ip as $second_check_ip){//заполнение недостающими нулями
        $blocks=explode(":",$second_check_ip);
        foreach($blocks as $block){
            for($i=0;$i<(4-strlen($block));$i++){ //количество недостающих блоком суммируем
                $result.="0";
            }
            $result.=$block.":";
        }
        while($empty_blocks_amount>0){
            $result.="0000:";
            $empty_blocks_amount--;
        }
    }
    $result=substr($result, 0, -1);
    return $result;
}
$inputData = glob('B/*.dat');//загрузка файлов с входными данными
$inputAns = glob('B/*.ans');//загрузка файлов с ответами
$num=1;//счетчик теста
foreach(array_combine($inputData,$inputAns) as $input => $output){//создание массива с ключами data и данными ans
    $task_input = fopen($input, 'r');//запись отдельного задания и ответа
    $task_answer = fopen($output, 'r');
    while((!feof($task_answer)) && (!feof($task_input))){//проверка на достижение конца файла
        $input_r = trim(fgets($task_input), " \n\r\t");//запись строки входных данных
        $answer = trim(fgets($task_answer), " \n\r\t");//запись строки ответа
        if(!empty($input_r) && !empty($answer)){//вывод результата проверки
            echo "<br>Входные данные: $input_r<br>";
            $result = task_b($input_r);
            echo "<br>Тест $num: ";
            if ($answer == $result) {
                echo "Ок<br>";
            } else {
                echo "Ошибка<br>Верный ответ: $answer<br>Ответ программы: $result<br>";
            }
        }
    }
    $num++;
}
?>
    

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>