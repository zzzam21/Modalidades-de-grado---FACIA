<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('/dashboard', 'Home::index', ['filter' => 'auth']);

// -----------------------------------
// LOGIN ROUTES
// -----------------------------------
$routes->get('/auth/login', 'Auth::index');

$routes->post('/auth/login', 'Auth::loginPost');

    // Logout Route
$routes->get('/auth/logout', 'Auth::logout', ['filter' => 'auth']);

// -----------------------------------
// STUDENTS ROUTES
// -----------------------------------
$routes->get('/students','StudentController::students',['filter' => 'auth']);

$routes->get('/students/getstudents', 'studentController::getStudents',['filter' => 'auth']);

// -----------------------------------
// TEACHERS ROUTES
// -----------------------------------
$routes->get('/teachers','TeachersController::teachers',['filter' => 'auth']);

$routes->get('/teachers/getteacher','TeachersController::getTeachers',['filter' => 'auth']);

// $routes->post('/teachers/add','TeachersController::addTeacher',['filter' => 'auth']);

// -----------------------------------
// MODALITIES ROUTES
// -----------------------------------
$routes->get('/modalities','ModalitieController::modalities',['filter' => 'auth']);

    //Importar PDF y procesar con OpenAI
$routes->post('/modalities/add','importPdfController::importPdf',['filter' => 'auth']);

    // Procesar y guardar modalidad en BD
$routes->post('/modalities/process','ModalitieController::processModalitie',['filter' => 'auth']);

    // Listar Modalidades
$routes->get('/modalities/getmodalities','ModalitieController::getmodalities',['filter' => 'auth']);

    // Vista Información Detallada Modalidad
$routes->get('/modalities/modality/(:num)','ModalitieController::modality/$1',['filter' => 'auth']);

$routes->get('/modalities/getmodality/(:num)', 'ModalitieController::getModality/$1', ['filter' => 'auth']);


// -----------------------------------
// USER ROUTES
// -----------------------------------
$routes->get('/configuration','Config::config',['filter' => 'auth']);

    // Actualizar Nombre de usuario
$routes->put('/configuration/updateName', 'Config::updateUser', ['filter' => 'auth']);
    // Actualizar Email de usuario
$routes->put('/configuration/updateEmail', 'Config::updateEmail', ['filter' => 'auth']);