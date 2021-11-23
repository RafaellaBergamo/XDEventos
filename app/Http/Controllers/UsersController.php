<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Auth\CreateAccountController;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersController extends Controller
{

    public function viewUsers() {
        $registerController = new CreateAccountController();
        $states = $registerController->getStates();

        return view('pages.users.index')->with('states', $states);
    }

    public function getUsers(Request $request) {
        $registerController = new CreateAccountController();
        $states = $registerController->getStates();

        $city = isset($request->city) ? $request->city : null;
        $sit = isset($request->sit) ? $request->sit : null;

        $query = "SELECT * FROM users WHERE 1 ";
        if($request->state != null) {
            $query .= "AND user_state = '$request->state'";
        }
        if($request->city != null) {
            $query .= "AND user_city = '$request->city'";
        }
        if($request->name != null) {
            $query .= "AND user_name LIKE '$request->name%'";
        }
        if($sit != null) {
            $query .= "AND user_sit = '$sit'";
        }

        $users = DB::select($query);

        return view('pages.users.index')->with('states', $states)->with('users', $users);
    }


    public function newUser() {
        $registerController = new CreateAccountController();
        $states = $registerController->getStates();
        $lastId = User::latest('id')->first();

        $nextId = $lastId == null ? 1 : $lastId->id + 1;

        return view('pages.users.newuser')->with('states', $states)->with('next', $nextId);
    }

    public function saveUser(Request $request) 
    {
        $password = trim($request->password);
        $origin = $request->facebook;
        $registerController = new CreateAccountController();
        $states = $registerController->getStates();

        $insert = false;
        if(!$this->userExist($request->email)) {
            $insert = User::insert([
                'user_name'     => $request->name,
                'user_email'    => $request->email,
                'user_state'    => $request->state,
                'user_city'     => $request->city,
                'user_phone'    => $request->phone,
                'user_sit'      => $request->sit,
                'user_gender'   => $request->gender,
                'user_password' => Hash::make($password)
            ]);

            $message = $insert ? "Usuário cadastrado com sucesso!" : "Ocorreu um erro ao cadastrar usuário.";
        }
        else {
            $message = "Usuário informado já cadastrado!" ;
        }

        return view('pages.users.newuser')->with('message', $message)->with('saved', $insert)
                                              ->with('next', "")->with('states', $states);
    }

    public function deleteUser(Request $request) {
        if (!$request->ajax()) {
            return response()->json([
            'status_code' => 400,
            'message' => 'Bad Request'
            ], 400);
        }

        $delete = User::where("id", $request->id)->delete();
       
        return response()->json([
            'status_code' => 200,
            'success'     => $delete
        ]);
    }

    public function viewUpdateUser($id) {
        
        $user = User::find($id);

        $registerController = new CreateAccountController();
        $states = $registerController->getStates();

        $cities = $this->getCities($user->user_state);

        return view('pages.users.updateuser')->with("user", $user)->with("states", $states)->with("cities", $cities);
    }

    public function updateUser(Request $request) {

        $user = User::find($request->id);
        $registerController = new CreateAccountController();
        $states = $registerController->getStates();
        $cities = $this->getCities($user->user_state);
        
        $password = $request->password != null ? $request->password : null;

        $origin = $request->facebook;

        $update = false;

        $passwordOk = $password != null ? Hash::check($password, $user->user_password) : false;

        if(!$passwordOk) {
            $message = "Senha atual incorreta!";
            return view('pages.users.updateuser')->with("user", $user)->with("states", $states)
            ->with("cities", $cities)->with("saved", $update)->with("message", $message);
        }


        $update = User::where("id", $request->id)->update([
            'user_name'     => $request->name  != null ? $request->name : $user->user_name,
            'user_email'    => $request->email != null ? $request->email : $user->user_email,
            'user_state'    => $request->state != null ? $request->state : $user->user_state, 
            'user_city'     => $request->city != null ? $request->city : $user->user_city,
            'user_phone'    => $request->phone != null ? $request->phone : $user->user_phone,
            'user_gender'   => $request->gender != null ? $request->gender : $user->user_gender,
            'user_sit'      => $request->sit != null ? $request->sit : $user->user_sit,
            'user_password' => !$passwordOk ? $user->user_password : Hash::make($request->newpassword),
        ]);

        $message = $update ? "Usuário atualizado com sucesso!" : "Ocorreu um erro ao atualizar usuário.";

        return view('pages.users.updateuser')->with("user", $user)->with("states", $states)
                                                 ->with("cities", $cities)->with("saved", $update)->with("message", $message);
    }

    public function getCities($state)
    {
        $cities = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/$state/municipios");

        return $cities->json();
    }

    private function userExist($email) {
        $user =  DB::select("SELECT * FROM users WHERE user_email = '$email'");
        return $user != null;
    }

}
