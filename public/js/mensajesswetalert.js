function cambioc()
{
    Swal.fire(
        'Se cambio la contraseña!',
        'Se cambio la contraseña correctamente.',
        'success'
    );
}

function nocontra()
{
    Swal.fire({
        icon: 'error',
        title: 'No se pudo guardar la contraseña',
        text: 'No se pudo cambiar por que la contraseña es incorrecta!',
    });
}

function cambioi()
{
    Swal.fire(
        'Se cambio la imagen!',
        'Se cambio la imagen de perfil correctamente.',
        'success'
    );
}

function pordef()
{
    $('#changePasswordForm').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Estas seguro de cambiar la contraseña?',
            text: "Ya no habra vuelta atras!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();

            }
        });
    });
}
