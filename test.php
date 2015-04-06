<?php

require_once '../php-bg/BackgroundProcess.php';

echo date("M, d Y h:i:s A") . PHP_EOL;
$phpBG = new BackgroundProcess('php /var/www/html/php-bg/loop.php', '/home/a3logics/skype/abc.txt', '/home/a3logics/skype/xyz.txt');
$phpBG->execute();
echo date("M, d Y h:i:s A") . PHP_EOL;
