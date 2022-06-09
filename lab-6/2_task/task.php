<?php
if($argc>1){
    // var_dump($argv);
    $file=$argv[1];
    getResult($file);
}

function findRoots($all_data){
    $lvl=0;         //уровни дерева
    $num=1;         //счетчик прохода дерева
    $result_count=0;      //массив использованных вершин
    $result="";                 //строка с результатом
    while(count($all_data)!=$result_count){  //пока не используем все узлы дерева
        foreach($all_data as $data){        //проходимся по всем узлам
            if($data[2]==$num){             //если счетчик совпал с порядком вхождения в узел
                $result.=str_repeat("-", $lvl);         //выводим нужное кол-во "-"
                $result.=$data[1]."\n";                 //выводим сам узел
                $result_count++;       //добавляем узел в использованные
                $lvl++;                 //опускаемся на уровень ниже
                $num++;                 //увеличиваем счетчик
                break;
            }
            else if($data[3]==$num){             //если счетчик совпал с порядком выхода из узла
                $lvl--;                            //поднимаемся на уровень дерева выше
                $num++;                             //увеличиваем счетчик
                break;
            }
        }
    }
    return $result;
}

function getResult($file_path){
    error_reporting(E_ERROR | E_PARSE);
    $read=fopen($file_path, 'r');       //открываем файл
    $all_data=array();

    while(!feof($read)){
        $str=trim(fgets($read), " \n\r"); //считываем 1 строку
        if(!empty($str)){
            $node_data=explode(" ",$str);
            array_push($all_data, $node_data); //переносим все данные в общий массив
        }
    }
    $result=findRoots($all_data);
    return $result;
}