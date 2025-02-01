<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        
        
        return view('auth.register');    
        
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        
        
        $reglas=[
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
        ];
        $mensajeError = [
            'required' => 'Cuidado!! el campo :attribute esta vacío',
            'string'=>'Cuidado!! el campo :attribute debe ser un número entero',
            'unique'=>'Cuidado!! el campo :attribute ya esta en la base de datos',
        ];
        
        //si no se rellenan los campos
        $datosvalidados=$request->validate($reglas,$mensajeError);
        
//        var_dump($request->id_usuario);
//        var_dump($request->email);
        //modificar usuario
        if($request->id_usuario and Auth::check()){
            
            $usuario = User::find($request->id_usuario);
            $usuario->name=$request->name;
            $usuario->password=Hash::make($request->password);
            $usuario->save();
            return redirect('/miperfil/'.Auth::user()->id)->with('mensaje', 'Se han modificado los datos del usuario correctamente');
 
        }else{
            
            //crear usuario
            $user = User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            event(new Registered($user));
            return redirect()->route('login')->with('mensaje', 'Se ha creado el usuario correctamente, por favor verifique su correo');
        }
    }
}
