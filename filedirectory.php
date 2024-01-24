<?php
    $path = __DIR__; //путь к папке содержимое которой нужно отобразить
    $fileList = array_diff( scandir($path), array( '..', '.' ) ); //список файлов и папок без . и .. массив начинается с 2
    $inerDir = array(); 
    foreach($fileList as $value) { // переписываем массив для нумерации с 0
        $inerDir[] = $value;
    }
    $fileListPath = glob($path.'/*'); // адресса всех файлов и папок в нужном директории
    
    function creatingArray(&$direct, $ListPath) {
        foreach($direct as $key => $value) { // перребор и замена элементов первичного массива
            try {
                $newDir = array_diff( scandir($ListPath[$key]), array( '..', '.' ) ); // попытка узнать содержимое вложенной директории
                $newInerDir = array();
                foreach($newDir as $value2) { //восстановление нумерации вложенной директории
                    $newInerDir[] = $value2;
                }
                creatingArray($newInerDir, glob($ListPath[$key].'/*')); //повтор функии для вложенной директории
                $direct[$value] = $newInerDir; // вложенная директория добовляется как элемент
                unset($direct[$key]); //удаление старого элемента

            } catch (Throwable $e) { // попытка узнать содержимое элемента привела к ошибке значит это не папка
                $direct[$value] = $value; // новый элемент файл
                unset($direct[$key]); //удаление старого элемента 
            }
        }
    }

    creatingArray($inerDir, $fileListPath); // запуск формирования списка файлов и подиректорий

    function creatinList($array){ //стилизация полученного списка
        foreach($array as $key => $value){
            if (is_array($array[$key])){ // иконка папки для массивов 
                echo '<li class="folder"><div class="folderImg"></div><div class="name">'.$key.'</div>
                <ul class="listWrap">';
                creatinList($value);
                echo '</ul>
                </li>';
            }else{ // иконка файла для не массивов
                echo '<li><div class="fileImg"></div><div class="name">'.$value.'</div></li>';
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
        creatinList($inerDir);
        echo '</div>'
    ?>
</body>
</html>
