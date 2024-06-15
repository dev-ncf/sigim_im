<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Extension;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    {
        $dadosUsuario = Manager::find(Auth::id());
        $query = Manager::query();
        if($request->has('manager_name') && !empty($request->manager_name)){
            $query->where('first_name','like','%'.$request->manager_name.'%')->orWhere('last_name','like','%'.$request->manager_name.'%');

        }
        if($request->has('extension_id') && !empty($request->extension_id)){
            $query->where('extension_id','=',$request->extension_id);

        }
        if($request->has('manager_email') && !empty($request->manager_email)){
            $query->where('email','like','%'.$request->manager_email.'%');

        }
        $managers = $query->get();
        $extensoes = Extension::get();

        return view('web.admin.manager.list',compact('managers','extensoes','dadosUsuario'));
        //
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
    public function show(Manager $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manager $manager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manager $manager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manager $manager)
    {
        //
    }
}
