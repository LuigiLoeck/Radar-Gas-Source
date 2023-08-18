<?php
session_start();
include_once '../controllers/function_db.php';
if ($_GET['h']) {
  $h = $_GET['h'];
  $array = [$h];
  $query = 'select * from usuario where md5(email) = ?';
  $user = getSQL($query, 'one', $array);

  $msg = ['Falha na confirmação','Houve uma falha na confirmação da conta'];
  if ($user) {
    $array = [$user['cod_pessoa']];

    $query = 'update usuario set status = true where cod_pessoa = ?';
    $update = getSQL($query, 'mod', $array);

    if ($update) {
      $msg = ['Cadastro concluido','A sua conta foi confirmada no sistema'];
    }
  }
  include '../cadastro.html';
  echo '<link rel="stylesheet" href="../log-cad/style.css" />';
  echo '<script src="../log-cad/script.js"></script>';
  echo '
      <script>
      popup("'.$msg[0].'","'.$msg[1].'","../login.html")
      
  </script>';
}