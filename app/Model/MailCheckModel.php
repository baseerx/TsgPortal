<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use DB;
class MailCheckModel extends Model
{


   public function updatePassword(Request $request)
   {
       $password=$request->input('password');
       $password_confirmation=$request->input('password_confirmation');
       $email=$request->input('email');
       $User=User::whereEmail($email)->first();

       $id=User::find($User->id);
       $id->password=Hash::make($password);
       $id->save();
       return true;
   }
}
