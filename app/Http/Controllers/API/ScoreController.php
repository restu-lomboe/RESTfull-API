<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Score;

class ScoreController extends Controller
{
    public function create(Request $request)
    {
        // dd($request->all());
        $student            = new Student;
        $student->nama      = $request->nama;
        $student->alamat    = $request->alamat;
        $student->no_telp   = $request->no_telp;
        $student->save();

        foreach ($request->list_pelajaran as $key => $value) {
            $score = array(
                'student_id' => $student->id,
                'mata_pelajaran' => $value['mata_pelajaran'],
                'nilai' => $value['nilai']
            );
            $scores = Score::create($score);
        }

        return response()->json([
                'message'       => 'success'
            ], 200);
    }
}
