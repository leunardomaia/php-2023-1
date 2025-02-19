<?php

require_once '../model/usuario.php';
require_once '../model/usuario_dao.php';

session_start();

$login = $_POST['login'];
$senha = $_POST['senha'];

$usuario = new Usuario(0, $login, $senha);

$usuarioDao = new UsuarioDao();

$usuarioAutenticado = $usuarioDao->autenticar($usuario);

if($usuarioAutenticado){
    $_SESSION['logado'] = true;
    header('Location: inicio.html');
} else {
    header('Location: index.php?erro=login');
}