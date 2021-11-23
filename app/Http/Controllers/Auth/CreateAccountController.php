<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;

class CreateAccountController extends Controller
{
    public function newAccount() {
        $states = $this->getStates();
        return view('pages.auth.register', ['states' => $states]);
    }

    public function createAccount(Request $request) {
        $email = $request->email;
        $password = trim($request->password);
        $insert = false;

        if(!$this->userExist($email)) {
            $insert = User::insert([
                'user_name'     => $request->name,
                'user_email'    => $request->email,
                'user_state'    => $request->state,
                'user_city'     => $request->city,
                'user_phone'    => $request->phone,
                'user_gender'   => $request->gender,
                'user_password' => Hash::make($password)
            ]);

            $message = $insert ? "Usuário cadastrado com sucesso!" : "Ocorreu um erro ao cadastrar usuário.";
        } else {
            $message = "Usuário informado já existe!";
        }

        return view('pages.auth.register')->with('message', $message)
                                                ->with('saved', $insert)
                                                ->with('states', $this->getStates());

    }

    private function userExist($email) {
        $user =  DB::select("SELECT * FROM users WHERE user_email = '$email'");
        return $user != null;
    }

    public function getStates() 
    {
        $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
        return $response->json();
    }

    public function getCities(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
            'status_code' => 400,
            'message' => 'Bad Request'
            ], 400);
        }

        $state = $request->state;
        $cities = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/$state/municipios");

        return response()->json([
            'status_code' => 200,
            'cities' => $cities->json()
        ], 200);
    }
}
