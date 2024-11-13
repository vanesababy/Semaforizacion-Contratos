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
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    
                        <!-- Nombre del Rol -->
                        <div class="form-group">
                            <label for="role_name">Nombre del Rol</label>
                            <input type="text" id="role_name" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                        </div>
                    
                        <!-- Permisos -->
                        <h3>Permisos</h3>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-4">
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        @if($role->hasPermissionTo($permission)) checked @endif>
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    
                        <button type="submit" class="btn btn-success mt-3">Actualizar Rol</button>
                    </form>
                    
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>










