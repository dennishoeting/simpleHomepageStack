<?php
$root = $_SERVER['DOCUMENT_ROOT'];

include($root . '/admin/auth.php');

include_once($root . '/classes/databaseConnection.php');

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
    include_once($root . '/classes/models/Site.php');

    $newSite = new Site(
        $_POST['id'],
        $_POST['path'],
        $_POST['label'],
        $_POST['content'],
        $_POST['template_id']);

    if($databaseConnection->persist($newSite)) {
        $success = "Site erfolgreich gespeichert.";
    } else {
        $error = "Ein Fehler ist aufgetreten!";
    }
}
    if($success) {
        echo '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  '.$success.'</div>';
    } else if($error) {
        echo '<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  '.$error.'</div>';
    }
?>
    <div class="row">
        <h1>Sites:</h1>
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <?php
                foreach ($databaseConnection->getSites() as $site) {
                    echo '<li><a href="?site=' . $site['path'] . '">' . $site['label'] . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="col-md-9">
            <?php
            if (!isset($_GET['site'])) {
                echo "Links selektieren.";
            } else {
                $template = $databaseConnection->getSite($_GET['site']);
                ?>
                <form role="form" target="index.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $template['id'] ?>">

                    <div class="form-group">
                        <label for="path">URL (muss mit "/" beginnen):</label>
                        <input type="text"
                               class="form-control"
                               id="path"
                               name="path"
                               placeholder="/neu"
                               value="<?php echo $template['path'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="label">Titel:</label>
                        <input type="text"
                               class="form-control"
                               id="label"
                               name="label"
                               placeholder="Neue Seite"
                               value="<?php echo $template['label'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="content">Inhalt (HTML)</label>
                        <textarea class="form-control"
                                  rows="3"
                                  id="content"
                                  name="content"
                                  placeholder=""><?php echo $template['content'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="template_id">Template</label>
                        <select class="form-control"
                                id="template_id"
                                name="template_id">
                            <?php
                            foreach ($databaseConnection->getTemplates() as $templateItem) {
                                echo '<option ' . ($template['template_id'] === $templateItem['id'] ? 'selected' : '') . ' value="' . $templateItem['id'] . '">' . $templateItem['name'] . '</option>';
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