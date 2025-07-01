document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        // Validación local temporal
        if (username === 'admin' && password === '1234') {
            Swal.fire({
                icon: 'success',
                title: 'Bienvenido',
                text: 'Acceso concedido',
                confirmButtonColor: '#198754'
            }).then(() => {
                // Redirección simulada (puedes cambiarla por tu dashboard real)
                window.location.href = "../plataforma/principal.php";
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Credenciales incorrectas',
                confirmButtonColor: '#d33'
            });
        }
    });
