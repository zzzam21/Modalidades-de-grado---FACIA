<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('/dashboard', 'Home::index', ['filter' => 'auth']);

// Login Routes
$routes->get('/auth/login', 'Auth::index');

$routes->post('/auth/login', 'Auth::loginPost');

    // Logout Route
$routes->get('/auth/logout', 'Auth::logout', ['filter' => 'auth']);

// CRUD Students Routes
$routes->get('/students','StudentController::students',['filter' => 'auth']);

$routes->get('/students/getstudents', 'studentController::getStudents',['filter' => 'auth']);

//$routes->post('/students/addstudent','StudentController::addStudent',['filter' => 'auth']);

// CRUD Teachers Routes
$routes->get('/teachers','TeachersController::teachers',['filter' => 'auth']);

$routes->get('/teachers/getteacher','TeachersController::getTeachers',['filter' => 'auth']);

// $routes->post('/teachers/add','TeachersController::addTeacher',['filter' => 'auth']);


// CRUD Modalities Routes
$routes->get('/modalities','ModalitieController::modalities',['filter' => 'auth']);
    //Añadir modalidad
// $routes->post('/modalities/addModality','ModalitieController::addModality',['filter' => 'auth']);

    //Importar PDF y procesar con OpenAI
$routes->post('/modalities/add','importPdfController::importPdf',['filter' => 'auth']);

    // Procesar y guardar modalidad en BD
$routes->get('/modalities/process','ModalitieController::processModalitie',['filter' => 'auth']);

    // Listar Modalidades en formato JSON
$routes->get('/modalities/getmodalities','ModalitieController::getmodalities',['filter' => 'auth']);

// Configuration Routes
$routes->get('/configuration','Config::config',['filter' => 'auth']);

    // Actualizar Correo
$routes->post('/configuration/updateName','Config::updateUser',['filter'=> 'auth']);