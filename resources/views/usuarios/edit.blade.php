<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="container">
            <div class="card" >
                {{-- <div class="card-header">
                    <h5>Editar Usuario</h5>
                </div> --}}
                <div class="card-body mt-4">
                    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Fila 1: Nombre y Identificación -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control" value="{{ $usuario->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="identificacion" class="form-label">Identificación</label>
                                <input type="text" name="identificacion" class="form-control" value="{{ $usuario->identificacion }}" required>
                            </div>
                        </div>

                        <!-- Fila 2: Correo y Contraseña -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo</label>
                                <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña">
                                    <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted">Deja este campo vacío si no deseas cambiar la contraseña.</small>
                            </div>
                        </div>

                        <!-- Fila 3: Rol (ocupa toda la fila) -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="role" class="form-label">Rol</label>
                                <select name="role" class="form-select" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $usuario->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Botón de Actualizar -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para toggle del ojo -->
    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            var passwordField = document.getElementById('password');
            var passwordFieldType = passwordField.getAttribute('type');
            
            if (passwordFieldType === 'password') {
                passwordField.setAttribute('type', 'text');
                this.innerHTML = '<i class="fa fa-eye-slash"></i>'; // Cambia el ícono a "ojo cerrado"
            } else {
                passwordField.setAttribute('type', 'password');
                this.innerHTML = '<i class="fa fa-eye"></i>'; // Cambia el ícono a "ojo abierto"
            }
        });
    </script>
</x-app-layout>
