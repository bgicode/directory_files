<?php
function СreatingList($arStuct) {
    // стилизация полученного списка
    foreach ($arStuct as $folder => $content) {
        if (is_array($arStuct[$folder])
            || $content == NULL
        ) {
            // иконка папки для массивов 
            echo '<li class="folder"><div class="folderImg"></div><div class="name">' . $folder . '</div>
            <ul class="listWrap">';
            СreatingList($content);
            echo '</ul>
            </li>';
        } else {
            // иконка файла для не массивов
            echo '<li><div class="fileImg"></div><div class="name">' . $content . '</div></li>';
        }
    }
}
