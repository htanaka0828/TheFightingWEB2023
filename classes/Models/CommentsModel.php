<?php
require_once './classes/Models/AbstractModel.php';


class CommentsModel extends AbstractModel
{
    const TABLE_NAME = 'comments';

    public function __construct()
    {
        $this->table_name = self::TABLE_NAME;
        parent::__construct();
    }

    public function findAll() {
        $sth = $this->getPdo()->prepare("SELECT `comments`.`id`, `comment`, `create_date`, `name` FROM " . $this->table_name . " JOIN accounts ON comments.account_id = accounts.id");
        $sth->execute();
        return $sth->fetchAll();
    }
}

