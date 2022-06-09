
<?php
$output = null;   
?>
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>test 1</title>
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

<div class="container mt-5">
<form class="mess" name="mess" id="mess" method="post" action="#">
<div class="col-12">
              <label for="username" class="form-label">Введите данные</label>
              <div class="input-group has-validation">
                <input type="text" name="name" class="form-control" value="<?= $name ?? "" ?>" id="username" placeholder="Введите данные в формате 2aaa'3'bbb'4'">
            
            
            </div>
            <div>
                <input type="submit" name="mess_submit" class="btn btn-success btn-block mt-2" value="Отправить">
            </div>
</form>
<?php
            
            
            if(isset($_POST["mess_submit"])){
                $name = $_POST["name"];
            preg_match_all("/'[0-9]'/", $name, $value);//поиск значений подходящих под регулярное выражение
$copy_value=$value[0]; //копирование значений
foreach($copy_value as &$number){
    $number=intval(trim($number, "'"))*2;//конвертация в int и умножение на 2
    $number="'".$number."'";//добавление кавычек
}
foreach ($value[0] as &$number) {
    $number = "/" . $number . "/";//преобразование в регулярное выражение
}
$output = preg_replace($value[0], $copy_value,$name);//замена значение по регулярному выражению
echo $output;
            }
        
        
        ?>      

<div class="container d-flex align-items-center m-5">
    <div class="col-12 text-center mt-5">

        <a href="index.php"><button type="button" class="btn btn-dark btn-lg btn-block m-1 mt-5">На главную</button></a>

    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>