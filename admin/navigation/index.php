<?php
$root = $_SERVER['DOCUMENT_ROOT'];

include($root . '/admin/auth.php');

include_once($root . '/classes/databaseConnection.php');
include_once($root . '/classes/models/Site.php');

include_once($root . '/templates/head.php');
include_once($root . '/admin/_includes/adminNavigation.php');

use PM\models\Site;

$databaseConnection = new \PM\DatabaseConnection();

if (!empty($_POST['id'])
    && !empty($_POST['path'])
    && !empty($_POST['label'])
    && !empty($_POST['content'])
    && !empty($_POST['template_id'])
) {
    $newSite = new Site(
        $_POST['id'],
        $_POST['path'], $_POST['label'], $_POST['content'], $_POST['template_id']);


    $databaseConnection->persist($newSite);
}

?>
    <div class="row">
        <h1>Navigation:</h1>
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <?php
                foreach ($databaseConnection->getNavigation() as $navigationItem) {
                    echo '<li><a href="?item=' . $navigationItem['id'] . '">' . $navigationItem['label'] . '</a></li>';
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
                        <label for="template_id">Ziel:</label>
                        <select class="form-control"
                                id="template_id"
                                name="template_id">
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