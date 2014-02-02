<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 02.02.14
 * Time: 19:36
 */

namespace PM\models;

class Template {
    protected $id;
    protected $name;
    protected $content;

    function __construct($id, $name, $content)
    {
        $this->id = $id;
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

} 