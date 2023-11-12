<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        
        // Sử dụng dữ liệu đã được xác thực
        $credentials = [
            'email' => $validatedData['email'],
            'password' => $validatedData['password']
        ];
        
        $remember = true; // hoặc dựa trên một input từ form, ví dụ: $request->has('remember')
        if (Auth::attempt($credentials, $remember)) {
            // Authentication was successful
            return redirect()->intended('/admin/dashboards-analytics');
        } else {
            // Authentication failed
            return back()->withErrors(['email' => 'Thông tin đăng nhập không hợp lệ']);
        }
        
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::check()){  
            if (Gate::allows('is-admin')) {
                    return redirect('/admin/dashboards-analytics');
            } else {
                return view('welcome');
            }
        }else{
            return view('welcome');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function logout()
    {
        Auth::logout();

        return view('welcome');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
