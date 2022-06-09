<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Welcome!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


</head>
<body>
    <div class="container mt-5">
        <form name='form' class="row mt-5 form" method='POST'>
              <input class="form__input form__item col-4" type="text" id="adress" name="adress" placeholder="Введите адрес" required="required">
              <button class="btn submit btn-success btn-block col-3" id="submit" name="submit">Найти ближайшее метро</button>
            <label for="adress" class="form_comment form__item text-muted">Если введенное значение не является адресом, информация не будет выведена</label>

        </form>
        <div class="result close" id="result">
            <div class="result_message form__label form__item" id="result_message">
            </div>
        </div>
        <a href="index.php"><button type="button" class="btn btn-dark btn-lg btn-block m-1 mt-5">На главную</button></a>

    </div>
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="front.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>