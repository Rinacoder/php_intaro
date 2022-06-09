$('.submit').click(function(e){
    e.preventDefault();
    var adress = document.form.adress.value;

    $.ajax({
        url: 'ApiController.php',
        type: 'GET',
        dataType: 'json',
        data: {
            adress: adress,
        },
        success(data) { // Если success, вывести полученные данные
            $('.result').removeClass('close').addClass(' open');
            $('.result_message').empty();    
            data.data.forEach(message => {
                $('.result_message').addClass('open').append(message);
                $('.result_message').append("<br>");
            });
        }
    })
});