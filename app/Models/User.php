<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    use HasFactory;
    //1.关联的数据表(已经按照laravrl规范命名的数据库名称自动关联)
    //如果已经设置了表前缀，这里也不需要加前缀
    //protected $table = 'users';

    //2.主键,laravrl默认主键名称为'id'
    protected $primaryKey = 'user_id';

    //3.是否允许批量操作的字段
    //public $fillable = ['user_name','user_pass','email','phone'];
    //全部允许
    public $guarded = [];

    //4.是否维护create_at和update_at,系统默认维护
    //public $timestamp = false;


}













// class User extends Authenticatable
// {
//     use HasApiTokens, HasFactory, Notifiable;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array<int, string>
//      */
//     protected $fillable = [
//         'name',
//         'email',
//         'password',
//     ];

//     /**
//      * The attributes that should be hidden for serialization.
//      *
//      * @var array<int, string>
//      */
//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     /**
//      * The attributes that should be cast.
//      *
//      * @var array<string, string>
//      */
//     protected $casts = [
//         'email_verified_at' => 'datetime',
//     ];
// }
