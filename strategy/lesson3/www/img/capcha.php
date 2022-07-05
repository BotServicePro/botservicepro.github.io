<?php
//Запускаем сессию
session_start();
//Создаем изображение из 3-х возможных подложек
$im=ImageCreateFromJpeg(round(mt_rand(1,3)).".jpg");
//Генерируем цвет надписи
$color=ImageColorAllocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
//Формируем надпись, используя шрифт
ImageTtfText($im, 23, mt_rand(-5,5), 3, 30, $color, "addict.ttf",  $_SESSION['uid']);
//Указываем тип содержимого
Header("Content-type: image/jpeg");
//Создаем и выводим изображение
ImageJpeg($im);
//Разрушаем изображение
ImageDestroy($im);
?>