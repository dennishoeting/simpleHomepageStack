<?php
$root = $_SERVER['DOCUMENT_ROOT'];

include($root . '/admin/auth.php');

include_once($root . '/classes/databaseConnection.php');

include_once($root . '/templates/head.php');
include_once($root . '/admin/_includes/adminNavigation.php');

use PM\models\Template;

$databaseConnection = new \PM\DatabaseConnection();

?>
    <div class="row">
        <h1>Widgets:</h1>
        TODO:
    </div>
<?php
include_once($root . '/templates/tail.php');
?>