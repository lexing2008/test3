<?php
// устраняем проблему с кодировкой
header('Content-type: text/html; charset=utf-8');

$data = array(
'Пароль: 3373
Спишется 1005,03р.
Перевод на счет 41001368283779',

'Пароль: 3373
Спишется 1005,03руб.
Перевод на счет 41001368283779',

'Пароль: 3373
Спишется 1005,03 р.
Перевод на счет 41001368283779',

'Пароль: 3373
Спишется 1005,03 руб.
Перевод на счет 41001368283779',
        
'Спишется 1005,03 р.
Перевод на счет 41001368283779
Пароль: 3373',
        
'Пароль: 337378
Перевод на счет 41001368283779
Спишется 1005.03р.',
    
'Пароль: 337378
Перевод на счет 41001368283779
Спишется 1005.03Р.',
);


function parse_sms($sms){
    $yandex = '';
    $summa = '';
    $password = '';
    
    // 1. выдергиваем кошелек
    $pattern = '#([0-9]{14})#i';
    $match = array();
    if (preg_match($pattern, $sms, $match)) {
        $yandex = $match[0];
    }
    
    // 2. выдергиваем сумму
    $pattern = '#([0-9\., ]+(руб.|р.|Р.|РУБ.|Руб.|RUB|RUR){1})#i';
    $match = array();
    if (preg_match($pattern, $sms, $match)) {
        $summa = trim($match[0]);
    }
    
    // 3. выдергиваем пароль
    // вначале стираем данные Яндекс кошелька и сумму в смс
    $sms = str_replace($yandex, '', $sms);
    $sms = str_replace($summa, '', $sms);
    
    $pattern = '#([0-9]+)#i';
    $match = array();
    if (preg_match($pattern, $sms, $match)) {
        $password = $match[0];
    }
        
    return array($password, $summa, $yandex);
}

echo '<pre>';
print_r($data);
echo '</pre>';


$size = count($data);
for($i=0; $i<$size; ++$i){
    $arr = parse_sms($data[$i]);
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}
