<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function showLogin()
   {
       return view('auth.login');
   }

   public function showRegister()
   {
       return view('auth.register'); // Ensure you have a register.blade.php file in resources/views/auth/
   }

   public function showRegisterNextPage()
   {
       return view('auth.register-next-page'); // Ensure you have a register.blade.php file in resources/views/auth/
   }

   public function showEmployerLogin()
   {
       return view('auth.employer.employer-login'); // Ensure you have a register.blade.php file in resources/views/auth/
   }
}
