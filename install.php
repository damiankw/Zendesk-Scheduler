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
    // check if config.php exists (we need it already built for the moment..)
    if (!file_exists('config.php')) {
        $COMPLETE = 0;

        echo '<p>You have no config.php generated yet, at this point this must be done by you. See below for an example.</p>';
        echo '<p>Once the file has been created, refresh this page to check.</p>';
        echo '<pre>';
        echo str_replace(array('<', '>'), array('&lt;', '&gt;'), file_get_contents('config.example.php'));
        echo '</pre>';
        
    // check if the config.php is configured properly
    } elseif (file_exists('config.php')) {
        $COMPLETE = 25;

        // include the configuration
        require_once('config.php');
        $MSG = '';
        
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
        
        // display a nice message if theres issues
        if ($MSG != '') {
            echo 'You have the following errors with your config.php:<br>';
            echo $MSG;
            echo '<p>Once the file has been updated, refresh the page to check.</p>';
        } else {
            $COMPLETE = 50;
            
            // attempt to connect to the database
            try {
                $DB = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME .';charset=utf8mb4', DB_USER, DB_PASS);
                
                $COMPLETE = 75;
                
                // check if the tables already exist
                $DATA = $DB->query("SHOW TABLES FROM ". DB_NAME);
                
                $TABLES = array(
                    'users' => false,
                    'schedules' => false,
                    'application' => false,
                    'logs' => false
                );
                
                while ($ITEM = $DATA->fetch(PDO::FETCH_ASSOC)) {
                    echo DB_PREFIX . $ITEM['Tables_in_zensched'] .'||'. array_key_exists(DB_PREFIX . $ITEM['Tables_in_zensched'], $TABLES) .'|||<br>';
                    if (array_key_exists(DB_PREFIX . $ITEM['Tables_in_zensched'], $TABLES)) {
                        echo 'yep';
                    }
                }
            
            } catch (PDOException $ex) {
                echo 'Unable to connect to the database:<br>';
                echo '- '. $ex->getMessage();
                echo '<p>Please check your MySQL login details and refresh the page once complete. Remember that the database needs to already have been created.</p>';
            }
        }
    }
?>
        </div>
        <div class="panel-footer">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $COMPLETE; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $COMPLETE; ?>%; min-width: 2em;"><?php echo $COMPLETE; ?>%</div>
            </div>
        </div>
    </div>
<?php
/*
CREATE TABLE users (
    user_id int,
    user_name varchar(100),
    user_password varchar(32),
    user_email varchar(100),
    user_status bool,
    user_date_created datetime,
    user_date_modified datetime
);

CREATE TABLE schedules (
    sched_id int,
    sched_name varchar(100),
    sched_desc varchar(250),
    sched_
)




*/
?>
</div>
</body>
</html>