<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
   private $userRepository;
  
   public function __construct(UserRepositoryInterface $userRepository)
   {
       $this->userRepository = $userRepository;
   }

   public function index()
   {
       $users = $this->userRepository->all();

       return view('users.index', [
           'users' => $users
       ]);
   }
}
