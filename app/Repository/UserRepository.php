<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Shared\Repository;

class UserRepository extends Repository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
