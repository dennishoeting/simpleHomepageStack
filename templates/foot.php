<div class="row" id="footer">
    <nav class="navbar navbar-default" role="navigation">
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php
                foreach($this->model->getFooterNavigation() as $navigationItem) {
                    $active = '';
                    if($_SERVER["REQUEST_URI"]===$navigationItem["path"]) $active = 'active';
                    echo '<li class="'.$active.'"><a href="' . $navigationItem["path"] . '">' . $navigationItem["label"] . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</div>