<?php

function requireValidSession($requireAdmin = false) {
  $user = $_SESSION['user'];
  if (!isset($user)) {
    header('Location: login.php');
    exit();
  }elseif ($requireAdmin && !$user->is_admin) {
    addErrorMsg('Acesso negado');
    header('Location: day_records.php');
    exit();
  }
}




 ?>
