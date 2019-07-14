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

<div class="side-nav">
    <img src="images/logo.png" style="padding: 17px;"></imsg>
    <a href="index.php"><i class="fa fa-home fa-2x"></i></a>
    <a href="calendar.php"><i class="fa fa-calendar fa-2x"></i></a>
    <a href="settings.php"><i class="fa fa-cog fa-2x"></i></a>
</div>

<div class="top-nav pull-right">
    <div class="dropdown">
        <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-user-circle fa-2x"></i><span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="#">HTML</a></li>
            <li><a href="#">CSS</a></li>
            <li><a href="#">JavaScript</a></li>
        </ul>
    </div>
</div>

<div class="main">
<?php

    if ($this->error_check()) {
        $this->error_get();
    }

?>
<!-- end(head) -->
