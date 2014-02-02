<?php
$root = $_SERVER['DOCUMENT_ROOT'];

include($root . '/admin/auth.php');

include_once($root . '/templates/head.php');
include_once($root . '/admin/templates/adminNavigation.php');
?>
    <h1>Administrationsbereich</h1>
    Bitte wählen sie aus der Navigation oben.
<?php
include_once($root . '/templates/tail.php');
?>