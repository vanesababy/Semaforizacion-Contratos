<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $usuarios = User::with('roles')->get();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('usuarios.index', compact('usuarios','roles', 'permissions'));
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');

        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->input('password'));
        }

        $usuario->save();

        // Asignar roles
        $usuario->syncRoles($request->input('role'));

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }




    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('usuarios.actualizar_rol', compact('role', 'permissions'));
    }

    
    public function updateRole(Request $request, $id)
    {
        // Validar los datos del request
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'required|array'
        ]);

        try {
            // Encontrar el rol por ID
            $role = Role::findOrFail($id);
            
            // Actualizar el nombre del rol
            $role->name = $request->name;
            $role->save();
            
            // Obtener los permisos seleccionados como objetos Permission
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            
            // Sincronizar los permisos usando la colección de permisos
            $role->syncPermissions($permissions);
            
            return redirect()->route('usuarios.index')
                ->with('success', 'Rol actualizado exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el rol: ' . $e->getMessage())
                ->withInput();
        }
    }
    

    public function createRole()
    {
        $permissions = Permission::all();
        return view('usuarios.create_rol', compact('permissions'));
    }
    
    public function storeRole(Request $request)
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);
    
            // Crear el nuevo rol
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
    
            // Obtener los permisos y sincronizarlos
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
    
            return redirect()->route('usuarios.index')
                ->with('success', 'Rol creado exitosamente');
    
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el rol: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function deleteRole($id)
    {
        try {
            $role = Role::findOrFail($id);
            
            // Verificar si el rol está en uso
            if ($role->users->count() > 0) {
                return redirect()->back()
                    ->with('error', 'No se puede eliminar el rol porque está asignado a uno o más usuarios.');
            }

            // Eliminar los permisos asociados al rol
            $role->syncPermissions([]);
            
            // Eliminar el rol
            $role->delete();

            return redirect()->route('usuarios.index')
                ->with('success', 'Rol eliminado exitosamente');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el rol: ' . $e->getMessage());
        }
    }

    public function createUser()
    {
        $roles = Role::all();
        return view('usuarios.create_user', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'identificacion' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|exists:roles,id'
        ]);
    
        try {
            // Crear el usuario
            $user = User::create([
                'name' => $request->name,
                'identificacion' => $request->identificacion,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            // Asignar el rol al usuario
            $role = Role::findById($request->role);
            $user->assignRole($role);
    
            return redirect()->route('usuarios.index')->with('success', 'Usuario creado y rol asignado correctamente');
        } catch (\Exception $e) {
            // Si ocurre un error, redirige con un mensaje de error
            return redirect()->route('usuarios.create')->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }
    
    
}




