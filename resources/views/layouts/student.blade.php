<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - @yield('title')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans flex flex-col min-h-screen">

    @include('layouts.partials.student-nav')

    <main class="container mx-auto px-4 pb-12 flex-grow">
        @yield('content') 
    </main>

    @include('layouts.partials.student-footer')

</body>
</html>