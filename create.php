<?php

    require_once(__DIR__ . '/src/zendesk.php');
    
    $Zendesk = new Zendesk();

    $Zendesk->show_head();
    
    // put a table here which shows the scheduled items
    
    $Zendesk->show_foot();

?>
