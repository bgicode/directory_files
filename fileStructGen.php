<?php
//путь к папке содержимое которой нужно отобразить
$path = __DIR__;
$hidenDir = false;

// получение списка файлов и директорий с возможность получить сркытые
function InnerDir($path, $hidenDir)
{
    if ($hidenDir === false) {
        $pregForHidenDir = "/^(?!\.)^[^.]/";
    } else {
        $pregForHidenDir = "/[^.]/";
    }

    $arFileList = preg_grep($pregForHidenDir, scandir($path));
    $arInerDir = [];

    // переписываем массив для нумерации с 0
    foreach ($arFileList as $value) {
        $arInerDir[] = $value;
    }
    return $arInerDir;
}

// получение путей папок и директорий
function FileDirPath($path, $hidenDir)
{
    if ($hidenDir === false){
        return glob($path . '/*');
    } else {
        return array_merge(glob($path . '/.*[!.,!..]', GLOB_MARK|GLOB_BRACE), glob($path . '/*'));
    }
}

// получение структуры выбранной директории
function СreatingArray($direct, $listPath, $hidenDir)
{
    // перебор и замена элементов первичного массива
    foreach ($direct as $key => $value) {
        try {
            // попытка узнать содержимое вложенной директории
            $arNewDir = InnerDir($listPath[$key], $hidenDir);
            $arNewInerDir = [];
            // восстановление нумерации вложенной директории
            foreach ($arNewDir as $value2) {
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
