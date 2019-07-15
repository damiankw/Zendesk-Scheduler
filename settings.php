<?php

    require_once(__DIR__ . '/src/zendesk.php');
    
    $Zendesk = new Zendesk();
    

    $Zendesk->show_head();
?>
    <table class="table">
    </table>
<?php
    $Zendesk->show_foot();

?>
