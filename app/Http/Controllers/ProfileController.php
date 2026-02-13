<?php

namespace App\Http\Controllers;

use App\Models\MasterIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // If you're associating with a logged-in user

class ProfileController extends Controller
{
    /**
     * Display the basic details form.
     *
     * @return \Illuminate\View\View
     */
    public function showBasicDetailsForm()
    {
        // You might pre-populate some fields if the user already has data
        // $user = Auth::user();
        return view('profile.basic-details');
    }

    /**
     * Store the submitted basic details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBasicDetails(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'surname' => 'required|string|max:255',
            'given_name_1' => 'required|string|max:255',
            'given_name_2' => 'nullable|string|max:255',
            'given_name_3' => 'nullable|string|max:255',
            'given_name_4' => 'nullable|string|max:255',
            'given_name_5' => 'nullable|string|max:255',
            'mobile_number' => 'required|string|max:20', // Consider more specific phone validation
            'email' => 'required|string|email|max:255|unique:users,email,' . (Auth::id() ?? 'NULL'), // Unique for users table, ignore current user's email if updating
            'username' => 'required|string|min:4|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' checks for password_confirmation field
            'password_confirmation' => 'required|string|min:8',
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi harus minimal 8 karakter.',
            'username.unique' => 'Nama pengguna sudah terdaftar. Mohon pilih yang lain.',
            'email.unique' => 'Email ini sudah terdaftar. Mohon gunakan email lain.',
            // Add more custom messages as needed
        ]);

        // 2. Process the data (e.g., save to database)
        // If updating an existing user:
        // $user = Auth::user();
        // $user->surname = $validatedData['surname'];
        // $user->given_name_1 = $validatedData['given_name_1'];
        // ... (map all fields)
        // $user->email = $validatedData['email'];
        // $user->username = $validatedData['username'];
        // $user->password = bcrypt($validatedData['password']); // Hash the password
        // $user->save();

        // If creating a new user (during signup, for example):
        // use App\Models\User;
        // $user = User::create([
        //     'surname' => $validatedData['surname'],
        //     'given_name_1' => $validatedData['given_name_1'],
        //     // ... other given names
        //     'mobile_number' => $validatedData['mobile_number'],
        //     'email' => $validatedData['email'],
        //     'username' => $validatedData['username'],
        //     'password' => bcrypt($validatedData['password']),
        // ]);

        // 3. Redirect with a success message
        return redirect()->route('index')->with('success', 'Detail dasar Anda berhasil disimpan!');
        // Or redirect to the next step of the signup process
        // return redirect()->route('profile.review-submit');
    }

    public function cekNik($nik)
    {
        $identity = MasterIdentity::where('identity_number', $nik)->first();

        if ($identity) {
            return response()->json([
                'status' => true,
                'data' => $identity
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }
}