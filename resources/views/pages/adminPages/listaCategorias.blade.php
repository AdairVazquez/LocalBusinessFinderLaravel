@extends('pages.adminPages.appAdmin')

@section('content')
<main class="container text-center">
    <h1>Lista de categorías registradas</h1>
    <div class="row align-items-center">
        @foreach ($categorias as $key=>$datos)
            <div class="col-md-4 mb-3">
                <div class="card" style="width: 18rem;">
                    <img src="{{$datos['img_url']}}" class="card-img-top" width="150px" height="200px" alt="...">
                    <div class="card-body">
                    <h5 class="card-title">{{$datos['tipo_negocio']}}</h5>
                    <p class="card-text">Información del negocio: {{$datos['info']}}</p>
                    <a href="{{url('editarCategoria/'.$key)}}" class="btn btn-primary">Editar</a>
                    <a href="#" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</main>
@endsection