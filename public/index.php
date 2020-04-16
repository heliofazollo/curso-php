<?php
require_once(dirname(__FILE__, 2) . '/src/config/config.php');
//require_once(CONTROLLER_PATH . '/login.php');

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if ($uri === '/' || $uri === '' || $uri === '/index.php') {
  $uri = '/day_records.php';
}

require_once(CONTROLLER_PATH . "/{$uri}");






/*require_once(MODEL_PATH . '/login.php');

$login = new Login([
  'email' => 'chaves@cod3r.com.br',
  'password' => 'a'
]);

  try {
    $login->checkLogin();
    echo "deu certo";
  } catch (Exception $e) {
    echo "problema no login";
  }*/


 ?>
