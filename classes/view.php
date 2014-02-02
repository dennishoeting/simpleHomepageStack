<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 01.02.14
 * Time: 20:34
 */

namespace PM;

include_once('widgets/widgetRepository.php');


$hostname = $_SERVER['HTTP_HOST'];
$path = dirname($_SERVER['PHP_SELF']);

class View
{
    protected $controller;
    protected $model;
    protected $template;

    /** @var WidgetRepository */
    protected $widgetRepository;

    /**
     * @param $controller Controller
     * @param $model Model
     */
    public function __construct($controller, $model)
    {
        $this->controller = $controller;
        $this->model = $model;

        $this->widgetRepository = new WidgetRepository();
    }


    public function unroll(array $params = array())
    {
        if (!isset($params['showNavigation'])) {
            $params['showNavigation'] = true;
        }
        if (!isset($params['showFooterNavigation'])) {
            $params['showFooterNavigation'] = true;
        }

        $root = $_SERVER['DOCUMENT_ROOT'];

        include_once($root . '/templates/head.php');
        if ($params['showNavigation']) {
            include_once($root . '/templates/navigation.php');
        }

        if(isset($params['template'])) {
            include_once($params['template']);
        } else {
            $template = $this->model->getTemplate();
            foreach ($this->widgetRepository->getKnownWidgets() as $widgetToken) {
                $template = str_replace(
                    '{{' . $widgetToken . '}}',
                    $this->widgetRepository->getWidget($this->model, $widgetToken),
                    $template
                );
            }
        }
        echo $template;

        if ($params['showFooterNavigation']) {
            include_once($root . '/templates/foot.php');
        }
        include_once($root . '/templates/tail.php');
    }
} 