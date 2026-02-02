<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->regenerate();
            return $this->redirectBasedOnRole();
        }

        return back()->with('error', 'Email or password is incorrect.')->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        // Load position relationship if not already loaded
        if (!$user->relationLoaded('position')) {
            $user->load('position');
        }

        // Check position code
        if ($user->position) {
            $positionCode = $user->position->code;

            if ($positionCode === 'ADM') {
                return redirect()->route('admin.dashboard');
            } elseif ($positionCode === 'DOK') {
                return redirect()->route('dokter.dashboard');
            } elseif ($positionCode === 'APT') {
                return redirect()->route('apoteker.dashboard');
            }
        }

        // Fallback if no position found
        return redirect('/')->with('error', 'No role assigned to your account.');
    }

}
