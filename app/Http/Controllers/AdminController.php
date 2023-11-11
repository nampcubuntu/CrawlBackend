<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function dashboardsAnalytics(){
        return view('layout.content.dashboard.dashboards-analytics');
    }

    public function generalTables()
    {
        return view('layout.content.tables.general-tables');
    }

    public function configTables()
    {
        return view('layout.content.tables.config-tables');
    }

    public function productTables()
    {
        return view('layout.content.tables.product-tables');
    }

    public function adminAccounts()
    {
        return view('layout.content.tables.admin-account-tables');
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
