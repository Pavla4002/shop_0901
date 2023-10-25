<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    //
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

        return response()->json('Вы успешно зарегистрировались',200);
    }
}
