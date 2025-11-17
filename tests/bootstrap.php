<?php
// Bootstrap file for PHPUnit tests
// No vendor/autoload needed - using standalone PHPUnit

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Define constants
define('TEST_MODE', true);
define('ROOT_PATH', dirname(__DIR__));

// Load DatabaseTestCase
require_once __DIR__ . '/DatabaseTestCase.php';
