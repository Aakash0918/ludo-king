<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table;
    //protected $dbname;
    protected $primaryKey = false;
    // protected $useAutoIncrement = true;
    protected $protectFields = false;

    public function __construct($table, $primaryKey)
    {
        parent::__construct();
        //$this->dbname = $dbname;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['admin_password']))
            $data['data']['admin_password'] = password_hash($data['data']['admin_password'], PASSWORD_DEFAULT);
        return $data;
    }
}
