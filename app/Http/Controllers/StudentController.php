<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Enrollment;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    /**
     * Listar estudiantes
     */
 public function index(Request $request)
{
    $currentYear = AcademicYear::where('status','activo')->first();

    $students = Student::query();

    // 🔥 SOLO si hay año activo
    if ($currentYear) {
        $students->with(['enrollments' => function($query) use ($currentYear){
            $query->where('academic_year_id', $currentYear->id)
                  ->with('grade');
        }]);
    } else {
        // 👇 evita que rompa si no hay año
        $students->with('enrollments.grade');
    }

    // 🔍 BUSCADOR
    $students->when($request->search, function ($query) use ($request) {
        $query->where(function($q) use ($request){
            $q->where('first_name','like','%'.$request->search.'%')
              ->orWhere('last_name','like','%'.$request->search.'%')
              ->orWhere('identification_number','like','%'.$request->search.'%');
        });
    });

    // 🔥 FILTRO APELLIDO
    $students->when($request->last_name, function ($query) use ($request) {
        $query->where('last_name','like','%'.$request->last_name.'%');
    });

    // 🔥 FILTRO GRADO (solo si hay año activo)
    if ($currentYear) {
        $students->when($request->grade_id, function ($query) use ($request, $currentYear) {
            $query->whereHas('enrollments', function($q) use ($request, $currentYear){
                $q->where('academic_year_id', $currentYear->id)
                  ->where('grade_id', $request->grade_id);
            });
        });
    }

    $students = $students->latest()->paginate(10);

    $grades = \App\Models\Grade::all();

    return view('admin.students.index', compact('students','grades'));
}

    /**
     * Formulario crear estudiante
     */
    public function create()
    {
        return view('admin.students.create');
    }


    /**
     * Guardar estudiante
     */
    public function store(Request $request)
{
$graduated = Enrollment::where('student_id', $request->student_id)
    ->where('status', 'graduado')
    ->exists();

if ($graduated) {
    return back()->with('error', '❌ Este estudiante ya está graduado y no puede ser matriculado nuevamente.');
}
    $messages = [

        'required' => 'El campo :attribute es obligatorio.',
        'string' => 'El campo :attribute debe ser texto.',
        'max' => 'El campo :attribute no debe superar :max caracteres.',
        'image' => 'La foto debe ser una imagen válida.',
        'date' => 'El campo :attribute debe ser una fecha válida.',
        'in' => 'El valor seleccionado en :attribute no es válido.',
        'unique' => 'El :attribute ya se encuentra registrado en el sistema.',
        'file' => 'Debe subir un archivo válido.',
      'required_if' => 'Debe subir el certificado si selecciona una población especial.',
        'mimes' => 'El archivo debe ser un PDF.',
    ];

    $attributes = [

        'photo' => 'foto del estudiante',
        'first_name' => 'nombre',
        'last_name' => 'apellido',
        'gender' => 'género',
        'birth_date' => 'fecha de nacimiento',

        'identification_type' => 'tipo de documento',
        'identification_number' => 'número de documento',

        'expedition_date' => 'fecha de expedición',
        'expedition_department' => 'departamento de expedición',
        'expedition_municipality' => 'municipio de expedición',

        'address' => 'dirección',

        'eps' => 'EPS',
        'blood_type' => 'tipo de sangre',

        'medical_conditions' => 'condiciones médicas',
        'observations' => 'observaciones',
        'population_type' => 'tipo de población',
            'population_certificate' => 'certificado de población',
        'certificate_file' => 'certificado en PDF'
    ];

    $request->validate([

        'photo' => 'nullable|image|max:2048',

        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'gender' => 'required|in:masculino,femenino',
        'birth_date' => 'required|date',

        'identification_type' => 'required|in:registro_civil,tarjeta_identidad,cedula_ciudadania,cedula_extranjeria,pasaporte,permiso_proteccion_temporal',
        'identification_number' => 'required|string|unique:students,identification_number',

        'expedition_date' => 'required|date',
        'expedition_department' => 'required|string|max:255',
        'expedition_municipality' => 'required|string|max:255',

        'address' => 'required|string|max:255',

        'eps' => 'required|string|max:255',
        'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',

        'medical_conditions' => 'nullable|string',
        'observations' => 'nullable|string',

        'certificate_file' => 'nullable|file|mimes:pdf|max:2048',

            'population_type' => 'required|in:ninguno,afro,indigena,desplazado',

            'population_certificate' => [
                'nullable',
                'file',
                'mimes:pdf',
                'required_if:population_type,afro,indigena,desplazado'
            ]
    ], $messages, $attributes);


    $data = $request->all();

    if ($request->hasFile('photo')) {

        $data['photo'] = $request->file('photo')
            ->store('students/photos', 'public');
    }

    if ($request->hasFile('certificate_file')) {

        $data['certificate_file'] = $request->file('certificate_file')
            ->store('students/certificates', 'public');
    }
     // 🔥 CERTIFICADO DE POBLACIÓN
        if ($request->hasFile('population_certificate')) {
            $data['population_certificate'] = $request->file('population_certificate')
                ->store('students/population', 'public');
        }


   $student = Student::create($data);

return redirect()->route('admin.guardians.create', $student->id)
        ->with('success', 'Estudiante creado. Ahora registra el acudiente.');
}

    /**
     * Mostrar estudiante
     */
