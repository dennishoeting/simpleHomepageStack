<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 01.02.14
 * Time: 19:56
 */

namespace PM;

include_once('databaseConnection.php');

class Model
{
    protected $path;
    protected $databaseConnection = null;
    protected $site;

    public function __construct($path)
    {
        $this->path = $path;
        $this->databaseConnection = new DatabaseConnection();
        $this->site = $this->databaseConnection->getSite($this->path);
    }

    public function getPath() {
        return $this->path;
    }

    public function getNavigation()
    {
        return $this->databaseConnection->getNavigation();
    }

    public function getFooterNavigation(){
        return $this->databaseConnection->getFooterNavigation();
    }

    public function getContent()
    {
        return $this->site['content'];
    }

    public function getLabel()
    {
        return $this->site['label'];
    }

    public function getTemplate()
    {
        return $this->site['template'];
    }
} 