<?php
session_start();
if (isset($_SESSION["logado"])) {
  echo "logged";
} else {
  echo "notlogin";
}

?>
