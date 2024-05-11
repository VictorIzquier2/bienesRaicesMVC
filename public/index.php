<?php
  require_once __DIR__ . '/../includes/app.php';

  use MVC\Router;
  use Controllers\PropiedadController;
  use Controllers\VendedorController;
  use Controllers\PaginaController;

  $router = new Router();

  // Zona Privada
  $router->get('/admin', [PropiedadController::class, 'index']);
  $router->get('/propiedades/crear', [PropiedadController::class, 'crear']);
  $router->post('/propiedades/crear', [PropiedadController::class, 'crear']);
  $router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
  $router->post('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
  $router->post('/propiedades/eliminar', [PropiedadController::class, 'eliminar']);

  $router->get('/vendedores/crear', [VendedorController::class, 'crear']);
  $router->post('/vendedores/crear', [VendedorController::class, 'crear']);
  $router->get('/vendedores/actualizar', [VendedorController::class, 'actualizar']);
  $router->post('/vendedores/actualizar', [VendedorController::class, 'actualizar']);
  $router->post('/vendedores/eliminar', [VendedorController::class, 'eliminar']);

  // Zona Pública
  $router->get('/', [PaginaController::class, 'index']);
  $router->get('/nosotros', [PaginaController::class, 'nosotros']);
  $router->get('/propiedades', [PaginaController::class, 'propiedades']);
  $router->get('/propiedad', [PaginaController::class, 'propiedad']);
  $router->get('/blog', [PaginaController::class, 'blog']);
  $router->get('/entrada', [PaginaController::class, 'entrada']);
  $router->get('/contacto', [PaginaController::class, 'contacto']);
  $router->post('/contacto', [PaginaController::class, 'contacto']);

  $router->comprobarRutas();
?>