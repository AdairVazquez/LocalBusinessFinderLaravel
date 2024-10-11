<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\ServiceAccount;


class CategoriaController extends Controller
{
    protected $database;
    protected $storage;

    public function __construct(Database $database)
    {
        // Aqui se cargan las credenciales y la URL desde el archivo .env
         // Inicialización de Firebase Auth
         $this->auth = (new Factory)
         ->withServiceAccount(base_path('local-business-finder-yapp-firebase-adminsdk-5wwjf-5487f1be4f.json'))
         ->createAuth();
     
     // Inicialización de Firebase Database
     $this->database = (new Factory)
         ->withServiceAccount(base_path('local-business-finder-yapp-firebase-adminsdk-5wwjf-5487f1be4f.json'))
         ->withDatabaseUri(env('FIREBASE_DATABASE_URL'))
         ->createDatabase();
     
     $this->tabla = 'categoria_negocio';

     // Inicialización de Firebase Storage
     $this->storage = (new Factory)
         ->withServiceAccount(base_path('local-business-finder-yapp-firebase-adminsdk-5wwjf-5487f1be4f.json'))
         ->createStorage();
    }

    public function listarCategorias()
    {
        $categorias = $this->database->getReference('categoria_negocio')->getValue();
        return view('pages.registroTienda', compact('categorias'));
    }

    public function listarCategorias2()
    {
        $categorias = $this->database->getReference('categoria_negocio')->getValue();
        return view('pages.adminPages.listaCategorias', compact('categorias'));
    }

    public function agregarNuevaCategoria(Request $request)
    {
        $file = $request->file('image');
        dd($request);
        $fileName = $file->getClientOriginalName();
        $bucket = $this->storage->getBucket();
        $bucket->upload(
            file_get_contents($file->getRealPath()),
            [
                'name' => $fileName
            ]
        );

        $imageUrl = $bucket->object($fileName)->signedUrl(new \DateTime('tomorrow'));

        $newCategory = $this->database
            ->getReference('categoria_negocio')
            ->push([
                'img_url' => $imageUrl,
                'info' => $request->input('info'),
                'tipo_negocio' => $request->input('tipo_negocio')
            ]);
        //return redirect()->route('categorias.index');
    }

    public function editarCategoria(Request $request, $id)
    {
        $categoria = $this->database->getReference('categoria_negocio/' . $id)->getValue();

        if ($request->isMethod('post')) {
            $file = $request->file('image');
            if ($file) {
                $fileName = $file->getClientOriginalName();
                $bucket = $this->storage->getBucket();
                $bucket->upload(
                    file_get_contents($file->getRealPath()),
                    [
                        'name' => $fileName
                    ]
                );

                $imageUrl = $bucket->object($fileName)->signedUrl(new \DateTime('tomorrow'));
                $categoria['img_url'] = $imageUrl;
            }
            $categoria['info'] = $request->input('info');
            $categoria['tipo_negocio'] = $request->input('tipo_negocio');

            $this->database->getReference('categoria_negocio/' . $id)->set($categoria);

            return redirect()->route('categorias.index');
        }

        return view('categorias.edit', compact('categoria', 'id'));
    }

    public function eliminarCategoria($id)
    {
        $this->database->getReference('categoria_negocio/' . $id)->remove();
        return redirect()->route('categorias.index');
    }

    public function agregarNuevaSubcategoria(Request $request)
    {
        $negocio = $request->tipo_negocio;
        $info = $request->info;
        $image = $request->imagen;
        $categoria = $request->categoria;
        if(!$negocio){
            $categorias = $this->database->getReference('categoria_negocio')->getValue();
            if ($request->isMethod('post')) {
                $file = $request->file('imagenLocal');
                $fileName = $file->getClientOriginalName();
                $bucket = $this->storage->getBucket();
                $bucket->upload(
                file_get_contents($file->getRealPath()),
                [
                    'name' => $fileName
                ]
                );

                $imagenUr = $bucket->object($fileName)->signedUrl(new \DateTime('+6 months'));

                $reference = $this->database->getReference($this->tabla)
                ->orderByChild('tipo_negocio')
                ->equalTo($categoria)
                ->getValue();
                $key = array_keys($reference);
                $firtKey = $key[0];
                $data = [
                    'id_categoria' => $firtKey,
                    '_token' => $request->_token,
                    'nombre_negocio' => $request->input('nombre_negocio'),
                    'Direccion' => $request->input('Direccion'),
                    'lat' => $request->input('lat'),
                    'lng' => $request->input('lng'),
                    'telefono' => $request->input('telefono'),
                    'correo' => $request->input('correo'),
                    'instagram' => $request->input('instagram'),
                    'whatsapp' => $request->input('whatsapp'),
                    'facebook' => $request->input('facebook'),
                    'telegram' => $request->input('telegram'),
                    'youtube' => $request->input('youtube'),
                    'tiktok' => $request->input('tiktok'),
                    'info_adicional' => $request->input('info_adicional'),
                    'imagen' => $imagenUr,
                    'categoria' => $negocio,
                ];
                $this->database->getReference('subcategoria_negocio')->push($data);
            }
        }else{
            //dd($request);
            $file = $request->file('imagen');
            //dd($file);
            $fileName = $file->getClientOriginalName();
            $bucket = $this->storage->getBucket();
            $bucket->upload(
                file_get_contents($file->getRealPath()),
                [
                    'name' => $fileName
                ]
            );

            $imageUrl = $bucket->object($fileName)->signedUrl(new \DateTime('+6 months'));

           $newCategory = $this->database
            ->getReference('categoria_negocio')
            ->push([
                'img_url' => $imageUrl,
                'info' => $request->input('info'),
                'tipo_negocio' => $request->input('tipo_negocio')
            ]);
            

            $reference = $this->database->getReference($this->tabla)
            ->orderByChild('tipo_negocio')
            ->equalTo($negocio)
            ->getValue();
            $key = array_keys($reference);
            $firtKey = $key[0];
            //dd($firtKey);

            $categorias = $this->database->getReference('categoria_negocio')->getValue();
            if ($request->isMethod('post')) {
                $data = [
                    'id_categoria' => $firtKey,
                    '_token' => $request->_token,
                    'nombre_negocio' => $request->input('nombre_negocio'),
                    'direccion' => $request->input('Direccion'),
                    'lat' => $request->input('lat'),
                    'lng' => $request->input('lng'),
                    'telefono' => $request->input('telefono'),
                    'correo' => $request->input('correo'),
                    'instagram' => $request->input('instagram'),
                    'whatsapp' => $request->input('whatsapp'),
                    'facebook' => $request->input('facebook'),
                    'telegram' => $request->input('telegram'),
                    'youtube' => $request->input('youtube'),
                    'tiktok' => $request->input('tiktok'),
                    'info_adicional' => $request->input('info_adicional'),
                ];
                $file = $request->file('imagen');
                $fileName = $file->getClientOriginalName();
                $bucket = $this->storage->getBucket();
                $bucket->upload(
                    file_get_contents($file->getRealPath()),
                    [
                        'name' => $fileName
                    ]
                );

                $imageUrl = $bucket->object($fileName)->signedUrl(new \DateTime('+6 months'));
                $data['imagen'] = $imageUrl;
 
                $this->database->getReference('subcategoria_negocio')->push($data);
            }
        }
        
    }

}
