<?php

   namespace App\Http\Responses;

   use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

   class LogoutResponse implements LogoutResponseContract
   {
       public function toResponse($request)
       {
           // This forces Laravel to go to the login page after logout
           return redirect('/login');
       }
   }
