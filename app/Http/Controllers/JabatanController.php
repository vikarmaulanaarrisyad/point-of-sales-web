<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masterdata.jabatan.index');
    }

    public function data()
    {
        $query = Jabatan::all();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                $aksi = '';

                if (Auth::user()->hasPermissionTo("Jabatan Edit")) {
                    $aksi .= '
                        <button onclick="editForm(`' . route('jabatan.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></button>

                    ';
                }
                if (Auth::user()->hasPermissionTo("Jabatan Delete")) {
                    $aksi .= '
                        <button onclick="deleteData(`' . route('jabatan.destroy', $query->id) . '`, `' . $query->jabatan . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                    ';
                }

                return $aksi;
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'jabatan' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf inputan yang anda masukan salah, silahkan periksa kembali dan coba lagi'], 422);
        }

        $data = [
            'jabatan'   => $request->jabatan,
            'slug'      => Str::slug($request->jabatan),
        ];

        Jabatan::create($data);

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        return response()->json(['data' => $jabatan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $rules = [
            'jabatan' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf inputan yang anda masukan salah, silahkan periksa kembali dan coba lagi'], 422);
        }

        $data = [
            'jabatan'   => $request->jabatan,
            'slug'      => Str::slug($request->jabatan),
        ];

        $jabatan->update($data);

        return response()->json(['message' => 'Data berhasil disimpan'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
