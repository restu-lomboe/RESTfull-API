<?php

namespace App\Http\Controllers\API;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;

class FormController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required'
        ]);

        // dd($request->all());
        $student = new Student;
        $student->nama = $request->nama;
        $student->alamat = $request->alamat;
        $student->no_telp = $request->no_telp;
        $student->save();

        return response()->json([
                'message'       => 'Student Berhasil Ditambahkan',
                'data_student'  => $student
            ], 200);
    }

    public function edit($id)
    {
        $student = Student::find($id);
        $studentCollection = new StudentResource($student);

        return response()->json([
                'message'       => 'success',
                'data_student'  => $studentCollection
            ], 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required'
        ]);

        $student->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp
        ]);

        return response()->json([
                'message'       => 'success',
                'data_student'  => $student
            ], 200);
    }

    public function delete($id)
    {
        $student = Student::find($id)->delete();

        return response()->json([
                'message'       => 'data student berhasil dihapus'
            ], 200);
    }

    public function show(Request $request)
    {
        $perPage = $request->get('per_page');

        $students = Student::paginate($perPage);
        $collectionStudent = StudentResource::collection($students);

        $dataStudent['data'] = $collectionStudent;
        $dataStudent['next_page_url'] = $students->nextPageUrl();

        return response()->json([
                'message'       => 'success',
                'data_student'  =>  $dataStudent
            ], 200);

    }
}
