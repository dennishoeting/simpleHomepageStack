<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 01.02.14
 * Time: 22:39
 */

namespace PM;

include_once('pictureWidget.php');

class WidgetRepository {
    public function getKnownWidgets()
    {
        return array(
            'label',
            'content',
            'pictures'
        );
    }

    /**
     * @param $model Model
     * @param $token String
     * @return mixed mixed
     */
    public function getWidget($model, $token)
    {
        switch($token) {
            case 'label':
                return $model->getLabel();
            case 'content':
                return $model->getContent();
            case 'pictures':
                $picWidget = new PictureWidget($model->getPath());
                return $picWidget->unroll();
        }
    }
} 