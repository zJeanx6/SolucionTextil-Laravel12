<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>

    @stack('js')

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        @if (session('success'))

            var isDarkMode = document.documentElement.classList.contains('dark');
            var toastBackgroundColor = isDarkMode ?
                'linear-gradient(to right, #444444, #666666)' // modo oscuro
                :
                'linear-gradient(to right, #333333, #666666)'; // modo claro

            Toastify({
                text: "{{ session('success') }}",
                duration: 2000,
                // close: true,
                gravity: "top",
                position: "center",
                backgroundColor: toastBackgroundColor,
                className: "toast-notification",
                style: {
                    borderRadius: "10px",
                }
            }).showToast();
        @endif
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '##27272a',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
</x-layouts.app.sidebar>
