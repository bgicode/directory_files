<?php
function СreatingList($arStuct)
{
    // стилизация полученного списка
    foreach ($arStuct as $folder => $content) {
        if (is_array($arStuct[$folder])) {
            // иконка папки с файлами для массивов 
            echo '<li class="folder"><div class="folderFileImg icon"></div><div class="name">' . $folder . '</div>
                <ul class="listWrap">';
                    СreatingList($content);
                echo '</ul>
            </li>';
        } elseif ($content == NULL) {
            // иконка пустой папки для массивов 
            echo '<li><div class="folderImg icon"></div><div class="name">' . $folder . '</div></li>';            
        } else {
            // иконка файла для не массивов
            echo '<li><div class="fileImg icon"></div><div class="name">' . $content . '</div></li>';
        }
    }
}
