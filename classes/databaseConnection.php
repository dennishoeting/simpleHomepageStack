<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 01.02.14
 * Time: 19:05
 */
namespace PM;

use PDO;
use PM\models\NavigationItem;
use PM\models\Site;
use PM\models\Template;

class DatabaseConnection
{
    private $host = "physio-marenziehn.de.mysql";
    private $database = "physio_marenzie";
    private $user = "physio_marenzie";
    private $password = "wbZst3zE";

    private $connection = null;

    /**
     * @return PDO
     */
    private function getConnection()
    {
        if (!$this->connection) {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->password);
        }
        return $this->connection;
    }

    public function authenticate($username, $password)
    {
        $conn = $this->getConnection();
        $statement = $conn->prepare("
            SELECT *
            FROM users
            WHERE name = :name
            AND password = :pass
        ");
        $statement->bindParam(':name', $username);
        $statement->bindParam(':pass', md5($password));
        if ($statement->execute()) {
            return count($statement->fetchAll()) > 0;
        }
    }

    public function getNavigation()
    {
        $items = array();
        $conn = $this->getConnection();
        $statement = $conn->prepare("
            SELECT n.id as id, n.label as label, s.path as path, n.parant_navigation_id as parent,
            (SELECT path FROM navigation WHERE id = n.parant_navigation_id) as parent_path
            FROM navigation n, sites s
            WHERE n.site_id = s.id
            ORDER BY parent, n.order
        ");
        if ($statement->execute()) {
            $items = $statement->fetchAll();
        } else {
            echo "nope";
        }

        $navigationItems = array();
        foreach ($items as $item) {
            if (!isset($item['parent'])) {
                $item['children'] = array();
                $navigationItems[$item['id']] = $item;
            } else {
                array_push($navigationItems[$item['parent']]['children'], $item);
            }
        }

        return $navigationItems;
    }

    public function getFooterNavigation()
    {
        $conn = $this->getConnection();
        $statement = $conn->prepare("
            SELECT n.label, s.path
            FROM footer n, sites s
            WHERE n.site_id = s.id
            ORDER BY n.order
        ");
        if ($statement->execute()) {
            return $statement->fetchAll();
        }
    }

    public function getNavigationItem($itemId)
    {
        $conn = $this->getConnection();
        $statement = $conn->prepare("
            SELECT *
            FROM navigation
            WHERE id = :id
        ");
        $statement->bindParam(':id', $itemId);
        if ($statement->execute()) {
            return $statement->fetch();
        }
    }

    public function getSites()
    {
        $conn = $this->getConnection();
        $statement = $conn->prepare("
            SELECT *
            FROM sites
        ");
        if ($statement->execute()) {
            return $statement->fetchAll();
        }
    }

    public function getSite($path)
    {
        $conn = $this->getConnection();
        $statement = $conn->prepare("
            SELECT s.id as id, s.path as path, s.label as label, s.content as content, t.content as template, t.id as template_id
            FROM sites s, templates t
            WHERE path = ?
            AND s.template_id = t.id
            LIMIT 1
        ");
        if ($statement->execute(array($path))) {
            $result = $statement->fetch();
            return $result;
        }
    }

    public function getTemplates()
    {
        $conn = $this->getConnection();
        $statement = $conn->prepare("
            SELECT name, id
            FROM templates
        ");
        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        }
    }

    public function getTemplate($id)
    {
        $conn = $this->getConnection();
        $statement = $conn->prepare("
            SELECT *
            FROM templates
            WHERE id = :id
        ");
        $statement->bindParam(':id', $id);
        if ($statement->execute()) {
            $result = $statement->fetch();
            return $result;
        }
    }

    public function persist($obj)
    {
        if ($obj instanceof Site) {
            $conn = $this->getConnection();
            $statement = $conn->prepare("
            UPDATE sites
            SET path = :path, label = :label, content = :content, template_id = :template_id
            WHERE id = :id
            ");
            $statement->bindParam(':id', $obj->getId());
            $statement->bindParam(':path', $obj->getPath());
            $statement->bindParam(':label', $obj->getLabel());
            $statement->bindParam(':content', $obj->getContent());
            $statement->bindParam(':template_id', $obj->getTemplateId());
            if ($statement->execute()) {
                return true;
            }
        } else if ($obj instanceof Template) {
            $conn = $this->getConnection();
            $statement = $conn->prepare("
            UPDATE templates
            SET name = :name, content = :content
            WHERE id = :id
            ");
            $statement->bindParam(':id', $obj->getId());
            $statement->bindParam(':name', $obj->getName());
            $statement->bindParam(':content', $obj->getContent());
            if ($statement->execute()) {
                return true;
            }
        } else if ($obj instanceof NavigationItem) {
            $conn = $this->getConnection();
            $statement = $conn->prepare("
            UPDATE navigation
            SET label = :label, site_id = :site_id
            WHERE id = :id
            ");
            $statement->bindParam(':id', $obj->getId());
            $statement->bindParam(':label', $obj->getLabel());
            $statement->bindParam(':site_id', $obj->getSiteId());
            if ($statement->execute()) {
                return true;
            }
        }
        return false;
    }
}