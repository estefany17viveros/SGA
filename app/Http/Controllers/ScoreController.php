<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Activity;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * GUARDAR / ACTUALIZAR NOTAS MASIVAS
     */
    public function store(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'scores' => 'required|array',
            'scores.*.student_id' => 'required|exists:students,id',
            'scores.*.score' => 'required|numeric|min:0|max:5',
        ]);

        $activity = Activity::findOrFail($request->activity_id);

        foreach ($request->scores as $item) {

            Score::updateOrCreate(
                [
                    'activity_id' => $activity->id,
                    'student_id' => $item['student_id']
                ],
                [
                    'score' => $item['score']
                ]
            );
        }

        return view('activities.show', compact('activity'));
        
    }

    /**
     * LISTAR NOTAS DE UNA ACTIVIDAD
     */
    public function index($activityId)
    {
        $scores = Score::with('student')
            ->where('activity_id', $activityId)
            ->get();

        return view('scores.index', compact('scores'));
    }

    /**
     * ACTUALIZAR UNA NOTA INDIVIDUAL
     */
    public function update(Request $request, $id)
    {
        $score = Score::findOrFail($id);

        $request->validate([
            'score' => 'required|numeric|min:0|max:5'
        ]);

        $score->update([
            'score' => $request->score
        ]);

        return view('activities.show', ['activity' => $score->activity]);
    }

    /**
     * ELIMINAR NOTA
     */
    public function destroy($id)
    {
        $score = Score::findOrFail($id);
        $score->delete();

        return view('activities.show', ['activity' => $score->activity]);
    }
}