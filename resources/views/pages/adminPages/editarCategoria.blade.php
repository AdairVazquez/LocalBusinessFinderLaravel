@extends('pages.adminPages.appAdmin')

@section('content')
<main class="container text-center">
    <h1>Editar Categoría</h1>
    <form action="{{ route('categoria.edit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @foreach ($categoria as $key=>$data)
            
            <div class="form-group">
                <label for="tipo_negocio">Tipo de Negocio</label>
                <input type="text" value="{{$data['tipo_negocio']}}" class="form-control" id="tipo_negocio" name="tipo_negocio">
            </div>

            <div class="form-group">
                <label for="info">Información de la categoria</label>
                <input type="text" value="{{$data['info']}}" class="form-control" id="info" name="info">
            </div>

            <h3>Imagen actual</h3>
            <img src="{{$data['img_ur']}}" alt="">

            <div class="form-group">
                <label for="image">Imagen</label>
                <input type="file" value="{{$data['img_url']}}" class="form-control" id="image" name="image">
            </div>
        @endforeach
        
        <button type="submit" class="btn btn-success">Editar Categoría</button>
    </form>
</main>
@endsection