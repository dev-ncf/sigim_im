<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Course;
use App\Models\DocumentType;
use App\Models\Extension;
use App\Models\Faculty;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Sabberworm\CSS\Property\AtRule;
use Throwable;

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
        $dadosUsuario = Manager::find(Auth::id());
        return view('web.admin.manager.show',compact('dadosUsuario','manager'));
    }
    public function userShow()
    {
        //
        $dadosUsuario = Manager::find(Auth::id());
        return view('web.admin.show',compact('dadosUsuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manager $manager)
    {
        //
        $dadosUsuario = Manager::find(Auth::id());
        $faculdades = Faculty::get();
        $extensions = Extension::get();
        $cursos = Course::get();
        $documentTypes = DocumentType::get();
        return view('web.admin.manager.edit',compact('documentTypes','extensions','dadosUsuario','manager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manager $manager)
    {
        //
        $dados = $request->all();
        DB::beginTransaction();
        try {
            $manager->update($dados);
            DB::commit();
            return redirect()->route('manager-list')->with(['success'=>'Dados actualizados com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }
    public function updatePassword(Request $request, Manager $manager)
    {
        //

        $dados = $request->all();

        DB::beginTransaction();
        try {
            if($request->password==$request->confir_password){
                $dados['password']=bcrypt($request->password);
                $manager->update($dados);
            }else{
                return back()->withErrors(['error'=>'Senhas não idênticas!']);
            }


            DB::commit();
            return redirect()->route('manager-show',$manager->id)->with(['success'=>'Senha actualizada com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }
    public function userUpdatePassword(Request $request, Manager $manager)
    {
        //

        $dados = $request->all();
       if(Auth::guard('manager')->attempt(['id'=>$manager->id,'password'=>$request->old_password])){
            DB::beginTransaction();
            try {
                if($request->password==$request->confir_password){
                    $dados['password']=bcrypt($request->password);
                    $manager->update($dados);
                }else{
                    return back()->withErrors(['error'=>'Senhas não idênticas!']);
                }


                DB::commit();
                return redirect()->route('manager-show',$manager->id)->with(['success'=>'Senha actualizada com sucesso!']);
            } catch (Throwable $th) {
                //throw $th;
                DB::rollBack();
                return back()->withErrors(['error'=>$th->getMessage()]);
            }
        }else{
             return back()->withErrors(['error'=>'Senha antiga incorrecta!']);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manager $manager)
    {
        //
        DB::beginTransaction();
        try {
            $manager->delete();
            DB::commit();
            return redirect()->route('manager-list')->with(['success'=>'Gestor excuido com sucesso!']);
        }catch (Throwable $th){
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);

        }
    }
    public function activeDeactive(Manager $manager)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            if( $manager->estado=='Activo'){
                $manager->update(['estado'=>'Inactivo']);


            }else{

                $manager->update(['estado'=>'Activo']);

            }


            DB::commit();
            return back()->with(['success'=>$manager->estado=='Activo'?'Manager '.$manager->first_name.' fio activado com sucesso!':'Manager '.$manager->first_name.' foi desactivado com sucesso!']);
        } catch (Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }
}
