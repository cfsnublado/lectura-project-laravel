<?php

namespace App\Repository\Eloquent;

use Illuminate\Support\Collection;
use App\Model\Project;

class ProjectRepository extends BaseRepository
{

   /**
    * UserRepository constructor.
    *
    * @param User $model
    */
   public function __construct(Project $model)
   {
       parent::__construct($model);
   }

   /**
    * @return Collection
    */
   public function all(): Collection
   {
       return $this->model->all();    
   }
}