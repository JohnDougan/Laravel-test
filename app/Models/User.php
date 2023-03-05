<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function auth(Request $request)
    {
        // Проверка наличия такого логина
        $id = DB::table('users')->where('login', $request->get('login'))->where('pass', md5($request->get('pass')))->value('id');
        if(!$id) {
            session(['errors'=>'Такой пользователь не найден на сайте!']);
            return false;
        }
        Auth::loginUsingId($id);
        return true;
    }

    public static function register(\Illuminate\Http\Request $request)
    {
        // Проверка наличия такого логина
        $check = DB::table('users')->where('login', $request->get('login'))->value('id');

        if($check) {
            session(['errors'=>'Такой логин уже есть на сайте!']);
            return false;
        }

        $params = [
            'login' => $request->get('login'),
            'pass' => md5($request->get('pass')),
            'type' => ($request->get('type')=='buyer')?'buyer':'seller',
        ];

        $id = DB::table('users')->insertGetId($params);
        Auth::loginUsingId($id);
        return true;
    }

    public static function getUserData($id)
    {
        return DB::table('users')->where('id', $id)->first();
    }
}
