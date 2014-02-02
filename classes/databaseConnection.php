<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 01.02.14
 * Time: 19:05
 */
namespace PM;

use PDO;

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
            return count($statement->fetchAll())>0;
        }
    }

    public function getNavigation()
    {
        $items = array();
        $conn = $this->getConnection();
        $statement = $conn->prepare("
            SELECT n.id as id, n.label as label, s.path as path, n.parant_navigation_id as parent,
            (SELECT path FROM navigation WHERE id = n.parant_navigation_id) as parent_path
            FROM navigation n, views s
            WHERE n.site_id = s.id
            ORDER BY parent, n.order
        ");
        if ($statement->execute()) {
            $items = $statement->fetchAll();
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
            FROM footer n, views s
            WHERE n.site_id = s.id
            ORDER BY n.order
        ");
        if ($statement->execute()) {
            return $statement->fetchAll();
        }
    }

    public function getSite($path)
    {
        $conn = $this->getConnection();
        $statement = $conn->prepare("
            SELECT s.path as path, s.label as label, s.content as content, t.content as template
            FROM views s, templates t
            WHERE path = ?
            AND s.template_id = t.id
            LIMIT 1
        ");
        if ($statement->execute(array($path))) {
            $result = $statement->fetch();
            return $result;
        }
    }
}