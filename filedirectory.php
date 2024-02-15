<?php
$path = __DIR__; //путь к папке содержимое которой нужно отобразить
$arFileList = array_diff( scandir($path), array( '..', '.' ) ); //список файлов и папок без . и .. массив начинается с 2
$arInerDir = array(); 
foreach ($arFileList as $value) { // переписываем массив для нумерации с 0
    $arInerDir[] = $value;
}
$arFileListPath = glob($path . '/*'); // адресса всех файлов и папок в нужном директории

function СreatingArray(&$direct, $listPath) {
    foreach ($direct as $key => $value) { // перребор и замена элементов первичного массива
        try {
            $arNewDir = array_diff( scandir($listPath[$key]), array( '..', '.' ) ); // попытка узнать содержимое вложенной директории
            $arNewInerDir = array();
            foreach ($arNewDir as $value2) { //восстановление нумерации вложенной директории
                $arNewInerDir[] = $value2;
            }
            СreatingArray($arNewInerDir, glob($listPath[$key] . '/*')); //повтор функии для вложенной директории
            $direct[$value] = $arNewInerDir; // вложенная директория добовляется как элемент
            unset($direct[$key]); //удаление старого элемента

        } catch (Throwable $e) { // попытка узнать содержимое элемента привела к ошибке значит это не папка
            $direct[$value] = $value; // новый элемент файл
            unset($direct[$key]); //удаление старого элемента 
        }
    }
}

СreatingArray($arInerDir, $arFileListPath); // запуск формирования списка файлов и подиректорий

function СreatinList($array) { //стилизация полученного списка
    foreach ($array as $key => $value) {
        if (is_array($array[$key])) { // иконка папки для массивов 
            echo '<li class="folder"><div class="folderImg"></div><div class="name">' . $key . '</div>
            <ul class="listWrap">';
            СreatinList($value);
            echo '</ul>
            </li>';
        } else { // иконка файла для не массивов
            echo '<li><div class="fileImg"></div><div class="name">' . $value . '</div></li>';
        }
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Directory Map</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1><?=$path?></h1>
    <?php
        echo '<div class="DirectoryMap">';
        СreatinList($arInerDir);
        echo '</div>'
    ?>
</body>
</html>
