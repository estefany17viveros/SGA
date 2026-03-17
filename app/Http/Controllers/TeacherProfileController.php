<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherProfileController extends Controller
{
    // Mostrar todos los profesores
    public function index()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.teacher_profiles.index', compact('teachers'));
    }

    // Formulario para crear un nuevo profesor
    public function create()
    {
        return view('admin.teacher_profiles.create');
    }

   public function store(Request $request)
{
    // ✅ VALIDACIONES
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'dni'        => 'required|string|max:8|unique:teachers,dni',
        'email'      => 'required|email|unique:users,email',
        'password'   => 'required|min:6',
        'phone'      => 'nullable|string|max:15',
        'address'    => 'nullable|string|max:255',
        'specialty'  => 'nullable|string|max:255',
        'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'dni.unique'   => 'Este DNI ya está registrado.',
        'email.unique' => 'Este correo ya está registrado en el sistema.',
    ]);

    // ✅ Crear usuario
    $user = User::create([
        'name'     => $request->first_name . ' ' . $request->last_name,
        'email'    => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // ✅ Crear profesor
    $teacher = Teacher::create([
        'user_id'    => $user->id,
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'dni'        => $request->dni,
        'phone'      => $request->phone,
        'address'    => $request->address,
        'specialty'  => $request->specialty,
        'photo'      => null
    ]);

    // ✅ Guardar foto si existe
    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('teachers', 'public');
        $teacher->update([
            'photo' => $path
        ]);
    }

    return redirect()
        ->route('admin.teacher-profiles.index')
        ->with('success', 'Profesor creado correctamente.');
}
    public function show($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        return view('admin.teacher_profiles.show', compact('teacher'));
    }

    // Formulario para editar un profesor
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('admin.teacher_profiles.edit', compact('teacher'));
    }

    // Actualizar un profesor
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        // Validaciones
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dni' => 'required|string|max:8|unique:teachers,dni,' . $teacher->id,
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'specialty' => 'nullable|string|max:255',
        ]);

        // Actualizar usuario
        $teacher->user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
        ]);

        // Guardar nueva imagen si se sube
        if ($request->hasFile('photo')) {
            // Eliminar la foto anterior si existe
            if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                Storage::disk('public')->delete($teacher->photo);
            }
            $teacher->photo = $request->file('photo')->store('teachers', 'public');
        }

        // Actualizar datos del profesor
        $teacher->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'dni' => $request->dni,
            'phone' => $request->phone,
            'address' => $request->address,
            'specialty' => $request->specialty,
            'photo' => $teacher->photo, // ya actualizado si hubo nueva foto
        ]);

        return redirect()
            ->route('admin.teacher-profiles.show', $teacher->id)
            ->with('success', 'Profesor actualizado correctamente.');
    }

    // Eliminar un profesor
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);

        // Eliminar foto si existe
        if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
            Storage::disk('public')->delete($teacher->photo);
        }

        // Eliminar usuario relacionado
        if ($teacher->user) {
            $teacher->user->delete();
        }

        $teacher->delete();

        return redirect()
            ->route('admin.teacher-profiles.index')
            ->with('success', 'Profesor eliminado correctamente.');
    }
}