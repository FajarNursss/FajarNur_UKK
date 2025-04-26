import './bootstrap';
import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', () => {
    if (window.LaravelSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: window.LaravelSuccess,
        });
    }

    if (window.LaravelError) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: window.LaravelError,
        });
    }
});
