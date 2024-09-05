<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Manager;
use App\Models\MovementStudent;
use App\Models\Student;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class MovementStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(LoginController::logado()){
        $query = MovementStudent::query();
        if($request->has('receipt_number') && !empty($request->receipt_number)){
            $query->where('receipt_number','like','%'.$request->receipt_number.'%');

        }
        if($request->has('student_code') && !empty($request->student_code)){
            $student = Student::where('code','=',$request->student_code)->first();
            $query->where('student_id','=',$student->id);

        }
        if($request->has('month') && !empty($request->month)){
            $query->where('month','like','%'.$request->month.'%');

        }
        if($request->has('semestre') && !empty($request->semestre)){
            $query->where('semestre','=',$request->semestre);

        }
        $dadosUsuario = Manager::find(Auth::id());
        $query->orderBy('id','desc');
        $propinas = $query->get();
        return view('web.admin.Movement.list', compact('dadosUsuario', 'propinas'));
        //
        }else{
            return redirect()->route('login');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MovementStudent $movementStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MovementStudent $movementStudent)
    {
        if(LoginController::logado()){
         $dadosUsuario = Manager::find(Auth::id());
        return view('web.admin.Movement.edit',compact('movementStudent','dadosUsuario'));
        }else{
            return redirect()->route('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MovementStudent $movementStudent)
    {
        //
        DB::beginTransaction();
        $dados = $request->all();
        try {
            //code...
            $movementStudent->update($dados);
            return back()->with(['success'=>'Propina actualizada com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MovementStudent $movementStudent)
    {
        //

         DB::beginTransaction();
        try {
            //code...
            $movementStudent->delete();
            return back()->with(['success'=>'Propina excluida com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }

    }
}
