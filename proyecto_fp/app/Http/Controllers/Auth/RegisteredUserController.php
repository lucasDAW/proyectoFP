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
        
        
//        var_dump($request->id_usuario);
//        var_dump($request->name);
//        var_dump($request->email);
        if($request->id_usuario and Auth::check()){
            
            $request->validate([
                  'name' => ['required', 'string', 'max:255'],
                'password' => ['required'],
            ]);
            $usuario = User::find($request->id_usuario);
            $usuario->name=$request->name;
            $usuario->password=Hash::make($request->password);
            $usuario->save();
           
            
            return redirect('/miperfil/'.Auth::user()->id)->with('mensaje', 'Se han modificado los datos del usuario correctamente');
 
        }else{
            
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
//            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password' => ['required'],
        ]);
        
        
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
//            'apellidos' => $request->apellidos,
//            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

//       
        event(new Registered($user));


        return redirect()->route('login')->with('mensaje', 'Se ha creado el usuario correctamente, por favor verifica tu correo');
    }
}
