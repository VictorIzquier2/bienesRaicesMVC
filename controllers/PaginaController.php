<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;

class PaginaController {

  public static function index(Router $router) {

    $inicio = true;
    $propiedades = Propiedad::limit(3);

    $router->render('paginas/index', [
      'inicio'=>$inicio,
      'propiedades' => $propiedades
    ]);

  }

  public static function nosotros(Router $router) {
    
    $router->render('paginas/nosotros');
  }

  public static function propiedades(Router $router) {
    
    $propiedades = Propiedad::all();

    $router->render('paginas/propiedades', [
      'propiedades' => $propiedades
    ]);
  }

  public static function propiedad(Router $router) {

    $id = validarORedireccionar("/propiedades");
    $propiedad = Propiedad::findOne($id);
    
    $router->render('paginas/propiedad', [
      'propiedad' => $propiedad
    ]);

  }

  public static function blog(Router $router) {
    
    $router->render('paginas/blog');
  }

  public static function entrada(Router $router) {
    
    $router->render('paginas/entrada');
  }

  public static function contacto(Router $router) {
    echo "Desde contacto";
  }
}
