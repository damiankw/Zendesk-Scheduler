<?php

// set up the base directory
define('__PATH__', dirname(__DIR__));
require_once(__PATH__ . '/config.php');
require_once(__PATH__ . '/vendor/autoload.php');

use Zendesk\API\HttpClient as ZendeskAPI;

class Zendesk {
    private $DB;
    private $ERROR;
    
    // set up the class
    function __construct() {
        // start a session
        session_start(array('name' => 'ZENSCHED'));
        
        // check configuration
        if (!$this->check_config()) {
            // send to install.php
            return false;
        }
        
        try {
            // connect to the database
            $this->DB = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME .';charset=utf8mb4', DB_USER, DB_PASS);
            
        } catch (PDOException $ex) {
            $this->ERROR = $ex->getMessage();
            return;
        }
        
    }
    
    // check if an error exists
    function error_check() {
        if ($this->ERROR == null) {
            return false;
        } else {
            return true;
        }
    }
    
    // show the error
    function error_get() {
        echo $this->ERROR;
    }
    
    // check to ensure configuration has been done properly
    function check_config() {
        // check for database detail
        if ((!defined('DB_HOST')) || (!defined('DB_USER')) || (!defined('DB_PASS')) || (!defined('DB_NAME')) || (!defined('DB_PREFIX'))) {
            return false;
        } elseif ((DB_HOST == '') || (DB_USER == '') || (DB_PASS == '') || (DB_NAME == '')) {
            return false;
        // check for zendesk detail
        } elseif ((!defined('ZD_DOMAIN')) || (!defined('ZD_USER')) || (!defined('ZD_TOKEN'))) {
            return false;
        } elseif ((ZD_DOMAIN == '') || (ZD_USER == '') || (ZD_TOKEN == '')) {
            return false;
        } else {
            return true;
        }
    }
    
    // test the Zendesk connection for authentication
    function check_connection() {
        
    }
    
    // create a new ticket
    function create_ticket() {
    }
    
    // create a new ongoing schedule
    function create_schedule() {
    }
    
    // retrieve schedule/s from the system
    function get_schedule() {
    }
    
    // update schedule detail
    function update_schedule() {
    }
    
    // show the header
    function show_head() {
        require_once(__PATH__ . '/src/head.php');
    }
    
    // show the footer
    function show_foot() {
        require_once(__PATH__ . '/src/foot.php');
    }
    
}

/*
// load Composer
require '../vendor/autoload.php';

use Zendesk\API\HttpClient as ZendeskAPI;

$subdomain = "gazman";
$username  = "dwest@gazman.com.au"; // replace this with your registered email
$token     = "IDaq1hCljGb7PcziXe9CKTgdHacXn4ngPDeCZET2"; // replace this with your token

$client = new ZendeskAPI($subdomain);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);


// Create a new ticket
$newTicket = $client->tickets()->create([
    'requester_id' => 360334793415,
    'type' => 'task',
    'priority' => 'low',
    'subject'  => 'The quick brown fox jumps over the lazy dog',
    'comment'  => [
        'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, ' .
                  'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
    ],
    'priority' => 'normal'
]);
print_r($newTicket);
*/


?>