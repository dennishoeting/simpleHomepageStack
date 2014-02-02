<?php
$root = $_SERVER['DOCUMENT_ROOT'];

include($root . '/admin/auth.php');

include_once($root . '/classes/databaseConnection.php');
include_once($root . '/classes/models/Site.php');

include_once($root . '/templates/head.php');
include_once($root . '/admin/_includes/adminNavigation.php');

use PM\models\NavigationItem;

$databaseConnection = new \PM\DatabaseConnection();

if (!empty($_POST['id'])
    && !empty($_POST['label'])
    && !empty($_POST['site_id'])
) {
    include_once($root . '/classes/models/NavigationItem.php');

    $newNavigationItem = new NavigationItem(
        $_POST['id'],
        $_POST['label'],
        $_POST['site_id']);

    if ($databaseConnection->persist($newNavigationItem)) {
        $success = "Template erfolgreich gespeichert.";
    } else {
        $error = "Ein Fehler ist aufgetreten!";
    }

}

if ($success) {
    echo '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  ' . $success . '</div>';
} else if ($error) {
    echo '<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  ' . $error . '</div>';
}

?>
    <div class="row">
        <h1>Navigation:</h1>

        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <?php
                foreach ($databaseConnection->getNavigation() as $navigationItem) {
                    echo '<li><a href="?item=' . $navigationItem['id'] . '">' . $navigationItem['label'] . '</a></li>';
                    foreach ($navigationItem['children'] as $navigationChildrenItem) {
                        echo '<li><a href="?item=' . $navigationChildrenItem['id'] . '">&gt; ' . $navigationChildrenItem['label'] . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div class="col-md-9">
            <?php
            if (!isset($_GET['item'])) {
                echo "Links selektieren.";
            } else {
                $navigationItem = $databaseConnection->getNavigationItem($_GET['item']);
                ?>
                <form role="form" target="index.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $navigationItem['id'] ?>">

                    <div class="form-group">
                        <label for="label">Titel:</label>
                        <input type="text"
                               class="form-control"
                               id="label"
                               name="label"
                               placeholder="Neue Seite"
                               value="<?php echo $navigationItem['label'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="site_id">Ziel:</label>
                        <select class="form-control"
                                id="site_id"
                                name="site_id">
                            <?php
                            foreach ($databaseConnection->getSites() as $site) {
                                echo '<option ' . ($navigationItem['site_id'] === $site['id'] ? 'selected' : '') . ' value="' . $site['id'] . '">' . $site['label'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Speichern</button>
                    <button type="reset" class="btn btn-danger">Verwerfen</button>
                </form>
            <?php
            }
            ?>
        </div>
    </div>
<?php
include_once($root . '/templates/tail.php');
?>