<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\ValidaEmail;
use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    

    public function sendMail(Request $request) {
        $email = $request->email;
        
        if(!$this->userExist($email)) {
            return response()->json([
                'status_code' => 200,
                'success'     => false,
                'message'     => "Email não cadastrado."
            ]);
        }

        $token = $this->createToken();

        \Illuminate\Support\Facades\Mail::to($email)
        ->send(new \App\Mail\ValidaEmail(['token' => $token])); 

        return response()->json([
            'status_code' => 200,
            'success'     => true,
            'data' => [
                'token' => $token
            ]                
        ], 200);
    }

    public function viewChangePassword($email) {
        $user = collect(DB::select("SELECT * FROM users WHERE user_email = '$email' "))->first();
        return view('pages.user-pages.changepassword')->with('id', $user->id);
    }

    private function userExist($email) {
        $user =  DB::select("SELECT * FROM users WHERE user_email = '$email'");
        return $user != null;
    }


    public function changePassword(Request $request) 
    {
    
        $newPassword = Hash::make($request->password);

        $update = User::where("id", $request->id)->update([
            'user_password'  => $newPassword
        ]);

        $message = $update ? "Senha atualizada com sucesso! <br> Por favor, logue novamente." : "Ocorreu um erro ao atualizar senha. <br> Tente novamente mais tarde";

        return view('pages.user-pages.changepassword')->with('id', $request->id)->with('success', $update)->with('message', $message);
    }

    private function createToken() {
        $token = [];
        while(count($token) < 6 ) {
            $number = rand(0, 9);

            if (end($token) !== $number)
                $token[] = $number;
        }

        return implode('', $token);
    }
}