public function show(Student $student)
{

  $student->load([
    'enrollments' => function($query){
        $query->with('grade','group','academicYear')
              ->orderBy('academic_year_id','asc');
    },
    'guardians'
]);

    return view('admin.students.show', compact('student'));
}


    /**
     * Formulario editar
     */
    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }


    /**
     * Actualizar estudiante
     */
    public function update(Request $request, Student $student)
    {

        $request->validate([

            // foto
            'photo' => 'nullable|image|max:2048',

            // datos personales
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:masculino,femenino',
            'birth_date' => 'required|date',

            // documento
            'identification_type' => 'required|in:registro_civil,tarjeta_identidad,cedula_ciudadania,cedula_extranjeria,pasaporte,permiso_proteccion_temporal',

            'identification_number' =>
            'required|string|unique:students,identification_number,' . $student->id,

            // expedición
            'expedition_date' => 'required|date',
            'expedition_department' => 'required|string|max:255',
            'expedition_municipality' => 'required|string|max:255',

            // dirección
            'address' => 'required|string|max:255',

            // salud
            'eps' => 'required|string|max:255',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',

            // opcionales
            'medical_conditions' => 'nullable|string',
            'observations' => 'nullable|string',

            'certificate_file' => 'nullable|file|mimes:pdf|max:2048',
 'population_type' => 'required|in:ninguno,afro,indigena,desplazado',

            'population_certificate' => [
                'nullable',
                'file',
                'mimes:pdf',
                'required_if:population_type,afro,indigena,desplazado'
            ]
                ]);

        $data = $request->all();

        /*
        |---------------------------------
        | Actualizar foto
        |---------------------------------
        */
        if ($request->hasFile('photo')) {

            if ($student->photo && Storage::disk('public')->exists($student->photo)) {

                Storage::disk('public')->delete($student->photo);
            }

            $data['photo'] = $request->file('photo')
                ->store('students/photos', 'public');
        }

        /*
        |---------------------------------
        | Actualizar certificado
        |---------------------------------
        */
        if ($request->hasFile('certificate_file')) {

            if ($student->certificate_file && Storage::disk('public')->exists($student->certificate_file)) {

                Storage::disk('public')->delete($student->certificate_file);
            }

            $data['certificate_file'] = $request->file('certificate_file')
                ->store('students/certificates', 'public');
        }
 // 🔥 CERTIFICADO POBLACIÓN
        if ($request->hasFile('population_certificate')) {

            if ($student->population_certificate && Storage::disk('public')->exists($student->population_certificate)) {
                Storage::disk('public')->delete($student->population_certificate);
            }

            $data['population_certificate'] = $request->file('population_certificate')
                ->store('students/population', 'public');
        }

        $student->update($data);

        return redirect()->route('admin.students.index')
            ->with('success', 'Estudiante actualizado correctamente.');
    }


    /**
     * Eliminar estudiante
     */
    public function destroy(Student $student)
    {

        if ($student->photo && Storage::disk('public')->exists($student->photo)) {

            Storage::disk('public')->delete($student->photo);
        }

        if ($student->certificate_file && Storage::disk('public')->exists($student->certificate_file)) {

            Storage::disk('public')->delete($student->certificate_file);
        }
 if ($student->population_certificate && Storage::disk('public')->exists($student->population_certificate)) {
            Storage::disk('public')->delete($student->population_certificate);
        }

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Estudiante eliminado correctamente.');
    }


    /**
     * Promover estudiantes al siguiente año
     */
    // public function promoteStudents()
    // {

    //     $currentYear = AcademicYear::where('is_active', 1)->first();

    //     $nextYear = AcademicYear::where('year', $currentYear->year + 1)->first();

    //     if (!$nextYear) {

    //         return back()->with('error', 'No existe el siguiente año académico.');
    //     }

    //     $enrollments = Enrollment::where('academic_year_id', $currentYear->id)->get();

    //     foreach ($enrollments as $enrollment) {

    //         if ($enrollment->status == 'aprobado') {

    //             Enrollment::create([

    //                 'student_id' => $enrollment->student_id,
    //                 'grade_id' => $enrollment->grade_id + 1,
    //                 'group_id' => $enrollment->group_id,
    //                 'academic_year_id' => $nextYear->id,
    //                 'status' => 'matriculado'

    //             ]);
    //         }
    //     }

    //     return back()->with('success', 'Estudiantes promovidos correctamente.');
    // }

    public function promoteStudents()
{
    $currentYear = AcademicYear::where('status', 'activo')->first();

    if (!$currentYear) {
        return back()->with('error', 'No hay año académico activo');
    }

    $lastYear = AcademicYear::where('id', '<', $currentYear->id)
        ->orderBy('id', 'desc')
        ->first();

    if (!$lastYear) {
        return back()->with('error', 'No existe un año anterior');
    }

    $students = Enrollment::with('grade')
        ->where('academic_year_id', $lastYear->id)
        ->get();

    foreach ($students as $enrollment) {

        // 🔴 BLOQUE PRINCIPAL (LA CLAVE)
        if ($enrollment->status == 'graduado') {
            continue; // 🚫 NO hacer nada, se queda en su último año
        }

        if ($enrollment->status == 'retirado') {
            continue;
        }

        $gradeId = $enrollment->grade_id;

        if ($enrollment->status == 'aprobado') {
            $nextGrade = Grade::where('level', $enrollment->grade->level + 1)->first();

            if ($nextGrade) {
                $gradeId = $nextGrade->id;
            }
        }

        if ($enrollment->status == 'reprobado') {
            $gradeId = $enrollment->grade_id;
        }

        // Evitar duplicados
        $exists = Enrollment::where('student_id', $enrollment->student_id)
            ->where('academic_year_id', $currentYear->id)
            ->exists();

        if (!$exists) {
            Enrollment::create([
                'student_id' => $enrollment->student_id,
                'grade_id' => $gradeId,
                'group_id' => null,
                'academic_year_id' => $currentYear->id,
                'status' => 'matriculado'
            ]);
        }
    }

    return back()->with('success', 'Promoción realizada correctamente');
}
}
