<?php

namespace App\Http\Controllers;

use App\Models\EnrollmentPeriod;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $dadosUsuario = Manager::find(Auth::id());
        $periodos = EnrollmentPeriod::all();
        return view('web.admin.Periodo.list',compact(['periodos','dadosUsuario']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $dadosUsuario = Manager::find(Auth::id());
        return view('web.admin.Periodo.add',compact(['dadosUsuario']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        DB::beginTransaction();
        try {
            //code...
             EnrollmentPeriod::create($request->all());
             DB::commit();
             return back()->with(['success'=>'Periodo de inscrição registado com sucesso!']);
        } catch (Throwable  $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);

        }
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
    public function edit(EnrollmentPeriod $periodo)
    {
        //
        $dadosUsuario = Manager::find(Auth::id());
        return view('web.admin.Periodo.edit',compact(['dadosUsuario','periodo']));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EnrollmentPeriod $periodo)
    {
        //
         DB::beginTransaction();
        try {
            //code...
             $periodo->update($request->all());
             DB::commit();
             return back()->with(['success'=>'Periodo de inscrição actualizado com sucesso!']);
        } catch (Throwable  $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EnrollmentPeriod $periodo)
    {
        //
    }
}
