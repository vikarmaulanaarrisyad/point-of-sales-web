<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan = Karyawan::all();
        return view('masterdata.pelanggan.index', compact('karyawan'));
    }

    public function data(Request $request)
    {
        // Start building the query
        $query = Pelanggan::with(['karyawan']);

        // Apply the filter if 'filter_karyawan' is present in the request
        if ($request->has('filter_karyawan') && $request->filter_karyawan != "") {
            $query->where('karyawan_id', $request->filter_karyawan);
        }

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('karyawan', function ($query) {
                return $query->karyawan->nama_karyawan ?? '-';
            })
            ->addColumn('action', function ($query) {
                $aksi = '';
                $user = Auth::user();

                if ($user->can("Pelanggan Edit")) {
                    $aksi .= '
                        <button onclick="editForm(`' . route('pelanggan.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></button>

                    ';
                }
                if ($user->can("Pelanggan Delete")) {
                    $aksi .= '
                        <button onclick="deleteData(`' . route('pelanggan.destroy', $query->id) . '`, `' . $query->nama_toko . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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
            'nama_toko' => 'required',
            'nama_pemilik' => 'required',
            'nomor_hp' => 'required',
            'alamat' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf inputan yang anda masukan salah, silahkan periksa kembali dan coba lagi'], 422);
        }

        $data = [
            'nama_toko'   => $request->nama_toko,
            'nama_pemilik'   => $request->nama_pemilik,
            'nomor_hp'   => $request->nomor_hp,
            'alamat'   => $request->alamat,
            'karyawan_id'   => Auth::user()->karyawan->id ?? Null,
        ];

        Pelanggan::create($data);

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        return response()->json(['data' => $pelanggan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $rules = [
            'nama_toko' => 'required',
            'nama_pemilik' => 'required',
            'nomor_hp' => 'required',
            'alamat' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf inputan yang anda masukan salah, silahkan periksa kembali dan coba lagi'], 422);
        }

        $data = [
            'nama_toko'   => $request->nama_toko,
            'nama_pemilik'   => $request->nama_pemilik,
            'nomor_hp'   => $request->nomor_hp,
            'alamat'   => $request->alamat,
            'karyawan_id'   => Auth::user()->karyawan->id,
        ];

        $pelanggan->update($data);

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
