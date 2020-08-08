<?php

namespace App\Repository;

use Illuminate\Support\Collection;
use App\Model\User;

interface UserRepositoryInterface
{
   public function all(): Collection;
}