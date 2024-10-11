// Obtener el contexto del canvas donde dibujaremos la gráfica
const ctx = document.getElementById('myChart').getContext('2d');

// Crear el gráfico
const myChart = new Chart(ctx, {
    type: 'bar', // Tipo de gráfico (puedes cambiarlo a 'line', 'pie', 'doughnut', etc.)
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'], // Etiquetas del eje X
        datasets: [{
            label: 'Visitas por mes', // Etiqueta del gráfico
            data: [12, 19, 3, 5, 2, 3, 10], // Datos del gráfico
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1 // Ancho del borde de las barras
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true // Asegura que el eje Y comience desde 0
            }
        }
    }
});

//Grafico de pastel
const ctx2 = document.getElementById('myPieChart').getContext('2d');

// Crear el gráfico de pastel
const myPieChart = new Chart(ctx2, {
    type: 'pie', // Tipo de gráfico: pastel
    data: {
            datasets: [{
            label: 'Colores favoritos',
            data: [25, 13, 3], // Datos (valores para cada porción del pastel)
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',  // Rojo
                'rgba(54, 162, 235, 0.6)',  // Azul
                'rgba(255, 206, 86, 0.6)',  // Amarillo
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',   // Rojo
                'rgba(54, 162, 235, 1)',   // Azul
                'rgba(255, 206, 86, 1)',   // Amarillo
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,  // Hace el gráfico responsivo
        plugins: {
            legend: {
                position: 'top', // Posición de la leyenda
            },
            tooltip: {
                enabled: true // Habilitar los tooltips (información emergente)
            }
        }
    }
});

function toggleSidebar() {
    const sidebar = document.getElementById('mySidebar');
    if (sidebar.style.width === '250px') {
        sidebar.style.width = '0'; // Ocultar la barra lateral
    } else {
        sidebar.style.width = '250px'; // Mostrar la barra lateral
    }
}