<?php
$root = $_SERVER['DOCUMENT_ROOT'];

include($root . '/admin/auth.php');

include_once($root . '/classes/databaseConnection.php');

include_once($root . '/templates/head.php');
include_once($root . '/admin/_includes/adminNavigation.php');

use PM\models\Template;

$databaseConnection = new \PM\DatabaseConnection();

if (!empty($_POST['id'])
    && !empty($_POST['name'])
    && !empty($_POST['content'])
) {
    include_once($root . '/classes/models/Template.php');

    $newTemplate = new Template(
        $_POST['id'],
        $_POST['name'],
        $_POST['content']);

    if ($databaseConnection->persist($newTemplate)) {
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
        <h1>Templates:</h1>

        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <?php
                foreach ($databaseConnection->getTemplates() as $template) {
                    echo '<li><a href="?template=' . $template['id'] . '">' . $template['name'] . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="col-md-9">
            <?php
            if (!isset($_GET['template'])) {
                echo "Links selektieren.";
            } else {
                $template = $databaseConnection->getTemplate($_GET['template']);
                ?>
                <form role="form" target="index.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $template['id'] ?>">

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text"
                               class="form-control"
                               id="name"
                               name="name"
                               placeholder="Neues Template"
                               value="<?php echo $template['name'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="content">Inhalt (HTML)</label>
                        <textarea class="form-control"
                                  rows="3"
                                  id="content"
                                  name="content"
                                  placeholder=""><?php echo $template['content'] ?></textarea>
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