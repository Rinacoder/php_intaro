<?php

//функция рассчета количества показов, записи id и последнего показа
//получает входные данные
//возвращает строку в которую через пробел записаны число показов, идентификатор, дата и
//время последнего показа
function getResult($file_path){
    $read=fopen($file_path, 'r');
    $all_banners_data=array();
    $banners_num=0;
    $result="";

    while(!feof($read)){
        $str=trim(fgets($read), " \n\r"); //считываем 1 строку
        if(!empty($str)){
            $banner_data=explode("\t",$str);
            $banner_id=$banner_data[0];
            $banner_datetime=explode(" ", $banner_data[1]);
            $mark=0;
            foreach($all_banners_data as &$banner){ 
                if($banner['id']==$banner_id){      //если баннер уже есть в массиве
                    $banner['count']++;
                    $another_datetime=$banner['datetime'][0]." ".$banner['datetime'][1];
                    if($banner_datetime>$another_datetime){     //если время больше чем имеющееся
                        $banner['datetime']=$banner_datetime; //обновляем
                    }
                    $mark=1;
                }
            }
            if($mark==0){               //если баннера еще не было в массиве
                $all_banners_data[$banners_num]['count']=1;
                $all_banners_data[$banners_num]['id']=$banner_id;
                $all_banners_data[$banners_num]['datetime']=$banner_datetime;
                $mark=1;
                $banners_num++;
            }
        }
    }
    //записываем результат
    foreach($all_banners_data as &$banner){
        $result.=$banner['count']." ".$banner['id']." ".$banner['datetime'][0]." ".$banner['datetime'][1]."\n";
    }
    return $result;
}