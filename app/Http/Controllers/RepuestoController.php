<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Repuesto;

class RepuestoController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:ver-repuesto|crear-repuesto|editar-repuesto|borrar-repuesto')->only('index');
         $this->middleware('permission:crear-repuesto', ['only' => ['create','store']]);
         $this->middleware('permission:editar-repuesto', ['only' => ['edit','update']]);
         $this->middleware('permission:borrar-repuesto', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
         //Con paginación, para definir en este caso que despues de 5 repuestos creados cree la paginacion
         $repuestos = Repuesto::paginate(4);
         return view('repuestos.index',compact('repuestos'));
         //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $blogs->links() !!}    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('repuestos.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,svg,jpg,webp,gif|max:1024',
        ]);
    
        $repuesto = $request->all();

        if($imagen = $request->file('imagen')) {
            $rutaGuardarImg = 'imagen/';
            $imagenRepuesto = date('YmdHis'). "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenRepuesto);
            $repuesto['imagen'] = "$imagenRepuesto";             
        }
        
        Repuesto::create($repuesto);
        return redirect()->route('repuestos.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Repuesto $repuesto)
    {
        return view('repuestos.editar',compact('repuesto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repuesto $repuesto)
    {
       
        $request->validate([
            'nombre' => 'required'
        ]);
         $rpto = $request->all();
         if($imagen = $request->file('imagen')){
            $rutaGuardarImg = 'imagen/';
            $imagenRepuesto = date('YmdHis') . "." . $imagen->getClientOriginalExtension(); 
            $imagen->move($rutaGuardarImg, $imagenRepuesto);
            $rpto['imagen'] = "$imagenRepuesto";
         }else{
            unset($rpto['imagen']);
         }
         $repuesto->update($rpto);
         return redirect()->route('repuestos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repuesto $repuesto)
    {
        $repuesto->delete();
    
        return redirect()->route('repuestos.index');
    }
}

