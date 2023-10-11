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
        $sth = $this->getPdo()->prepare("SELECT * FROM " . $this->table_name);
        $sth->execute();
        return $sth->fetchAll();
    }

    /**
     * @param array $cols
     * @param array $vals
     * @return bool
     */
    public function save($cols, $vals) {
        $colCsv = implode('`, `', $cols);
        $bindParam = implode(', ', array_fill(0, count($vals), '?'));
        $sth = $this->getPdo()->prepare("INSERT INTO " . $this->table_name . " (`".$colCsv."`) VALUE(". $bindParam .")");
        return $sth->execute($vals);
    }

    /**
     * @param $id int
     * @param $vals array
     * @return bool
     */
    public function update($id, $vals) {
        $valsStr = '';
        $valsArr = [];
        foreach ($vals as $key => $val) {
            $valsStr .= "`" . $key . "` = ? ";
            $valsArr[] = $val;
        }
        $SQL = "UPDATE " . $this->table_name . " SET " . $valsStr . " WHERE `id` = " .$id;
        $sth = $this->getPdo()->prepare($SQL);
        return $sth->execute($valsArr);
    }

    public function delete($id) {
        $sth = $this->getPdo()->prepare("DELETE FROM " . $this->table_name . " WHERE id = ?;");
        return $sth->execute([$id]);
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
