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

    // Vista Información Detallada Estudiante
$routes->get('/students/student/(:num)','StudentController::student/$1',['filter' => 'auth']);

$routes->get('/students/getstudent/(:num)','StudentController::getStudent/$1',['filter' => 'auth']);

$routes->put('/students/updateStudent/(:num)','studentController::updateStudent/$1',['filter' => 'auth']);

// -----------------------------------
// TEACHERS ROUTES
// -----------------------------------
$routes->get('/teachers','TeachersController::teachers',['filter' => 'auth']);

$routes->get('/teachers/getteachers','TeachersController::getTeachers',['filter' => 'auth']);

$routes->get('/teachers/teacher/(:num)','TeachersController::teacher/$1',['filter' => 'auth']);

$routes->get('/teachers/getteacher/(:num)','TeachersController::getTeacher/$1',['filter' => 'auth']);

$routes->get('/teachers/getInfoModalByTeacher/(:num)','TeachersController::getInfoModalityByTeacher/$1',['filter' => 'auth']);

$routes->get('/teachers/report/(:num)','TeachersController::report/$1',['filter' => 'auth']);

$routes->put('/teachers/updateTeacher/(:num)','teachersController::updateTeacher/$1',['filter' => 'auth']);

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

$routes->delete('/modalities/deleteModality/(:num)', 'ModalitieController::deleteModality/$1', ['filter' => 'auth']);

$routes->post('/modalities/updateStatus/(:num)', 'ModalitieController::updateStatus/$1', ['filter' => 'auth']);

$routes->post('/modalities/updateModality/(:num)', 'ModalitieController::updateModality/$1', ['filter' => 'auth']);

$routes->post('/modalities/updateSustentacion/(:num)', 'ModalitieController::updateSustentacion/$1', ['filter' => 'auth']);

    // Obtener datos para formularios (tipos, programas)
$routes->get('/modalities/getFormData', 'ModalitieController::getFormData', ['filter' => 'auth']);

// -----------------------------------
// ALERT ROUTES
// -----------------------------------
$routes->get('/alerts', 'AlertController::alert', ['filter' => 'auth']);
$routes->get('/alerts/getAlertas', 'AlertController::getAlertas', ['filter' => 'auth']);

// -----------------------------------
// USER ROUTES
// -----------------------------------

$routes->get('/configuration','Config::config',['filter' => 'auth']);
    // Actualizar Nombre de usuario
$routes->put('/configuration/updateName', 'Config::updateUser', ['filter' => 'auth']);
    // Actualizar Email de usuario
$routes->put('/configuration/updateEmail', 'Config::updateEmail', ['filter' => 'auth']);
    // Actualizar Contraseña de usuario
$routes->put('/configuration/updatePassword', 'Config::updatePassword', ['filter' => 'auth']);
    // Obtener información del usuario
$routes->get('/configuration/getUser', 'Config::getUser', ['filter' => 'auth']);
    // Actualizar perfil del usuario
$routes->put('/configuration/updatePassword', 'Config::updatePassword', ['filter' => 'auth']);
