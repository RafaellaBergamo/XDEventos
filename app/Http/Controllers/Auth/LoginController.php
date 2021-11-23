<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\AuthHelper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function viewLogin() {
        if (AuthHelper::checkUserLogged()) {
            return redirect()->route('clients');
        }

        return view('pages.user-pages.login');
    }

    public function logout()
    {
        if(session()->exists('user')) {
            session()->flush();
            return redirect()->route('view-login');
        }
        else return redirect()->route('view-login');
    }

    public function loginUser(Request $request) {

        $password = trim($request->password);
        $email = $request->email;

        $user = collect(DB::select("SELECT * FROM users WHERE user_email = '$email'"))->first();

        if($user !== null) {
            if(Hash::check($password, $user->user_password)) {
                $userSession = [
                    'id'    => $user->id,
                    'name'  => $user->user_name,
                ];
    
                session()->put('user', (object) $userSession);
    
                $userSession = session()->get('user');
                $userSession->logged = true;
                

                return redirect()->route('clients');
            }
        }
        else {
            return view('pages.user-pages.login')->with('notfound', true);
        }
        
    }

}
