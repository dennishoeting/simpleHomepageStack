<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 02.02.14
 * Time: 19:36
 */

namespace PM\models;

class NavigationItem {
    protected $id;
    protected $label;
    protected $site_id;

    function __construct($id, $label, $site_id)
    {
        $this->id = $id;
        $this->label = $label;
        $this->site_id = $site_id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @param mixed $template_id
     */
    public function setSiteId($template_id)
    {
        $this->site_id = $template_id;
    }

    /**
     * @return mixed
     */
    public function getSiteId()
    {
        return $this->site_id;
    }
} 