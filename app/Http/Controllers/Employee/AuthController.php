<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private function _logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('employee')->user();
        // if ($user) {
        //     $user->setLastActivity('Logout');
        // }
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function login(Request $request)
    {
        if ($request->getMethod() === 'GET') {
            return inertia('employee/auth/Login');
        }

        // kode dibawah ini untuk handle post

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'NIK harus diisi.',
            'password.required' => 'Kata sandi harus diisi.',
        ]);

        // basic validations
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // extra validations
        $data = $request->only(['username', 'password']);
        $data['nik'] = $data['username'];
        unset($data['username']);

        if (!Auth::guard('employee')->attempt($data, $request->has('remember'))) {
            $validator->errors()->add('username', 'Username atau password salah!');
        } else if (!Auth::guard('employee')->user()->active) {
            $validator->errors()->add('username', 'Akun anda tidak aktif. Silahkan hubungi administrator!');
            $this->_logout($request);
        } else {
            /** @var \App\Models\employee $user */
            $user = Auth::guard('employee')->user();
            $user->setLastLogin();
            $user->setLastActivity('Login');
            $request->session()->regenerate();
            return redirect(route('employee.dashboard'));
        }

        return redirect()->back()->withInput()->withErrors($validator);
    }

    public function logout(Request $request)
    {
        $this->_logout($request);
        return redirect('/')->with('success', 'Anda telah logout.');
    }

    public function forgotPassword(Request $request) {
        if ($request->getMethod() === 'GET') {
            return inertia('admin/auth/ForgotPassword');
        }

    }
}
