<?php
require_once './classes/Models/AbstractModel.php';


class AccountsModel extends AbstractModel
{
    const TABLE_NAME = 'accounts';

    public function __construct()
    {
        $this->table_name = self::TABLE_NAME;
        parent::__construct();
    }
}
