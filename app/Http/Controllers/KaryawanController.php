<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jabatan = Jabatan::all();
        return view('masterdata.karyawan.index', compact('jabatan'));
    }

    public function data()
    {
        $query = Karyawan::with(['jabatan', 'user'])->get();

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('foto', function ($query) {
                if ($query->photo === 'default.png') {
                    if ($query->jenis_kelamin_karyawan == 'Laki-laki') {
                        return '<img src="' . asset('img/laki_laki.png') . '" width="30" height="30" style="object-fit: cover; border-radius: 50px;">';
                    } else {
                        return '<img src="' . asset('img/perempuan.png') . '" width="30" height="30" style="object-fit: cover; border-radius: 50px;">';
                    }
                } else {
                    return '<img src="' . Storage::url($query->photo) . '" width="30" height="30" style="object-fit: cover; border-radius: 50px;">';
                }
            })

            ->editColumn('tgl_lahir', function ($query) {
                return $query->tempat_lahir . ', ' . tanggal_indonesia($query->tgl_lahir_karyawan);
            })
            ->editColumn('jabatan', function ($query) {
                return $query->jabatan->jabatan;
            })
            ->addColumn('action', function ($query) {
                $aksi = '';
                $user = Auth::user();

                if ($user->can("Karyawan Detail")) {
                    $aksi .= '
                        <a href="' . route('karyawan.detail', $query->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                    ';
                }

                if ($user->can("Karyawan Edit")) {
                    $aksi .= '
                        <button onclick="editForm(`' . route('karyawan.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></button>
                    ';
                }

                if ($user->can("Karyawan Delete")) {
                    $aksi .= '
                        <button onclick="deleteData(`' . route('karyawan.destroy', $query->id) . '`, `' . $query->nama_karyawan . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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
        try {
            DB::beginTransaction();

            $rules = [
                'nik_karyawan'           => 'required|unique:karyawans|min:16|max:16',
                'nama_karyawan'          => 'required',
                'tempat_lahir'           => 'required',
                'tgl_lahir_karyawan'     => 'required',
                'jenis_kelamin_karyawan' => 'required',
                'jabatan'                => 'required',
                'photo'                  => 'mimes:png,jpg,jpeg|max:2048',
                'alamat_karyawan'        => 'required',
                'no_telp_karyawan'       => 'required',
                'target_penjualan_bulan' => 'nullable|regex:/^[0-9.]+$/',
                'target_penjualan_harian' => 'nullable|regex:/^[0-9.]+$/',
                'email'                  => 'required|unique:users',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([$validator->errors(), 'message' => 'Maaf inputan yang anda masukan salah, silahkan periksa kembali dan coba lagi'], 422);
            }

            $user = new User;
            $user->name = $request->nama_karyawan;
            $user->username = $request->nik_karyawan;
            $user->email = $request->email;
            $user->password = Hash::make($request->nik_karyawan);
            $user->save();

            $role = Role::where('name', 'Karyawan')->first();
            if (!$role) {
                Role::create(['name' => 'Karyawan']);
                $user->assignRole('Karyawan');
            }
            $user->assignRole('Karyawan');

            $data = $request->except('photo', 'email');
            $data['target_penjualan_bulan'] = str_replace('.', '', $request->target_penjualan_bulan);
            $data['target_penjualan_harian'] = str_replace('.', '', $request->target_penjualan_harian);

            if ($request->hasFile('photo')) {
                $data['photo'] = upload('karyawan', $request->file('photo'), 'karyawan');
            }

            $data['user_id'] = $user->id;
            $data['jabatan_id'] = $request->jabatan;

            $karyawan = Karyawan::create($data);

            DB::commit();
            return response()->json(['message' => 'Data karyawan ' . $karyawan->nama_karyawan . ' berhasil ditambahkan'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        $karyawan->load(['jabatan', 'user']);
        $karyawan->photo = Storage::url($karyawan->photo);
        $karyawan->email = $karyawan->user->email;
        $karyawan->jabatan = $karyawan->jabatan->id;
        $karyawan->target_penjualan_bulan = format_uang($karyawan->target_penjualan_bulan);
        $karyawan->target_penjualan_harian = format_uang($karyawan->target_penjualan_harian);

        return response()->json([
            'data' => $karyawan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail(Karyawan $karyawan)
    {

        return view('masterdata.karyawan.detail', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'nik_karyawan'           => 'required|min:16|max:16|unique:karyawans,nik_karyawan,' . $karyawan->id,
                'nama_karyawan'          => 'required',
                'tempat_lahir'           => 'required',
                'tgl_lahir_karyawan'     => 'required',
                'jenis_kelamin_karyawan' => 'required',
                'jabatan'                => 'required',
                'photo'                  => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'alamat_karyawan'        => 'required',
                'no_telp_karyawan'       => 'required',
                'target_penjualan_bulan' => 'nullable|regex:/^[0-9.]+$/',
                'target_penjualan_harian' => 'nullable|regex:/^[0-9.]+$/',
                'email'                  => 'required|unique:users,email,' . $karyawan->user->id,
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([$validator->errors(), 'message' => 'Maaf inputan yang anda masukan salah, silahkan periksa kembali dan coba lagi'], 422);
            }

            $user = $karyawan->user;
            $user->name = $request->nama_karyawan;
            $user->username = $request->nik_karyawan;
            $user->email = $request->email;
            $user->save();

            $data = $request->except('photo', 'email');
            $data['target_penjualan_bulan'] = str_replace('.', '', $request->target_penjualan_bulan);
            $data['target_penjualan_harian'] = str_replace('.', '', $request->target_penjualan_harian);

            if ($request->hasFile('photo')) {
                if (Storage::disk('public')->exists($karyawan->photo)) {
                    Storage::disk('public')->delete($karyawan->photo);
                }

                $data['photo'] = upload('karyawan', $request->file('photo'), 'karyawan');
            }
            $data['jabatan_id'] = $request->jabatan;

            $karyawan->update($data);

            DB::commit();
            return response()->json(['message' => 'Data karyawan ' . $karyawan->nama_karyawan . ' berhasil diperbarui'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        if (Storage::disk('public')->exists($karyawan->photo)) {
            Storage::disk('public')->delete($karyawan->photo);
        }

        $karyawan->delete();
        $karyawan->user->delete();

        return response()->json(['message' => 'Data karyawan ' . $karyawan->nama_karyawan . ' berhasil dihapus'], 200);
    }
}
