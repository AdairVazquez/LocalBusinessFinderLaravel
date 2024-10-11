<?php
$reference = session('user');
$id = null; // Inicializa la variable
    if ($reference && is_array($reference) && count($reference) > 0) {
        // Accede al primer elemento del arreglo usando la clave
        $id = array_key_first($reference);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>¡Bienvenido!</title>
</head>
<body>
    <div class="degradado">
        <div class="sidebar" id="mySidebar">
            <div class="d-flex flex-column align-items-center mb-4">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo">
                <span class="text-center">Local Business Finder</span>
            </div>
            <div>
                <a href="#home" class="d-flex align-items-center"><i class="fas fa-home me-2"></i> Inicio</a>
                <a href="#services" class="d-flex align-items-center active"><i class="fas fa-shop me-2"></i> Tiendas</a>
                <a href="#clients" class="d-flex align-items-center"><i class="fas fa-user me-2"></i> Clientes</a>
            </div>
            <!-- Elemento Contacto en la parte inferior -->
            <a href="#" class="d-flex align-items-center mt-auto"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>

        </div>
        
        
        
        <!-- Botón para abrir el menú en pantallas pequeñas -->
        <button class="open-btn" onclick="toggleSidebar()">☰ Menú</button>
    </div>
<div class="container">
    
    <div class="main-content">
        <div class="chart">
            <h4>Estadisticas de vistas</h4>
            <div class="chart-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <div class="dashboard">
            <div class="card">
              <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/3126/3126647.png" alt="Customers Icon"></div>
              <h3>Visitas</h3>
              <p class="value">345k</p>
            </div>
            
            <div class="card">
              <div class="icon"><img src="https://cdn-icons-png.flaticon.com/256/17069/17069425.png" alt="Revenue Icon"></div>
              <h3>Tiendas</h3>
              <p class="value">1</p>
            </div>
            
            <div class="card">
                <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/2052/2052723.png" alt="Traffic Share Icon"></div>
                <h3>Calificacion</h3>
                <p class="value">3.5</p>
                
            </div>
            
        </div>
        
        <div class="latest-comments">
            <h4>Ultimos comentarios</h4>
            <p>Si: Ejemplo... blablabla
            </p>
        </div>
    </div>

    <div class="side-content">
        <div class="profile-card">
            @foreach(session('user') as $key => $data)
                <img src="{{$data['avatar']}}" alt="Profile Picture">
                <h3>{{ $data['nombre'] }}</h3>
            @endforeach
        </div>

        <div class="recent-messages">
            <h4>Mensajes Recientes</h4>
            <div class="message">
                <img src="https://via.placeholder.com/40" alt="User Picture">
                <p>Hank Schrader</p>
            </div>
            <div class="message">
                <img src="https://via.placeholder.com/40" alt="User Picture">
                <p>Dean Winchester</p>
            </div>
            <div class="message">
                <img src="https://via.placeholder.com/40" alt="User Picture">
                <p>John Dodol</p>
            </div>
        </div>

        <button class="start-conversation">Start Conversation</button>

        <div class="visitor-profile">
            <h4>Visitor's Profile</h4>
            <div class="chart-container">
                <canvas id="myPieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('js/graficas.js')}}"></script>


</body>
</html>
