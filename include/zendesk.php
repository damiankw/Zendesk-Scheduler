<?php
require_once(__PATH__ . '/config.php');
require_once(__PATH__ . '/vendor/autoload.php');

use Zendesk\API\HttpClient as ZendeskAPI;

class Zendesk {
    // check to ensure configuration has been done properly
    function check_config() {
        // check for database detail
        if ((!defined('DB_HOST') == '') || (!defined('DB_USER') == '') || (!defined('DB_PASS') == '') || (!defined('DB_NAME') == '')) {
            return false;
        } elseif ((DB_HOST == '') || (DB_USER == '') || (DB_PASS == '') || (DB_NAME == '')) {
            return false;
        // check for zendesk detail
        } elseif ((!defined('ZD_DOMAIN') == '') || (!defined('ZD_USER') == '') || (!defined('ZD_TOKEN') == '')) {
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