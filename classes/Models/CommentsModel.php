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
}

