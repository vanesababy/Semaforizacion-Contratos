<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Crear Nuevo Rol') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card">
                <div class="card-body mt-4">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf

                        <!-- Nombre del Rol -->
                        <div class="form-group mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Rol</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Permisos -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permisos</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach ($permissions as $permission)
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->id }}"
                                               id="permission_{{ $permission->id }}"
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                        <label for="permission_{{ $permission->id }}" class="ml-2 text-sm text-gray-600">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('usuarios.index') }}" 
                               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                                Cancelar
                            </a>
                            <button type="submit"  
                                    class="btn btn-success">
                                Crear Rol
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>