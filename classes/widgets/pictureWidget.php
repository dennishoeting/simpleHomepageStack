<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 01.02.14
 * Time: 23:52
 */

namespace PM;

include_once('widget.php');

class PictureWidget extends Widget {
    protected $path;

    protected $allowedPostfixes = array(
        'gif',
        'jpg',
        'jpeg'
    );

    public function __construct($path)
    {
        $this->path = str_replace("/", "_", $path);
    }

    public function unroll(){
        $result = '<div class="pictures">';
        if($handle = @opendir('./pictures/'.$this->path)) {
            while (false !== ($file = @readdir($handle))) {
                $exploded = explode('.',$file);
                $postfix = end($exploded);
                if(false !== array_search($postfix, $this->allowedPostfixes)) {
                    $result .= '<img src="./pictures/'.$this->path.'/'.$file.'" />';
                }
            }
        } else {
            return "<p>Keine Bilder</p>";
        }
        $result .= '</div>';
        return $result;
    }
} 