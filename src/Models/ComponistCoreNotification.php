<?php

namespace Componist\Core\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Componist\Core\Notifications\ComponistCoreNotification\MessageNotification;


class ComponistCoreNotification extends Model
{
     use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
     'user_id',
     'title',
     'message',
 ];



 public static function CreateMessage(int|string $val, string $title, string $message): ?self
 {
     $userId = null;
     
     if(is_int($val)){
          if($user = User::where('id',$val)->first()){
               $userId = $user['id'];
          }
      }

      if(is_string($val)){
          if($user = User::where('email',$val)->first()){

              if($user['id']){
                  $userId = $user['id'];
              }
          }
      }


      if(is_int($userId)){

          if($result = self::create([
               'user_id' => $userId,
               'title' => trim($title),
               'message' => trim($message),
               'created_at' => date('Y-m-d H:i:s')
          ])){
               if($user){

                    Notification::send($user, new MessageNotification());
               }
               
               return $result;
          }
     }

     return null;
 }
    
}