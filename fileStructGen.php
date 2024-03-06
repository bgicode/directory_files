<?php
//путь к папке содержимое которой нужно отобразить
$path = __DIR__;

$hidenDir = false;

function InnerDir($path, $hidenDir)
{
    if ($hidenDir === false) {
        $pregForHidenDir = "/^(?!\.)^[^.]/";
    } else {
        $pregForHidenDir = "/[^.]/";
    }
    $arFileList = preg_grep($pregForHidenDir, scandir($path));
    $arInerDir = array();
    // переписываем массив для нумерации с 0
    foreach ($arFileList as $value) { 
        $arInerDir[] = $value;
    }
    return $arInerDir;
}

function FileDirPath($path, $hidenDir)
{
    if ($hidenDir === false){
        return glob($path . '/*');
    } else {
        return array_merge(glob($path . '/.*[!.,!..]',GLOB_MARK|GLOB_BRACE), glob($path . '/*'));
    }
}

function СreatingArray($direct, $listPath, $hidenDir)
{
    foreach ($direct as $key => $value) { // перребор и замена элементов первичного массива
        try {
            // попытка узнать содержимое вложенной директории
            $arNewDir = InnerDir($listPath[$key], $hidenDir);
            
            $arNewInerDir = array();
            foreach ($arNewDir as $value2) { //восстановление нумерации вложенной директории
                $arNewInerDir[] = $value2;
            }
            // повтор функии для вложенной директории
            $arDirect[$value] = СreatingArray($arNewInerDir, FileDirPath($listPath[$key], $hidenDir), $hidenDir); 
        } catch (Throwable $e) { 
            // попытка узнать содержимое элемента привела к ошибке значит это не папка
            // новый элемент файл
            $arDirect[] = $value;
        }
    }
    return $arDirect;
}