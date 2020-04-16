<?php
date_default_timezone_set('America/Argentina/San_luis');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf_8', 'portuguese');

//constantes gerais
define('DAILY_TIME', 60 * 60 * 8);

//pastas
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../models'));
define('VIEW_PATH', realpath(dirname(__FILE__) . '/../views'));
define('TEMPLATE_PATH', realpath(dirname(__FILE__) . '/../views/template'));
define('CONTROLLER_PATH', realpath(dirname(__FILE__) . '/../controllers'));
define('EXCEPTION_PATH', realpath(dirname(__FILE__) . '/../exceptions'));


//arquivos
require_once(realpath(dirname(__FILE__) . '/database.php'));
require_once(realpath(dirname(__FILE__) . '/loader.php'));
require_once(realpath(dirname(__FILE__) . '/session.php'));
require_once(realpath(dirname(__FILE__) . '/date_utils.php'));
require_once(realpath(dirname(__FILE__) . '/utils.php'));
require_once(realpath(MODEL_PATH . '/model.php'));
require_once(realpath(MODEL_PATH . '/user.php'));
require_once(realpath(MODEL_PATH . '/workinghours.php'));
require_once(realpath(EXCEPTION_PATH . '/AppException.php'));
require_once(realpath(EXCEPTION_PATH . '/ValidationException.php'));


 ?>
