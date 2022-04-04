<?php

function calculate($fileName): int // Функция рассчета баланса
{
    $input = fopen($fileName, 'r');
    $number_bets = fgets($input); // Количество ставок
    $balance = 0; //Заведение переменной для баланса
    $bets = array(); // Заведение переменной для хранения ставок
    for ($i = 0; $i < $number_bets; $i++) {
        // Считывание строки с идетнефикатором ставки, ставкой и выбранным результатом :
        list($bets_id_game, $bets_sum, $bets_result) = explode(" ", fgets($input)); 
        $bets_result = trim($bets_result); // Удаления пробелов из начала и конца строки
        $bets[$bets_id_game][$bets_result]=$bets_sum; 
        $balance -=$bets_sum;
    }
    $number_game = fgets($input); // Количество игр
    for ($i = 0; $i < $number_game; $i++) {
        // Считывание строки с идентификатором игры, коэффициентами ставок и результатом :
        list($game_id, $game_coeff_left, $game_coeff_right, $game_coeff_draw, $game_result) = explode(" ", fgets($input)); 
        $game_result = trim($game_result); // Удаления пробелов из начала и конца строки
        if (isset($bets[$game_id][$game_result])) {
            $winning = $bets[$game_id][$game_result];
            switch ($game_result) {
                case 'L':
                    $winning *= $game_coeff_left;
                    break;
                case 'R':
                    $winning *= $game_coeff_right;
                    break;
                case 'D':
                    $winning *= $game_coeff_draw;
                    break;
            }
            $balance += $winning; // Переприсвоение переменной отвечающей за баланс игрока 
        }
    }
    return $balance; // Возврафт функцией баланса игрока
}
function task_A($inputData, $inputAns) // Функция
{
    echo ("Результаты тестов:".PHP_EOL);
    for ($i = 0; $i < sizeof($inputData); $i++) {
        $output = fopen($inputAns[$i], 'r');
        $answer = fgets($output);
        $result = calculate($inputData[$i]);
        echo(($i + 1). ' Тест'. PHP_EOL);
        if ($answer == $result) {
            echo ('Ответ совпал'.PHP_EOL);
        } else {
            echo ('Ошибка'.PHP_EOL);
        }
        echo('Рассчеты программы: ' . $result.PHP_EOL . 'Правильный ответ: ' . $answer . PHP_EOL);
    }
}

task_A(glob('A/*.dat'), glob('A/*.ans'));