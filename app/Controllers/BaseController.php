<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Debug: check DB config values
        $dbConfig = config('Database');
        log_message('error', 'DEBUG DB hostname: "' . ($dbConfig->default['hostname'] ?? 'NULL') . '"');
        log_message('error', 'DEBUG DB username: "' . ($dbConfig->default['username'] ?? 'NULL') . '"');
        log_message('error', 'DEBUG DB database: "' . ($dbConfig->default['database'] ?? 'NULL') . '"');
        log_message('error', 'DEBUG DB port: ' . ($dbConfig->default['port'] ?? 'NULL'));
        log_message('error', 'DEBUG _ENV db.hostname: "' . ($_ENV['database.default.hostname'] ?? 'NULL') . '"');
        log_message('error', 'DEBUG getenv db.hostname: "' . (getenv('database.default.hostname') ?: 'NULL') . '"');
    }
}
