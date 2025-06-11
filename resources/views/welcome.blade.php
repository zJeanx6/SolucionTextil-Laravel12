<x-layouts.dashboard :title="'Inicio - Solucion Textil'">
     <style>
        /* Contenedor principal responsivo */
        .carrusel-container {
            position: relative;
            width: 100%;
            height: 100vh; 
            overflow: hidden; 
        }
        .carrusel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .carrusel img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            will-change: opacity;
        }

        .carrusel img.active {
            opacity: 1;
            z-index: 1;
        }
    </style>
    <div class="carrusel-container">
        <div class="carrusel">
            <img src="{{ asset('img/carrusel1.png') }}" class="active" alt="Imagen 1">
            <img src="{{ asset('img/carrusel2.png') }}" alt="Imagen 2">
            <img src="{{ asset('img/carrusel3.png') }}" alt="Imagen 3">
            <img src="{{ asset('img/carrusel4.png') }}" alt="Imagen 4">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const images = document.querySelectorAll('.carrusel img');
            let index = 0;

            setInterval(() => {
                images[index].classList.remove('active');
                index = (index + 1) % images.length;
                images[index].classList.add('active');
            }, 8000);
        });
    </script>
</x-layouts.dashboard>
