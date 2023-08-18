<?php
// session_start();
if(!$_SESSION['logado'])
{
	header('location:./log-cad/login.html');
}
?>
