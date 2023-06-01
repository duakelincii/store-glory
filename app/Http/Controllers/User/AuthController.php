<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Setting;
use App\Models\User;
use Exception;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return redirect("/");
        }
        $setting = Setting::first();
        return view('user.auth.login',compact('setting'));
    }

    //tambahkan script di bawah ini
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }


    //tambahkan script di bawah ini
    public function handleProviderCallback(Request $request)
    {
        try {
            $user_google    = Socialite::driver('google')->user();
            $user           = User::where('email', $user_google->getEmail())->first();

            //jika user ada maka langsung di redirect ke halaman home
            //jika user tidak ada maka simpan ke database
            //$user_google menyimpan data google account seperti email, foto, dsb

            if($user != null){
                Auth::login($user, true);
                return redirect()->route('home');
            }else{
                $create = User::Create([
                    'email'             => $user_google->getEmail(),
                    'name'              => $user_google->getName(),
                    'password'          => Hash::make('12345678'),
                    'google_id'         => $user_google->id,
                    'email_verified_at' => now()
                ]);


                Auth::login($create, true);
                return redirect()->route('app');
            }

        } catch (\Exception $e) {
            return redirect()->route('login');
        }


    }

    /**
     * REST Login
     *
     * @return json
     */
    public function authLogin()
    {
        $request = new LoginRequest();
        $validator = Validator::make(request()->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            $errors = Helpers::setErrors($validator->errors()->messages());
            return response()->json(['success' => false, 'error' => true, 'message' => $errors]);
        }
        try {
            $validated = $validator->validated();
            $remember_me = (@$validated['remember_me'] ? true : false);
            if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password'], 'is_admin' => '0'], $remember_me)) {
                return response()->json(['success' => true, 'message' => 'Login berhasil!']);
            }
            return response()->json(['success' => false, 'message' => 'Email atau password salah!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function register()
    {
        if (auth()->check()) {
            return redirect("/");
        }
        $setting = Setting::first();
        return view('user.auth.register',compact('setting'));
    }

    public function authRegister()
    {
        $request = new RegisterRequest();
        $validator = Validator::make(request()->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            $errors = Helpers::setErrors($validator->errors()->messages());
            return response()->json(['success' => false, 'error' => true, 'message' => $errors]);
        }
        try {
            $validated = $validator->validated();
            $user = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
            ];
            if (User::insert($user)) {
                return response()->json(['success' => true, 'message' => 'Akun telah dibuat']);
            }
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan! Coba beberapa saat lagi']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
