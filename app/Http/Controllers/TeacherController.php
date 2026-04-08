<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * LISTAR
     */
    public function index()
    {
        $teachers = Teacher::with('user')->latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * FORM CREAR
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * GUARDAR (CREA USER + TEACHER)
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',

            'document_number' => 'required|unique:teachers',
            'gender' => 'required',
            'document_type' => 'required',
            'birth_date' => 'required|date',
            'start_date' => 'required|date',

            'photo' => 'nullable|image',
            'cv' => 'nullable|mimes:pdf'
        ]);

        // 🔐 CREAR USUARIO
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(10)), // ✅ CLAVE AUTOMÁTICA
            'is_active' => true
        ]);

        $data = $request->except(['photo', 'cv', 'email', 'password']);

        $data['user_id'] = $user->id;
        $data['is_active'] = $request->has('is_active');

        // 📸 FOTO
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teachers/photos', 'public');
        }

        // 📄 PDF
        if ($request->hasFile('cv')) {
            $data['cv'] = $request->file('cv')->store('teachers/cv', 'public');
        }

        Teacher::create($data);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Profesor creado correctamente');
    }

    /**
     * VER
     */
    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * EDITAR
     */
    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * ACTUALIZAR
     */
    public function update(Request $request, Teacher $teacher)
    {
        $authUser = Auth::user();

        // 🔐 PROFESOR SOLO EDITA SU PERFIL
        if ($authUser->id === $teacher->user_id) {

            $request->validate([
                'phone' => 'nullable',
                'address' => 'nullable',
                'email' => 'required|email|unique:users,email,' . $authUser->id
            ]);

            $teacher->update([
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            $authUser->update([
                'email' => $request->email
            ]);

            return back()->with('success', 'Datos actualizados');
        }

        // 🔐 ADMIN
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'document_number' => 'required|unique:teachers,document_number,' . $teacher->id,
            'gender' => 'required',
            'document_type' => 'required',
            'birth_date' => 'required|date',
            'start_date' => 'required|date',
        ]);

        $data = $request->except(['photo', 'cv']);

        // 📸 FOTO
        if ($request->hasFile('photo')) {
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }
            $data['photo'] = $request->file('photo')->store('teachers/photos', 'public');
        }

        // 📄 PDF
        if ($request->hasFile('cv')) {
            if ($teacher->cv) {
                Storage::disk('public')->delete($teacher->cv);
            }
            $data['cv'] = $request->file('cv')->store('teachers/cv', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $teacher->update($data);

        // 🔴 SINCRONIZAR ESTADO CON USER
        $teacher->user->update([
            'is_active' => $data['is_active']
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Profesor actualizado');
    }

    /**
     * ELIMINAR
     */
    public function destroy(Teacher $teacher)
    {
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }

        if ($teacher->cv) {
            Storage::disk('public')->delete($teacher->cv);
        }

        // eliminar usuario también
        if ($teacher->user) {
            $teacher->user->delete();
        }

        $teacher->delete();

        return back()->with('success', 'Profesor eliminado');
    }
}