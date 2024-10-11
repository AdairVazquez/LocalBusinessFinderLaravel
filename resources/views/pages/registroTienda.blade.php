@extends('firebase.app')

<head>
    
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQ8agMsnkZNkUOwVIXjz37rVDGMSEJR1s&callback=initMap&libraries=places" async defer></script>
    <script>
        let map, marker;

        function initMap() {
            // Coordenadas de Lomas de Tecámac
            const tecamac = { lat: 19.655253237159656, lng: -98.99658121053943 };

            // Inicialización del mapa estándar centrado en Lomas de Tecámac
            map = new google.maps.Map(document.getElementById('map'), {
                center: tecamac,
                zoom: 14, // Ajusta el nivel de zoom si lo deseas
                mapTypeId: 'roadmap' // Este es el tipo de mapa estándar, no Street View
            });

            // Marcador inicial en Lomas de Tecámac
            marker = new google.maps.Marker({
                position: tecamac,
                map: map,
                draggable: true, // Permite arrastrar el marcador
            });

            // Evento para actualizar los valores de latitud y longitud cuando se mueva el marcador
            google.maps.event.addListener(marker, 'dragend', function() {
                const position = marker.getPosition();
                document.getElementById('lat').value = position.lat();
                document.getElementById('lng').value = position.lng();
            });
        }

        // Ejecutar initMap después de que el DOM esté completamente cargado
        window.onload = initMap;
    </script>
</head>
@section('content')
<main class="container">
<div class="containerr">
    <div class="form-section">
        <h2>Registrar una tienda</h2>
        <h5 style="color: red">* Campos obligatorios </h5>
        <form action="{{route('categorias.subcat')}}" method="post" enctype="multipart/form-data">
            @csrf
            <label for=""><b>Nombre del negocio</b><p style="color: red">*</p></label>
            <input type="text" name="nombre_negocio" placeholder="Nombre del negocio" required>
            <label for=""><b>Dirección</b><p style="color: red">*</p></label>
            <input type="text" name="Direccion" placeholder="Direccion" required>
            <label for=""><b>Arrastra el marcador a la ubicación de tu negocio.</b><p style="color: red">*</p></label>
            <div id="map"></div>
            <input type="hidden" id="lat" name="lat" required>
            <input type="hidden" id="lng" name="lng" required>
            <label for="">Contacto</label>
            <label for=""><b>Número telefonico</b><p style="color: red">*</p></label>
            <input type="tel" name="telefono" placeholder="Numero telefonico" required>
            <label for=""><b>Correo del negocio</b><p style="color: red">*</p></label>
            <input type="email" name="correo" placeholder="Correo del negocio" required>
            <label for=""><b>URL de tus Redes sociales</b></label>
            <div class="cont">
                <input type="text" name="instagram" placeholder="Instagram" >
                <input type="text" name="whatsapp" placeholder="WhatsApp" >
                <input type="text" name="facebook" placeholder="Facebook" >
            </div>
            <div class="cont">
                <input type="text" name="telegram" placeholder="Telegram" >
                <input type="text" name="youtube" placeholder="Youtube" >
                <input type="text" name="tiktok" placeholder="Tiktok" >
            </div>
            <textarea name="info_adicional" placeholder="Informacion adicional" ></textarea>

            <label for="imgLocal"><b>Agrega una imagen de la fachada de tu negocio</b><p style="color: red">*</p></label>
            <input type="file" id="imgLocal" name="imagenLocal" required>

            <div class="comb">
                <label for="categoria"><b>Seleccione una categoría:</b></label>
                <select id="categoria" name="categoria" onchange="mostrarInputOtro()" required>
                    <option value="" disabled selected>Seleccione...</option>
                    @foreach ($categorias as $key => $data)
                        <option value="{{ $data['tipo_negocio'] }}">{{ $data['tipo_negocio'] }}</option>
                    @endforeach
                    <option value="otro">Otro</option>
                </select>
            
                <!-- Input que aparecerá si se selecciona "Otro" -->
                <input type="text" id="otroInput" placeholder="Especifique el negocio" name="tipo_negocio">
                <input type="text" id="otroInput2" placeholder="Informacion de categoria" name="info">
                <input type="file" id="otroInput3" name="imagen" style="display: none;">
            </div>
            
            <button type="submit">Registrar negocio</button>
        </form>
    </div>
    
</div>
</main>
<script>
    function mostrarInputOtro() {
        var select = document.getElementById("categoria");
        var otroInput = document.getElementById("otroInput");
        var otroInput2 = document.getElementById("otroInput2");
        var otroInput3 = document.getElementById("otroInput3");

        // Muestra u oculta el input dependiendo de la selección
        if (select.value === "otro") {
            otroInput.style.display = "block";
            otroInput2.style.display = "block";
            otroInput3.style.display = "block"; // Muestra el input
        } else {
            otroInput.style.display = "none";
            otroInput2.style.display = "none";
            otroInput3.style.display = "none";// Oculta el input
            otroInput.value = ""; // Limpia el campo si se cambia la selección
            otroInput2.value = ""; // Limpia el campo si se cambia la selección
            otroInput3.value = ""; // Limpia el campo si se cambia la selección
        }
    }
</script>

@endsection