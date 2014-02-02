<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 02.02.14
 * Time: 19:36
 */

namespace PM\models;

class Site {
    protected $id;
    protected $path;
    protected $label;
    protected $content;
    protected $template_id;

    function __construct($id, $path, $label, $content, $template_id)
    {
        $this->id = $id;
        $this->path = $path;
        $this->label = $label;
        $this->content = $content;
        $this->template_id = $template_id;
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
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $template_id
     */
    public function setTemplateId($template_id)
    {
        $this->template_id = $template_id;
    }

    /**
     * @return mixed
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }


} 