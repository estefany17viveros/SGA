<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{

    /**
     * Listar grados
     */
    public function index()
    {
        $grades = Grade::orderBy('level', 'asc')->get();

        return view('admin.grades.index', compact('grades'));
    }



    /**
     * Mostrar formulario crear grado
     */
    public function create()
    {
        return view('admin.grades.create');
    }



    /**
     * Guardar nuevo grado
     */
    public function store(Request $request)
    {

        // mapa para evitar duplicados como "6" y "Sexto"
        $map = [
            '1' => 1, 'primero' => 1,
            '2' => 2, 'segundo' => 2,
            '3' => 3, 'tercero' => 3,
            '4' => 4, 'cuarto' => 4,
            '5' => 5, 'quinto' => 5,
            '6' => 6, 'sexto' => 6,
            '7' => 7, 'séptimo' => 7, 'septimo' => 7,
            '8' => 8, 'octavo' => 8,
            '9' => 9, 'noveno' => 9,
            '10' => 10, 'décimo' => 10, 'decimo' => 10,
            '11' => 11, 'once' => 11
        ];

        $name = strtolower(trim($request->name));
        $gradeNumber = $map[$name] ?? null;

        if ($gradeNumber !== null) {

            $exists = Grade::where(function ($query) use ($map, $gradeNumber) {

                foreach ($map as $key => $value) {

                    if ($value === $gradeNumber) {
                        $query->orWhereRaw('LOWER(name) = ?', [$key]);
                    }

                }

            })->exists();

            if ($exists) {

                return back()->withErrors([
                    'name' => 'Ese grado ya existe con otro nombre (ej: 6 o Sexto).'
                ])->withInput();

            }
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:grades,name'
            ],
            'level' => [
                'required',
                'integer',
                'min:1',
                'unique:grades,level'
            ],
        ], [
            'name.unique' => 'Ya existe un grado con ese nombre.',
            'level.unique' => 'Ya existe un grado con ese nivel.'
        ]);

        Grade::create([
            'name' => $request->name,
            'level' => $request->level
        ]);

        return redirect()->route('admin.grades.index')
            ->with('success', 'Grado creado correctamente.');
    }



    /**
     * Mostrar grado específico
     */
    public function show(Grade $grade)
    {
        return view('admin.grades.show', compact('grade'));
    }



    /**
     * Mostrar formulario editar
     */
    public function edit(Grade $grade)
    {
        return view('admin.grades.edit', compact('grade'));
    }



    /**
     * Actualizar grado
     */
    public function update(Request $request, Grade $grade)
    {

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('grades')->ignore($grade->id),
            ],
            'level' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('grades')->ignore($grade->id),
            ],
        ], [
            'name.unique'  => 'Ya existe un grado con ese nombre.',
            'level.unique' => 'Ya existe un grado con ese nivel.',
        ]);

        $grade->update([
            'name'  => $request->name,
            'level' => $request->level,
        ]);

        return redirect()->route('admin.grades.index')
            ->with('success', 'Grado actualizado correctamente.');
    }



    /**
     * Eliminar grado
     */
    public function destroy(Grade $grade)
    {

        // verificar si tiene grupos
        if ($grade->groups()->exists()) {

            return redirect()->route('admin.grades.index')
                ->with('error', 'No se puede eliminar el grado porque tiene grupos asociados.');

        }

        // verificar matrículas
        if (method_exists($grade, 'enrollments') && $grade->enrollments()->exists()) {

            return redirect()->route('admin.grades.index')
                ->with('error', 'No se puede eliminar el grado porque tiene matrículas asociadas.');

        }

        $grade->delete();

        return redirect()->route('admin.grades.index')
            ->with('success', 'Grado eliminado correctamente.');
    }
}