<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masterdata.kategori.index');
    }

    public function data()
    {
        $query = Category::all();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                $aksi = '';
                $user = Auth::user();

                if ($user->can("Kategori Edit")) {
                    $aksi .= '
                        <button onclick="editForm(`' . route('category.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></button>

                    ';
                }
                if ($user->can("Kategori Delete")) {
                    $aksi .= '
                        <button onclick="deleteData(`' . route('category.destroy', $query->id) . '`, `' . $query->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi'], 422);
        }

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        Category::create($data);

        return response()->json(['message' => 'Data kategori berhasil disimpan.'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json(['data' => $category], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi'], 422);
        }

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        $category->update($data);

        return response()->json(['message' => 'Data kategori berhasil disimpan.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Data kategori berhasil dihapus.'], 200);
    }

    public function search()
    {
        $keyword = request('keyword');
        $result = Category::where('name', 'like', "%" . $keyword . "%")->get();
        return $result;
    }
}
