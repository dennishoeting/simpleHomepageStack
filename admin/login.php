<?php
$root = $_SERVER['DOCUMENT_ROOT'];

include_once($root.'/classes/databaseConnection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    $user = $_POST['user'];
    $password = $_POST['password'];

    $hostname = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['PHP_SELF']);

    $databaseConnection = new \PM\DatabaseConnection();
    if ($databaseConnection->authenticate($user, $password)) {
        $_SESSION['angemeldet'] = true;

        // Weiterleitung zur geschützten Startseite
        if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
            if (php_sapi_name() == 'cgi') {
                header('Status: 303 See Other');
            } else {
                header('HTTP/1.1 303 See Other');
            }
        }
        header('Location: http://' . $hostname . ($path == '/' ? '' : $path) . '/index.php');
        exit;
    }
}

include_once($root.'/templates/head.php');
?>
    <div>
        <h1>Interner Bereich</h1>

        <form role="form" action="login.php" method="post">
            <div class="form-group">
                <label for="username">Nutzer:</label>
                <input type="text" class="form-control" id="username" placeholder="Nutzer" name="user">
            </div>
            <div class="form-group">
                <label for="password">Passwort:</label>
                <input type="password" class="form-control" id="password" placeholder="Passwort" name="password">
            </div>
            <button type="submit" class="btn btn-default">Anmelden</button>
        </form>
    </div>
<?php
include_once($root.'/templates/tail.php');
?>