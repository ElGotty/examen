<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TareasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tareas = Tarea::where('status',0)->get();
        return view('tareas.index',compact('tareas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('tareas.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre'=>['required','string','max:100'],
            'descripcion'=>['required','string','max:100'],
            'usuariosA'=>['required','max:100'],
            'fechainicio'=>['required','string','max:100'],
            'fechavencimiento'=>['required','string','max:100'],
        ]);

        if($validator->fails()){
            return redirect()->route('tareas.create')->withInput()->withErrors($validator->errors());
        }
        else{
            $data = $request->except('_token');
            $tarea = Tarea::create($request->all());
            $usuarios = $request->input('usuariosA');
            foreach($usuarios as $usuario){
                $user = User::find($usuario);
                $tarea->users()->save($user);
            }


            return redirect()->route('tareas.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tarea $tarea)
    {
        return view('tareas.show',compact('tarea'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarea $tarea)
    {
        $users = User::all();
        return view('tareas.edit', compact('tarea','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->input('terminar')){
            $tarea = Tarea::find($id);
            $tarea->update(['status'=>1]);
        }
        else{
            $validator = Validator::make($request->all(),[
                'nombre'=>['required','string','max:100'],
                'descripcion'=>['required','string','max:100'],
                'usuariosA'=>['required','max:100'],
                'fechainicio'=>['required','string','max:100'],
                'fechavencimiento'=>['required','string','max:100'],
            ]);

            if($validator->fails()){
                return redirect()->route('tareas.edit', $id)->withInput()->withErrors($validator->errors());
            }
            else{

                $tarea = Tarea::find($id);
                $tarea->users()->detach();
                $tarea->update($request->all());
                $usuarios = $request->input('usuarios');
                foreach($usuarios as $usuario){
                    $user = User::find($usuario);
                    $tarea->users()->save($user);
                }



            }
        }

        return redirect()->route('tareas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        return redirect()->route('tareas.index');

    }

    public function TareasFinalizadas()
    {
        $tareas = Tarea::where('status',1)->paginate();
        return view('tareas.tareasfinalizadas',compact('tareas'));
    }
}
