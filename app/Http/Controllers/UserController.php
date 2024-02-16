<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    //
    public function index_user(){
        return view('user.index');
    }

    public function registration(Request $request){
        $valid = Validator::make($request->all(),[
            'fio'=>['required', 'regex:/[а-яА-ЯёЁ ]*/u'],
            'birthday'=>['date'],
            'phone'=>['required','unique:users','digits:11'],
            'email'=>['required','unique:users','email:dns,rfc'],
            'password' => ['required', 'confirmed','max:8', Password::min(4)->numbers()],
        ])->validate();
        $valid['password']= md5($valid['password']);
        User::query()->create($valid);
        return response()->json('Вы успешно зарегистрировались');
    }

    public function Auth(Request $request){
        $valid = Validator::make($request->all(),[
            'password' => ['required','max:8', Password::min(4)->numbers()],
            'login'=>['required'],
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }

        $user = User::query()
            ->where('phone', $request->login)
            ->orWhere('email', $request->login)
            ->where('password',md5($request->password))->first();
        if($user){
            Auth::login($user);
            if($user->role===0){
                return redirect()->route('index_user');
            }else{
                return redirect()->route('index_admin');
            }
        }else{
            return response()->json('Неверный логин или пароль',404);
        }
    }

    public function exit(){
        Auth::logout();
        return redirect()->route('welcome');
    }
}
