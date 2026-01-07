<!-- Custom styles for Toastr -->
<style>
    .toast-success {
        background-color: #28a745; /* Green for success */
    }

    .toast-error {
        background-color: #dc3545; /* Red for error */
    }

    /* Increase the width of the toast */
    .toast {
        animation: slideIn 0.5s ease-in-out, slideOut 0.5s ease-in-out 4.5s; /* Adjust timing as needed */
        min-width: 350px; /* Adjust this value to increase the width */
    }

    @keyframes slideIn {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(100%);
            opacity: 0;
        }
    }
</style>


<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Blade Template -->
@if (Session::has('success'))
    <script>
        // Delay the display of the success toast by 700 milliseconds
        setTimeout(function() {
            toastr.success('{{ session('success') }}', 'Success!', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-bottom-right', // Set to bottom-right
                timeOut: 5000, // Toast will disappear after 5 seconds
                extendedTimeOut: 2000, // Time to extend the toast when hovered
                fadeIn: 500, // Animation duration in milliseconds
                fadeOut: 500, // Animation duration in milliseconds
            });
        }, 700); // 700 milliseconds delay
    </script>
@endif

@if (Session::has('error'))
    <script>
        // Delay the display of the error toast by 700 milliseconds
        setTimeout(function() {
            toastr.error('{{ session('error') }}', 'Error!', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-bottom-right', // Set to bottom-right
                timeOut: 5000, // Toast will disappear after 5 seconds
                extendedTimeOut: 2000, // Time to extend the toast when hovered
                fadeIn: 500, // Animation duration in milliseconds
                fadeOut: 500, // Animation duration in milliseconds
            });
        }, 700); // 700 milliseconds delay
    </script>
@endif
