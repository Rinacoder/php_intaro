<?php

/*
Функция минимизации CSS в соответствии с заданием
file_path - путь к файлу, который необходимо минимизировать
Возвращает строку
*/
function getResult($file_path){
    $hexes = ["#CD853F",'#FFC0CB','#DDA0DD','#FF0000','#FFFAFA','#D2B48C']; //Массив 16ричных значений цветов
    $colors = ["peru", "pink", "plum", "red","snow", "tan"]; //Массив названий HTML цветов
    $file=fopen($file_path, 'r'); //открываем файл на чтение
    $is_in_comment = false; //специальный флаг, который определяет находимся ли мы сейчас в комментарии
    $result = ""; //строка-результат

    $text = file_get_contents($file_path); //считываем весь текст в одну строку

    $text = str_replace([": 0px", ":0px"], ":0", $text); //заменяем все 0px на 0
    $text = str_replace([" 0px"], " 0", $text); //заменяем все 0px на 0
    //Убираем лишние ;
    $text = preg_replace('/;}/', "}", $text);
    // удаляем строки начинающиеся с //
    $text = preg_replace('#//.*#','',$text);
    // удаляем многострочные комментарии /* */
    $text = preg_replace('#/\*(?:[^*]*(?:\*(?!/))*)*\*/#','',$text);
    $text = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $text); //убираем все пробелы, табуляцию и переводы строки
    $text = str_replace(': ', ':', $text); //убираем все пробелы, табуляцию и переводы строки
    $text = str_replace('; ', ';', $text); //убираем все пробелы, табуляцию и переводы строки
    $text = str_replace(' {', '{', $text); //убираем все пробелы, табуляцию и переводы строки
    $text = str_replace(' > ', '>', $text); //убираем все пробелы, табуляцию и переводы строки
    $text = str_replace([' , ', ', '], ',', $text); //убираем все пробелы, табуляцию и переводы строки
    $text = preg_replace('/[#.]?[a-zA-Z0-9]{1,10}>?[#.]?[a-zA-Z0-9]{1,10}{}/', "", $text); //Удаляем все пустые стили.
    $text = str_replace($hexes, $colors, $text); //Заменяем все заранее заготовленные 16ричные цвета на соответствующие HTML цвета
    //Если в 16ричном представление цвета символы в каждом из трёх разрядов по два символа совпадают, то сокращаем до трёх разрядов по одному символу
    preg_match_all('/#([0-9A-z])[0-9A-z]([0-9A-z])[0-9A-z]([0-9A-z])[0-9A-z]/', $text, $color_arr);
    $color_arr=$color_arr[0];
    $col_patterns=$color_arr;
    foreach ($col_patterns as &$col){       //шаблон для замены
        $col="/".$col."/";
    }
    foreach ($color_arr as &$col){
        $new_col="#";
        for($i=1;$i<strlen($col)-1;$i+=2){      //пропускается # и даль проверяется через элемент
            if($col[$i]==$col[$i+1]){
                $new_col.=$col[$i];
            }
        }
        if(strlen($new_col)==4){
            $col=$new_col;
        }
    }
    $text=preg_replace($col_patterns, $color_arr, $text);       //замена цветов
    //работаем с содержимым кавычек
    preg_match_all('/{([^}]*)}/', $text, $brackets_arr);
    $brackets_arr=$brackets_arr[1];
    $reg_patterns=$brackets_arr;
    foreach($reg_patterns as &$pattern){        //шаблон для замены
        $pattern='/'.$pattern.'/';
    }
    foreach($brackets_arr as &$arr){
        if(preg_match('/margin-top:(-?[0-9]{1,10}p?x?)/',$arr, $matches_1)){        //проверка на существование таких стилей
            $matches_1=$matches_1[1];
        }else{$matches_1=NULL;}
        if(preg_match('/margin-right:(-?[0-9]{1,10}p?x?)/',$arr, $matches_2)){
            $matches_2=$matches_2[1];
        }else{$matches_2=NULL;}
        if(preg_match('/margin-bottom:(-?[0-9]{1,10}p?x?)/',$arr, $matches_3)){
            $matches_3=$matches_3[1];
        }else{$matches_3=NULL;}
        if(preg_match('/margin-left:(-?[0-9]{1,10}p?x?)/',$arr, $matches_4)){
            $matches_4=$matches_4[1];
        }else{$matches_4=NULL;}
        if(strpos($arr, 'margin')!==false){
            $arr=substr_replace($arr, 'margin:margin',strpos($arr, 'margin'), strlen('margin'));        //махинации для нормальной замены в дальнейшем
        }
        $arr=preg_replace('/margin-top:(-?[0-9]{1,10}p?x?;?)/', '', $arr);          //удаление улик
        $arr=preg_replace('/margin-right:(-?[0-9]{1,10}p?x?;?)/', '', $arr);
        $arr=preg_replace('/margin-bottom:(-?[0-9]{1,10}p?x?;?)/', '', $arr);
        $arr=preg_replace('/margin-left:(-?[0-9]{1,10}p?x?;?)/', '', $arr);
        $end_match="";
        if(isset($matches_1)&&isset($matches_2)&&isset($matches_4)&&isset($matches_3)){         //есть все стили
            if($matches_1==$matches_2&&$matches_3==$matches_4&&$matches_1==$matches_3&&$matches_2==$matches_4){ //одинаковый отступ везде
                $arr=preg_replace('/margin:/', 'margin:'.$matches_1.';', $arr);
            }
            else if($matches_1==$matches_3&&$matches_2==$matches_4){    //по вертикали и горизонтали
                $arr=preg_replace('/margin:/', 'margin:'.$matches_1.' '.$matches_2.';', $arr);
            }
            else if($matches_1!=$matches_3&&$matches_2==$matches_4){    //сверху, по горизонтали и снизу
                $arr=preg_replace('/margin:/', 'margin:'.$matches_1.' '.$matches_2.' '.$matches_3.';', $arr);
            }
            else{
                $arr=preg_replace('/margin:/', 'margin:'.$matches_1.' '.$matches_2.' '.$matches_3.' '.$matches_4.';', $arr);    //все 4 отступа разные
            }
        }
        else if(!isset($matches_1)&&!isset($matches_2)&&!isset($matches_4)&&!isset($matches_3)){        //нет ни одного стиля
            $arr=preg_replace('/margin:margin:/', 'margin:', $arr);
        }
        else {      //стили есть, но в разнобой
            $arr=preg_replace('/margin:margin:/', 'margin:', $arr);
            if(isset($matches_1)){
                $end_match.='margin-top:'.$matches_1.';';
            }
            if(isset($matches_2)){
                $end_match.='margin-right:'.$matches_2.';';
            }
            if(isset($matches_3)){
                $end_match.='margin-bottom:'.$matches_3.';';
            }
            if(isset($matches_4)){
                $end_match.='margin-left:'.$matches_4.';';
            }
            $arr=preg_replace('/margin:/', $end_match, $arr);
        }
    }
    foreach ($brackets_arr as &$arr){       //см для марджинов, там то же самое
        if(preg_match('/padding-top:(-?[0-9]{1,10}p?x?)/',$arr, $matches_1)){
            $matches_1=$matches_1[1];
        }else{$matches_1=NULL;}
        if(preg_match('/padding-right:(-?[0-9]{1,10}p?x?)/',$arr, $matches_2)){
            $matches_2=$matches_2[1];
        }else{$matches_2=NULL;}
        if(preg_match('/padding-bottom:(-?[0-9]{1,10}p?x?)/',$arr, $matches_3)){
            $matches_3=$matches_3[1];
        }else{$matches_3=NULL;}
        if(preg_match('/padding-left:(-?[0-9]{1,10}p?x?)/',$arr, $matches_4)){
            $matches_4=$matches_4[1];
        }else{$matches_4=NULL;}
        if(strpos($arr, 'padding')!==false){
            $arr=substr_replace($arr, 'padding:padding',strpos($arr, 'padding'), strlen('padding'));
        }
        $arr=preg_replace('/padding-top:(-?[0-9]{1,10}p?x?;?)/', '', $arr);
        $arr=preg_replace('/padding-right:(-?[0-9]{1,10}p?x?;?)/', '', $arr);
        $arr=preg_replace('/padding-bottom:(-?[0-9]{1,10}p?x?;?)/', '', $arr);
        $arr=preg_replace('/padding-left:(-?[0-9]{1,10}p?x?;?)/', '', $arr);
        $end_match="";
        if(isset($matches_1)&&isset($matches_2)&&isset($matches_4)&&isset($matches_3)){
            if($matches_1==$matches_2&&$matches_3==$matches_4&&$matches_1==$matches_3&&$matches_2==$matches_4){
                $arr=preg_replace('/padding:/', 'padding:'.$matches_1.';', $arr);
            }
            else if($matches_1==$matches_3&&$matches_2==$matches_4){
                $arr=preg_replace('/padding:/', 'padding:'.$matches_1.' '.$matches_2.';', $arr);
            }
            else if($matches_1!=$matches_3&&$matches_2==$matches_4){
                $arr=preg_replace('/padding:/', 'padding:'.$matches_1.' '.$matches_2.' '.$matches_3.';', $arr);
            }
            else{
                $arr=preg_replace('/padding:/', 'padding:'.$matches_1.' '.$matches_2.' '.$matches_3.' '.$matches_4.';', $arr);
            }
        }
        else if(!isset($matches_1)&&!isset($matches_2)&&!isset($matches_4)&&!isset($matches_3)){
            $arr=preg_replace('/padding:padding:/', 'padding:', $arr);
        }
        else {
            $arr=preg_replace('/padding:padding:/', 'padding:', $arr);
            if(isset($matches_1)){
                $end_match.='padding-top:'.$matches_1.';';
            }
            if(isset($matches_2)){
                $end_match.='padding-right:'.$matches_2.';';
            }
            if(isset($matches_3)){
                $end_match.='padding-bottom:'.$matches_3.';';
            }
            if(isset($matches_4)){
                $end_match.='padding-left:'.$matches_4.';';
            }
            $arr=preg_replace('/padding:/', $end_match, $arr);
        }
    }
    $text=preg_replace($reg_patterns, $brackets_arr, $text);        //замена по шаблону
    
    $text = preg_replace('/;}/', "}", $text); //После всех манипуляций могут остаться лишние ; Убираем их
    //После всех манипуляций могут остаться пустые стили. Удаляем их.
    $text = preg_replace('/[#.]?[a-zA-Z0-9]{1,10}>?[#.]?[a-zA-Z0-9]{1,10}{}/', "", $text);
    $text = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $text); //убираем все пробелы, табуляцию и переводы строки
    return $text;
}
