<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Panel principal') }}
        </h2>
    </x-slot>
    <style>
        .card {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .icono-usuario {
            font-size: 80px;
            color: #0b74cb;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .card h2 {
            font-size: 20px;
            color: #333333;
            margin: 0;
            transition: color 0.3s ease;
        }

        .card:hover {
            cursor: pointer;
            background-color: #0b74cb; /* Color de fondo cuando se pasa el mouse */
            transform: translateY(-5px); /* Efecto de elevación */
        }

        .card:hover .icono-usuario,
        .card:hover h2 {
            color: #ffffff; 
        }
    </style>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                    <div class="container mt-4">
                        <div class="row">
                            @if(auth()->user()->can('listar usuarios') )
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <a href="/usuarios" class="card">
                                    <i class="fa-solid fa-user-plus icono-usuario"></i>
                                    <h2>Usuarios y roles</h2>
                                </a>
                            </div>
                            @endif

                            <!-- Card 2 -->
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <a href="/roles" class="card">
                                    <i class="fa-solid fa-gear icono-usuario"></i>
                                    <h2>Roles</h2>
                                </a>
                            </div>
                            <!-- Card 3 -->
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card">
                                    <i class="fas fa-user icono-usuario"></i>
                                    <h2>Usuarios3</h2>
                                </div>
                            </div>
                            <!-- Card 4 -->
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card">
                                    <i class="fas fa-user icono-usuario"></i>
                                    <h2>Usuarios4</h2>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card">
                                    <i class="fas fa-user icono-usuario"></i>
                                    <h2>Usuarios5</h2>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card">
                                    <i class="fas fa-user icono-usuario"></i>
                                    <h2>Usuarios6</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
