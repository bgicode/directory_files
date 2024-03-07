<?php
include_once('fileStruct.php');
include_once('fileStructGen.php');
include_once('renderList.php');

if ($_GET["target"] == 'dir') {

    if(isset($_GET["path"])) {
        $path = $_GET["path"];
    }
    
    if ($_GET["hiden"] == 'true') {
        $hidenDir = true;
    } else {
        $hidenDir = false;
    }

    $arInerDir = InnerDir($path, $hidenDir);

    // адресса всех файлов и папок в нужном директории
    $arFileListPath = FileDirPath($path, $hidenDir);

    // запуск формирования списка файлов и подиректорий
    $arAllStruct = СreatingArray($arInerDir, $arFileListPath, $hidenDir); 
} else {
    $arAllStruct = $arPreStruct;
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
        СreatingList($arAllStruct);
        echo '</div>'
    ?>
</body>
</html>
