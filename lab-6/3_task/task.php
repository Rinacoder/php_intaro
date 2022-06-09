<?php

//работает по принципу прямой с отрезками разного размера. больше вероятность - больше отрезок
function findStatistics($all_data){
    $stat_array=array();
    foreach($all_data as $data){
        for($i=0;$i<$data[1];$i++){
            array_push($stat_array, $data[0]);  //заполняем массив-прямую верятностными отрезками
        }
    }
    for($i=0;$i<pow(10, 6); $i++){  //эмулируем показ n баннеров
        $rand_int=rand(0, count($stat_array));  //выбираем случайное число
        // echo $stat_array[$rand_int]."\n";
        $banner_id=$stat_array[$rand_int];  //получаем значение отрезка в диапазоне, куда попало число
        foreach($all_data as &$data){   //поиск по начальным данным
            // echo $banner_id." ".$data[0]."\n";
            if($banner_id==$data[0]){   //находим нужный баннер - увеличиваем кол-во показов
                $data[2]++;
            }
        }
    }
    foreach($all_data as &$data){
        $data[2]=(float)$data[2]/pow(10, 6);    //считаем саму статистику для каждого баннера
    }
    return $all_data;
}

function getResult($file_path){
    error_reporting(E_ERROR | E_PARSE);
    $read=fopen($file_path, 'r');       //открываем файл
    $all_data=array();

    while(!feof($read)){
        $str=trim(fgets($read), " \n\r"); //считываем 1 строку
        if(!empty($str)){
            $node_data=explode(" ",$str);
            $node_data[2]=0;
            array_push($all_data, $node_data); //переносим все данные в общий массив
        }
    }
    $result_arr=findStatistics($all_data);
    // var_dump($result_arr);
    $result='';
    foreach($result_arr as $res){   //вывод
        $result.=$res[0].' '.$res[2]."\n";
    }
    return $result;
}
