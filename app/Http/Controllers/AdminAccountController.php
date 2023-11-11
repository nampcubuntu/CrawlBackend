<?php

namespace App\Http\Controllers;

use App\Models\AdminAccount;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = AdminAccount::all();
        return response()->json(['message' => 'Account list', 'data' => $accounts], 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $newAccount = [
                'login_url' => $request->input('login_url'),
                'account_name'=> $request->input('account_name'),
                'password'=> $request->input('password'),
                'post_new_url'=> $request->input('post_new_url'),
                'post_save_url'=>$request->input('post_save_url'),
            ];
            $adminAccount = AdminAccount::create($newAccount);
    
            return response()->json(['message' => 'Domain created successfully', 'data' => $adminAccount], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create domain', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
