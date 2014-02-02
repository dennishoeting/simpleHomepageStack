<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 01.02.14
 * Time: 20:33
 */

namespace PM;

class Controller {
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }
} 