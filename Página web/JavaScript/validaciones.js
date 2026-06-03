document.addEventListener('DOMContentLoaded', () => {
    
    /* 1. LÓGICA DEL MODO OSCURO (CORREGIDA)*/
    const botonTema = document.getElementById('toggle-theme');
    const body = document.body;

    // Verificar si ya había elegido modo oscuro antes
    if (localStorage.getItem('tema-fixly') === 'oscuro') {
        body.classList.add('dark-mode');
        botonTema.textContent = '☀️ Claro';
    }

    // Evento de clic en el botón
    botonTema.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('tema-fixly', 'oscuro');
            botonTema.textContent = '☀️ Claro';
        } else {
            localStorage.setItem('tema-fixly', 'claro');
            botonTema.textContent = '🌙 Oscuro';
        }
    });
    /*2. VALIDACIÓN DEL FORMULARIO*/
    const formulario = document.getElementById('formulario-login');
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombreUsuario').value.trim();
            const password = document.getElementById('passUsuario').value.trim();
            const regexNombre = /^[a-zA-Z\s]+@fixly\.es$/;

            if (!regexNombre.test(nombre)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Formato incorrecto',
                    text: 'El nombre solo puede contener letras/espacios, y debe usar el dominio @fixly.es.',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            if (password.length === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo vacío',
                    text: 'La contraseña no puede estar vacía.',
                    confirmButtonColor: '#2563eb'
                });
                return;
            } else if (password.length < 6) {
                e.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'Contraseña débil',
                    text: 'Por seguridad, la contraseña debe tener al menos 6 caracteres.',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }
        });
    }
});
