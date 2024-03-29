<!-- start(head) -->
<!DOCTYPE html>
<html>
    <head>
        <title>Zendesk Scheduler</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="js/main.js"></script>
    </head>
</html>
<body>

<div class="install col-md-6 col-md-offset-3">
    <div class="panel panel-info">
        <div class="panel-heading">Zendesk Scheduler installer</div>
        <div class="panel-body">
            
<?php
    $MSG = '';
    
    // step 1 - check if config.php exists (we need it already built for the moment..)
    if (!file_exists('config.php')) {
        $COMPLETE = 0;

        $MSG .= '<p>You have no config.php generated yet, at this point this must be done by you. See below for an example.</p>';
        $MSG .= '<pre>';
        $MSG .= str_replace(array('<', '>'), array('&lt;', '&gt;'), file_get_contents('config.example.php'));
        $MSG .= '</pre>';
    }
    
    // step 2 - check if config.php is done correctly
    if ($MSG == '') {
        echo '- Checking config.php ...<br>';
        $COMPLETE = 25;

        // include the configuration
        require_once('config.php');
        
        // check for database detail
        if ((!defined('DB_HOST')) || (!defined('DB_USER')) || (!defined('DB_PASS')) || (!defined('DB_NAME')) || (!defined('DB_PREFIX'))) {
            $MSG .= '- You are missing one or more DB_* settings from your config.php<br>';
        } elseif ((DB_HOST == '') || (DB_USER == '') || (DB_PASS == '') || (DB_NAME == '')) {
            $MSG .= '- One or more of your DB_* settings are blank in your config.php<br>';
        }
        
        // check for zendesk detail
        if ((!defined('ZD_DOMAIN')) || (!defined('ZD_USER')) || (!defined('ZD_TOKEN'))) {
            $MSG .= '- You are missing one or more ZD_* settings from your config.php<br>';
        } elseif ((ZD_DOMAIN == '') || (ZD_USER == '') || (ZD_TOKEN == '')) {
            $MSG .= '- One or more of your ZD_* settings are blank in your config.php<br>';
        }
    }
    
    // step 3 - check if mysql connection works
    if ($MSG == '') {
        echo '- Checking MySQL connectivity ...<br>';
        $COMPLETE = 50;
            
        // attempt to connect to the database
        try {
            $DB = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME .';charset=utf8mb4', DB_USER, DB_PASS);
            
        } catch (PDOException $ex) {
            $MSG .= 'Unable to connect to the database:<br>';
            $MSG .= '- '. $ex->getMessage();
            $MSG .= '<p>Please check your MySQL login details and refresh the page once complete. Remember that the database needs to already have been created.</p>';
        }
    }
    
    // step 4 - check if tables already exist
    if ($MSG == '') {
        echo '- Checking for existing tables ...<br>';
        $COMPLETE = 75;
                
        // check if the tables already exist
        $TABLES = array(
            'users' => false,
            'schedules' => false,
            'application' => false,
            'logs' => false
        );
        
        foreach ($TABLES as $TABLE => $STATUS) {
            $EX = true;
            $DATA = $DB->query("DESCRIBE ". DB_PREFIX . $TABLE) or $EX = false;
            if ($EX) {
                $MSG .= '- '. DB_PREFIX . $TABLE .'<br>';
            }
        }
        
        if ($MSG != '') {
            $MSG = 'Found the following tables already in the database, these must be removed before continuing:<br>' . $MSG;
        }
    }
    
    // step 5 - create the tables
    if ($MSG == '') {
        echo '- Creating tables ...';
        $COMPLETE = 100;
        
        // users who have access to the system (not in use yet)
        $DB->query(
            "CREATE TABLE ". DB_PREFIX ."users (
                user_id int auto_increment,
                user_name varchar(100),
                user_password varchar(32),
                user_email varchar(100),
                user_status bool default true,
                user_date_created datetime,
                user_date_modified datetime,
                primary key(user_id)
            )"
        );
        
        // the actual schedules
        $DB->query(
            "CREATE TABLE ". DB_PREFIX ."schedules (
                sched_id int auto_increment,
                sched_name varchar(100),
                sched_desc varchar(250),
                sched_date_start datetime,
                sched_date_end datetime,
                sched_status bool,
                sched_date_created datetime,
                sched_date_modified datetime,
                sched_type enum('once', 'daily', 'weekly', 'monthly-date', 'month-day', 'yearly-date'),
                primary key(sched_id)
            )"
        );
        
        // random settings / configuration internal
        $DB->query(
            "CREATE TABLE ". DB_PREFIX ."config (
                config_id int auto_increment,
                config_name varchar(50),
                config_value varchar(250),
                config_date_modified datetime,
                primary key(config_id)
            )"
        );
        
        $DB->query(
            "INSERT INTO ". DB_PREFIX ."config (config_name, config_value, config_date_modified) VALUES('version', '0.01', NOW())"
        );
    }
    
    echo '<hr>';

    // display a nice message if theres issues
    if ($MSG != '') {
        echo $MSG;
        echo '<hr>';
        echo '<p>Once the file has been updated/fixed, refresh the page to check.</p>';
    } else {
        echo 'Configuration has been completed. Please head to <a href="index.php">index.php</a> to continue using Zendesk Scheduler.';
    }

?>
        </div>
        <div class="panel-footer">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $COMPLETE; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $COMPLETE; ?>%; min-width: 2em;"><?php echo $COMPLETE; ?>%</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>



<?php
/*
CREATE TABLE logs (
    log_id
    log_created
    log_code
    log_desc
)
*/
?>
