<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Concept - Bootstrap 4 Admin Dashboard Template</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('assets/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        #product-add {
            margin-bottom: 20px;
        }

        .action-icon {
            margin-left: 10px;
            font-size: 18px;
        }

        textarea {
            letter-spacing: 3px;
            font-family: Arial, sans-serif;
            font-weight: 200;
        }

        .code-textarea {
            width: 100%;
            height: 400px;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            line-height: 1.5;
            white-space: nowrap;
            letter-spacing: 0.5px;
            overflow: auto;
            background-color: #f4f4f4;
            color: #333;
            border: 1px solid #ccc;
            padding: 10px;
            tab-size: 4;
        } 
    </style>
</head>