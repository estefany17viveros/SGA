<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guardian;
use App\Models\Student;

class GuardianController extends Controller
{

    /**
     * LISTAR ACUDIENTES
     */
 public function index(Request $request)
{

$guardians = Guardian::with('student')

->when($request->apellido, function($query) use ($request){

$query->whereHas('student', function($q) use ($request){

$q->where('first_name','like','%'.$request->apellido.'%');

});

})

->paginate(10);

return view('admin.guardians.index', compact('guardians'));

}

    /**
     * FORMULARIO CREAR ACUDIENTE
     */
public function create($student_id)
{
    $student = Student::findOrFail($student_id);

    return view('admin.guardians.create', compact('student'));
}

    /**
     * GUARDAR ACUDIENTE
     */
    public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'relationship' => 'required|string|max:100',
        'phone' => 'required|string|max:20',
        'identification_number' => 'nullable|string|max:50',
        'email' => 'nullable|email|max:255',
        'occupation' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
    ]);

    Guardian::create([
        'student_id' => $request->student_id,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'relationship' => $request->relationship,
        'identification_number' => $request->identification_number,
        'phone' => $request->phone,
        'email' => $request->email,
        'occupation' => $request->occupation,
        'address' => $request->address,
    ]);

    // 🔥 AQUÍ ESTÁ LA MAGIA
    return redirect()->route('admin.enrollments.create', [
        'student_id' => $request->student_id
    ])->with('success', 'Acudiente registrado. Ahora debes matricular al estudiante.');


    }
    /**
     * VER ACUDIENTE
     */
    public function show($id)
    {
        $guardian = Guardian::with('student')->findOrFail($id);

        return view('admin.guardians.show', compact('guardian'));
    }


    /**
     * FORMULARIO EDITAR
     */
    public function edit($id)
    {
        $guardian = Guardian::findOrFail($id);
        $students = Student::all();

        return view('admin.guardians.edit', compact('guardian','students'));
    }


    /**
     * ACTUALIZAR ACUDIENTE
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'relationship' => 'required|string|max:50',
            'identification_number' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
        ]);

        $guardian = Guardian::findOrFail($id);

        $guardian->update([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'relationship' => $request->relationship,
            'identification_number' => $request->identification_number,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'occupation' => $request->occupation,
        ]);

        return redirect()
            ->route('admin.guardians.index')
            ->with('success','Acudiente actualizado correctamente');
    }


    /**
     * ELIMINAR ACUDIENTE
     */
    public function destroy($id)
    {
        $guardian = Guardian::findOrFail($id);

        $guardian->delete();

        return redirect()
            ->route('admin.guardians.index')
            ->with('success','Acudiente eliminado correctamente');
    }

}