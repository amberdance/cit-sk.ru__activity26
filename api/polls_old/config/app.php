<?php

$_ENV['APP_URL'] = $_ENV['APP_DEBUG'] ? 'http://regional-polls' : 'https://polls.stavregion.ru';

define('UPLOADS_DIR', $_SERVER['DOCUMENT_ROOT'] . '/uploads');
define('TMP_DIR', UPLOADS_DIR . '/tmp/');
