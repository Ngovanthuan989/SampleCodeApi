<?php


namespace App\Repositories;


class CustomerRepository extends Repository
{
    public function __construct() {
        parent::__construct(new \App\Models\Customer());
        $this->fields = ['id','name','phone','email', 'created_at', 'updated_at'];
        $this->primaryKey = "id";
    }

}
