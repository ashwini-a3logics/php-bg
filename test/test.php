<?php

require_once '../BackgroundProcess.php';

echo date("M, d Y h:i:s A") . PHP_EOL;
$phpBG = new BackgroundProcess('php /var/www/html/php-bg/test/loop.php', '/var/www/html/php-bg/test/abc.txt', '/var/www/html/php-bg/test/xyz.txt');
$phpBG->execute();
echo date("M, d Y h:i:s A") . PHP_EOL;
