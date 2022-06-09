<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>test 2</title>
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

<div class="container mt-3">

    <div>
    <?php
$input = 'http://asozd.duma.gov.ru/main.nsf/(Spravka)?OpenAgent&RN=366426-7&11';//пример входных данных
echo  'Входные данные: '. '<br>'.$input . '<br>'. '<br>';
preg_match_all("/http:\/\/asozd.duma.gov.ru\/main.nsf\/\(Spravka\)\?OpenAgent&RN=[0-9]{1,10}[-][0-9]{1,10}&[0-9]{1,10}/",
$input, $value);//поиск значений подходящих под регулярное выражение
$copy_value=$value[0];//копирование значений
foreach($copy_value as &$element) {//преобразование копии в регулярное выражение
$element = str_replace("/", "\/", $element);
$element = str_replace("?", "\?", $element);
$element = str_replace("(", "\(", $element);
$element = str_replace(")", "\)", $element);
$element = "/" . $element . "/";
}
foreach ($value[0] as &$element) {
preg_match("/[0-9]{1,10}[-][0-9]{1,10}/", $element, $number);//поиск номера указа
$element="http://sozd.parlament.gov.ru/bill/" . $number[0];//создание новой ссылки
}
$output = preg_replace($copy_value, $value[0], $input);
echo  'Выходные данные: '. '<br>'.$output;
        ?>
    </div>
        <a href="index.php"><button type="button" class="btn btn-dark btn-lg btn-block m-4">На главную</button></a>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>