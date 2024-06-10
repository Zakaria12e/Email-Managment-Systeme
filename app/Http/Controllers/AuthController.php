<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function signup(){
        return view('auth.signup');
    }

    public function postsignup(Request $request)
    {
        $check_email = User::where('email', $request->email)->first();
        if($check_email){
            return back()->with('error', 'Email déjà utilisé !!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.pages');
    }

    public function postlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.pages');
        } else {
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect !!');
        }
    }

    public function logout(Request $request)
   {
       Auth::logout();
       $request->session()->invalidate();
       $request->session()->regenerateToken();

       return redirect()->route('login')->withHeaders([
           'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
           'Pragma' => 'no-cache',
           'Expires' => '0',
       ]);
   }
}
