<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masterdata.produk.index');
    }

    public function data()
    {
        $query = Product::with(['satuan', 'category'])->get();

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('barcode', function ($query) {
                return '<span class="badge badge-success">' . $query->barcode . '</span>';
            })
            ->editColumn('harga_beli', function ($query) {
                return format_uang($query->harga_beli);
            })
            ->editColumn('harga_jual', function ($query) {
                return format_uang($query->harga_jual);
            })
            ->editColumn('satuan', function ($query) {
                return $query->satuan->name;
            })
            ->addColumn('action', function ($query) {
                $aksi = '';
                $user = Auth::user();

                if ($user->can("Produk Edit")) {
                    $aksi .= '
                        <button onclick="editForm(`' . route('product.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></button>
                    ';
                }
                if ($user->can("Produk Delete")) {
                    $aksi .= '
                        <button onclick="deleteData(`' . route('product.destroy', $query->id) . '`, `' . $query->nama_produk . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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
            'barcode' => 'required',
            'nama_produk' => 'required',
            'satuan' => 'required',
            'kategori' => 'required',
            'stok' => 'required',
            'harga_beli' => 'required|regex:/^[0-9.]+$/|',
            'harga_jual' => 'required|regex:/^[0-9.]+$/|',
            'deskripsi' => 'required',
            'image' => 'required||mimes:jpeg,png,jpg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi'], 422);
        }

        $data = $request->except('path_image');
        $data = [
            'barcode' => $request->barcode,
            'nama_produk' => $request->nama_produk,
            'satuan_id' => $request->satuan,
            'category_id' => $request->kategori,
            'stok' => $request->stok,
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
            'deskripsi' => $request->deskripsi,
            'image' => upload('product', $request->image, 'product'),
        ];

        Product::create($data);

        return response()->json(['message' => 'Data produk berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('satuan', 'category');
        $product->image = Storage::url($product->image);
        $product->harga_beli = format_uang($product->harga_beli);
        $product->harga_jual = format_uang($product->harga_jual);

        return response()->json(['data' => $product]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'barcode' => 'required',
            'nama_produk' => 'required',
            'satuan' => 'required',
            'kategori' => 'required',
            'stok' => 'required',
            'harga_beli' => 'required|regex:/^[0-9.]+$/|',
            'harga_jual' => 'required|regex:/^[0-9.]+$/|',
            'deskripsi' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi'], 422);
        }

        $data = $request->except('path_image');
        $data = [
            'barcode' => $request->barcode,
            'nama_produk' => $request->nama_produk,
            'satuan_id' => $request->satuan,
            'category_id' => $request->kategori,
            'stok' => $request->stok,
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = upload('product', $request->file('image'), 'product');
        }

        $product->update($data);

        return response()->json(['message' => 'Data produk berhasil disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json(['message' => 'Data produk berhasil dihapus']);
    }
}
