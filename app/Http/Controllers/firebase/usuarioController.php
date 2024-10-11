<?php

namespace App\Http\Controllers\firebase;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Database;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Kreait\Firebase\Factory;
use GuzzleHttp\Client;

class usuarioController extends Controller
{
    

    public function __construct(Database $database)
    {
        $this->auth = (new Factory)->withServiceAccount(base_path('local-business-finder-yapp-firebase-adminsdk-5wwjf-5487f1be4f.json')
        )->createAuth();
        $this->database = $database;
        $this->tabla='usuario';
    }

    public function login(Request $req){
        $correo = $req -> correo;
        $contraseña = $req -> contraseña;
        $reference = $this->database->getReference($this->tabla)
        ->orderByChild('correo')
        ->equalTo($correo)
        ->getValue();
       
        if (!empty($reference)){
            $usuario = reset($reference);
            $contraseñaDB = $usuario['contraseña'];
            if ($reference && Hash::check($req->contraseña, $contraseñaDB)) {
                Auth::login($usuario);

            } else {
                // Usuario no encontrado
                return redirect('login')->with('status', 'Contraseña incorrecta :c');
            }
        }else{
            return redirect('login')->with('status', 'No existe un usuario con este correo');
        }
        
    }

    public function index(){
       $usuarios = $this->database->getReference($this->tabla)->getValue();
       return view('pages.adminPages.listaUsuarios', compact('usuarios'));
    }

    public function create(){
        return view('firebase.usuarios.create');
    }

    public function store(Request $req){
        $contraseña = $req -> contra;
        $repContra = $req ->repContra;

        if($contraseña == $repContra ){
            $postData = [
                'nombre' => $req->nombre,
                'correo' => $req->correo,
                'contraseña' => Hash::make($contraseña),
            ];
            $postRef = $this->database->getReference($this->tabla)->push($postData);
            if($postRef){
                return redirect('login')->with('status','Usuario Agregado Satisfactoriamente, Por Favor Inicia Sesion');
            }else{
                return redirect('login')->with('status','Usuario NO Agregado');
            }    
        }else{
            //en este return quiero que se haga el envio de la alerta
            return redirect('login')->with('status', 'Las contraseñas no coinciden');
        }         
    }

    public function update($id){
        $key = $id;
        $editar = $this->database->getReference($this->tabla)->getChild($key)->getValue();
        if($editar){
            return view('firebase.usuarios.editar',compact('editar','key'));
        }else{
            return redirect('usuarios')->with('status','ID del usuario no registrado');
        }
    }

    public function save(Request $req, $id){
        $key = $id;
        $postData = [
            'nombre' => $req->nombre,
            'correo' => $req->correo,
            'contraseña' => $req->contra,
        ];
        $updUsuario=$this->database->getReference($this->tabla.'/'.$key)->update($postData);
        if($updUsuario){
            return redirect('usuarios')->with('status','Usuario Actualizado');
        }else{
            return redirect('usuarios')->with('status','Usuario No Actualizado');
        }
    }

    public function delete($id){
        $key = $id;
        $delUs=$this->database->getReference($this->tabla.'/'.$key)->remove();
        if($delUs){
            return redirect('usuarios')->with('status','Usuario Eliminado');
        }else{
            return redirect('usuarios')->with('status','Usuario No Eliminado');
        }
    }
    

    public function procesamientoGoogle(){
        $user = Socialite::driver('google')->user();
        //dd($user);
        $nombre = $user['name'];
        $id = $user['id'];
        $email = $user['email'];
        $avatarUrl = $user->avatar;

        $reference = $this->database->getReference($this->tabla)
        ->orderByChild('correo')
        ->equalTo($email)
        ->getValue();

        if (!empty($reference)){
            session(['user' => $reference]);
            return redirect()->route('homePage');
            echo('logeado');
        } else {
            $usuario = $datosUser = [
                'id' => $id,
                'nombre' => $nombre,
                'correo' => $email,
                'avatar' => $avatarUrl,
                'oAuth' => 'Google',
                'rol' => 'Locatario'
            ];
            $postRef = $this->database->getReference($this->tabla)->push($datosUser);

            $referenceNueva = $this->database->getReference($this->tabla)
            ->orderByChild('correo')
            ->equalTo($email)
            ->getValue();
            session(['user' => $referenceNueva]);
            return redirect()->route('homePage');
            echo('Registrado y logeado con exito');
        }
    }
    

    public function procesamientoGithub(){
        $user = Socialite::driver('github')->user();
        
        $nombre = $user['name'];
        $id = $user['id'];
        $email = $user['email'];
        $avatar = $user['avatar_url'];

        $reference = $this->database->getReference($this->tabla)
        ->orderByChild('correo')
        ->equalTo($email)
        ->getValue();

        if (!empty($reference)){  
            echo('logeado');
        } else {
            $usuario = $datosUser = [
                'id' => $id,
                'nombre' => $nombre,
                'correo' => $email,
                'avatar' => $avatar,
                'oAuth' => 'Github',
            ];
            $postRef = $this->database->getReference($this->tabla)->push($datosUser);
            
            echo('Registrado y logeado con exito');
        }
    }

    public function listadoUsuariosAndroid(){
        $userss = $this->auth->listUsers(1000);

        // Convierte el generador a una colección o array
        $users = iterator_to_array($userss);
    
        // Retorna la vista con la lista de usuarios
        return view('pages.adminPages.listaUsuarios')->with('users', $users);
    }
}
