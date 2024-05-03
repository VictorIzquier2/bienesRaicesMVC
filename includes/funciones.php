<?php

 define('TEMPLATES_URL', __DIR__ . '/templates');
 define('FUNCIONES_URL', __DIR__ . 'funciones.php');
 define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate( string $nombre, bool $inicio = false ) {
  include TEMPLATES_URL . "/$nombre.php";
}

function autentificado() {
  session_start();

  if(!$_SESSION['login']) {
    header('Location: /src/index.php');
  }
}

function debuguear($variable){
  echo "<pre>";
  var_dump($variable);
  echo "</pre>";
  exit;
}

// Escapar el HTML 
function escapar($html) : string{
  $escapar = htmlspecialchars($html);
  return $escapar;
}

// Validar tipo de contenido 
function validarTipoContenido($tipo){
  $tipos = ['vendedor', 'propiedad'];
  return in_array($tipo, $tipos);
}

// Validar o redireccionar al actualizar un registro 
function validarORedireccionar(string $url){

  $id = $_GET['id'];
  $id = filter_var($id, FILTER_VALIDATE_INT);
  
  if(!$id){ header("Location: {$url}");};

  return $id;
}

function mostrarNotificacion($codigo){
  switch ($codigo) {
    case '1':
      echo '<p class="alerta exito">Registrado correctamente</p>';
      break;
    case '2':
      echo '<p class="alerta exito">Actualizado correctamente</p>';
      break;
    case '3':
      echo '<p class="alerta exito">Eliminado correctamente</p>';
      break;
    default:
      echo '';
      break;
  }
}
