<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Extension;
use App\Models\Faculty;
use App\Models\Manager;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     private function dadosUsuario(){
        $dadosUsuario = Manager::find(Auth::id());
        return $dadosUsuario;
    }
    public function index(Request $request)
    {
        //
        if(LoginController::logado()){
        $query = Faculty::query();
        $dadosUsuario = $this->dadosUsuario();
        // dd($faculties);

        if(isset($request->nome) && !empty($request->nome)){
            $query->where('label','like','%'.$request->nome.'%');
        }
        if(isset($request->extension_id) && !empty($request->extension_id)){
            $query->where('extension_id','=',$request->extension_id);
        }
        $faculties =  $query->get();
        $faculties->load('extensao');
        $extensaos =Extension::all();
        return view('web.admin.Faculty.list',compact(['faculties','dadosUsuario','extensaos']));
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
        if(LoginController::logado()){
         $extensaos = Extension::all();
         $dadosUsuario = $this->dadosUsuario();
         return view('web.admin.Faculty.add',compact(['extensaos','dadosUsuario']));
         }else{
            return redirect()->route('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['label'=>'required','extension_id'=>'required']);
        DB::beginTransaction();
        try {
            //code...
            Faculty::create($request->all());
            DB::commit();
            return back()->with(['success'=>'Faculdade registada com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty)
    {
        //
        if(LoginController::logado()){
        $extensaos = Extension::all();
         $dadosUsuario = $this->dadosUsuario();
         $courses = Course::where('faculty_id','=',$faculty->id)->get();
         $students = StudentEnrollment::where('faculty_id','=',$faculty->id)->where('semestre','=','1')->get();
        //  dd($students);
         return view('web.admin.Faculty.show',compact(['extensaos','dadosUsuario','faculty','courses','students']));
         }else{
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faculty $faculty)
    {
        //
        if(LoginController::logado()){
        $extensaos = Extension::all();
         $dadosUsuario = $this->dadosUsuario();
         return view('web.admin.Faculty.edit',compact(['extensaos','dadosUsuario','faculty']));
         }else{
            return redirect()->route('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faculty $faculty)
    {
        //
        //  $request->validate(['label'=>'required','extension_id'=>'required']);
        DB::beginTransaction();
        try {
            //code...
            $faculty->update($request->all());
            DB::commit();
            return back()->with(['success'=>'Faculdade actualizada com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            $faculty->delete();
            DB::commit();
            return back()->with(['success'=>'Faculdade excluida com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }
}
