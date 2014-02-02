<?php
$root = $_SERVER['DOCUMENT_ROOT'];

include($root . '/admin/auth.php');

include_once($root . '/templates/head.php');
include_once($root . '/admin/templates/adminNavigation.php');
?>
    <div class="row">
        <div class="col-md-3">
            <h1>Sites:</h1>
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Messages</a></li>
            </ul>
        </div>
        <div class="col-md-9"></div>
    </div>
<?php
include_once($root . '/templates/tail.php');
?>