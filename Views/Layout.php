<?php


namespace Views;


class Layout
{
    public static function Header(string $title, array $css = [])
    {
        ?>
        <!doctype html>
        <html lang="ru">
        <head>
            <meta charset="utf-8">
            <title><?= $title ?></title>
            <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="/Css/style.css">
            <?php
            if (!empty($css)) : ?>
                <?php
                foreach ($css as $c): ?>
                    <link rel="stylesheet" href="<?= $c ?>">
                <?php
                endforeach; ?>
            <?php
            endif; ?>
        </head>
        <body>
        <?php
    }

    public static function Footer(array $js = [])
    {
        ?>
        <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="/node_modules/vue/dist/vue.global.js"></script>
        <script src="/Js/script.js"></script>
    <?php
    if (!empty($js)) : ?>
    <?php
    foreach ($js

    as $j): ?>
        <script src="<?= $j ?>"></script>
    <?php
    endforeach; ?>
    <?php
    endif; ?>
        </body>
        </html>
        <?php
    }
}