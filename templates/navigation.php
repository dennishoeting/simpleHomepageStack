<div class="row" id="navigation">
    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Home</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php
                print_r($this->model->getNavigation());
                foreach ($this->model->getNavigation() as $navigationItem) {
                    $active = '';
                    if ($_SERVER["REQUEST_URI"] === $navigationItem["path"]) {
                        $active = 'active';
                    } else {
                        foreach($navigationItem['children'] as $navigationChildItem) {
                            if ($_SERVER["REQUEST_URI"] === $navigationChildItem["path"]) {
                                $active = ' active';
                            }
                        }
                    }

                    $dropdown = false;
                    if (count($navigationItem['children']) > 0) {
                        $dropdown = true;
                    }

                    if(!$dropdown) {
                        echo '<li class="' . $active . '"><a href="' . $navigationItem["path"] . '">';
                        echo $navigationItem["label"];
                        echo '</a></li>';
                    } else {
                        echo '<li class="dropdown'.$active.'">';
                        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
                        echo $navigationItem["label"] . ' <b class="caret"></b>';
                        echo '</a>';
                        echo '<ul class="dropdown-menu" role="menu">';
                        foreach($navigationItem['children'] as $navigationChildItem) {
                            echo '<li><a href="' . $navigationChildItem["path"] . '">';
                            echo $navigationChildItem["label"];
                            echo '</a></li>';
                        }
                        echo '</ul>';
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </nav>
</div>