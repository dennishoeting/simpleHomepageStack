<?php
$root = $_SERVER['DOCUMENT_ROOT'];

include($root . '/admin/auth.php');

include_once($root . '/templates/head.php');
include_once($root . '/admin/_includes/adminNavigation.php');
?>
    <div class="row">
        <h1>Administrationsbereich</h1>
        <div class="col-md-12">
                Bitte wählen sie aus der Navigation oben.
        </div>
    </div>
<?php
include_once($root . '/templates/tail.php');
?>