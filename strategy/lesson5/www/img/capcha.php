<?php
//��������� ������
session_start();
//������� ����������� �� 3-� ��������� ��������
$im=ImageCreateFromJpeg(round(mt_rand(1,3)).".jpg");
//���������� ���� �������
$color=ImageColorAllocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
//��������� �������, ��������� �����
ImageTtfText($im, 23, mt_rand(-5,5), 3, 30, $color, "addict.ttf",  $_SESSION['uid']);
//��������� ��� �����������
Header("Content-type: image/jpeg");
//������� � ������� �����������
ImageJpeg($im);
//��������� �����������
ImageDestroy($im);
?>