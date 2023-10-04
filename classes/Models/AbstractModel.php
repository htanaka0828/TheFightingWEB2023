<?php

class AbstractModel
{
    private $pdo;
    protected $table_name;

    public function __construct()
    {
        $this->pdo = $this->dbConnect();
    }

    public function findByCol($val, $colName = 'id') {
        $sth = $this->getPdo()->prepare("SELECT * FROM " . $this->table_name . " WHERE `".$colName."` = ?");
        $sth->execute([$val]);
        return $sth->fetch();
    }

    public function findAll() {
        // @todo
        return [];
    }

    public function save() {
        // @todo
        return [];
    }

    public function update() {
        // @todo
        return [];
    }

    public function delete() {
        // @todo
        return [];
    }

    protected function getPdo()
    {
        return $this->pdo;
    }

    private function dbConnect() {
        $pdo = new PDO("mysql:host=mysql;dbname=bbs", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
