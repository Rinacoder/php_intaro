<?php
require "conect.php";
require "function/new.php";

if (isset($_POST["mess_submit"]))
{
	$name = $_POST["name"];
	$email = $_POST["email"];
	$tel = $_POST["tel"];
	$comm = $_POST["comm"];
    

    $user = fetchUserByEmail($connection, $email); // Запись пользователя если уже была отправка с данной почты


    if(!$user) //если данного пользователя нет в бд
    {
        storeMess($connection, $name, $email, $tel, $comm);
        ?>
            <div class="alert alert-success" role="alert">
            Форма успешно отправлена
            </div>
        <?php
    }
    else
    {
      // если есть но прошло больше 90 минут
        if((strtotime(date("Y-m-d H:i:s")) - strtotime($user["datetime"])) / 60 > 90)
        {
            storeMess($connection, $name, $email, $tel, $comm);
            ?>
            <div class="alert alert-success" role="alert">
            Форма успешно отправлена
            </div>
        <?php
        }
        else //если с момента отправки прошло меньше 90 минут
        {
            ?>
        <div class="alert alert-danger" role="alert">
  Подождите еще <?php echo 90 - (strtotime(date("Y-m-d H:i:s")) - strtotime($user["datetime"])) / 60 ?> минут до повторной отправки
</div>
        <?php
        }
    }
    
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">


</head>
<body>


<div class="container mt-5">
<form class="mess" name="mess" id="mess" method="post" action="#">
            <div class="col-12">
              <label for="username" class="form-label">ФИО пользователя</label>
              <div class="input-group has-validation">
                <input type="text" name="name" class="form-control" value="<?= $name ?? "" ?>" id="username" placeholder="ФИО пользователя" required="">
              <div class="invalid-feedback">
                  ФИО пользователя обязательно.
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Эл. адрес </label>
              <input type="email" name="email" class="form-control" value="<?= $email ?? "" ?>" id="email" placeholder="you@example.com" required>
              <div class="invalid-feedback">
                Пожалуйста, введите действующий адрес электронной почты.
              </div>
            </div>

            <div class="col-12">
              <label for="phone" class="form-label">Телефон</label>
              <input type="text" class="form-control" name="tel" value="<?= $tel ?? "" ?>" id="phone" placeholder="89002003344" required pattern="[0-9]{11}" title="Введите номер телефона. 11 цифр без тире и пробелов">
              <div class="invalid-feedback">
                Пожалуйста, введите номер телефона.
              </div>
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Комментарий </label>
              <textarea class="form-control" name="comm" value="<?= $comm ?? "" ?>" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div>
                <input type="submit" name="mess_submit" class="btn btn-success btn-block mt-2" value="Отправить">
            </div>
            <div>
            <a href="index.php"><button type="button" class="btn btn-dark btn-block m-1 mt-5">На главную</button></a>

            </div>
            
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>