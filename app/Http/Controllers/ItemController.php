<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Type;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Item::query()->with(['brand', 'type']);
            return DataTables::of($query)
                ->addColumn(
                    'action',
                    function ($item) {
                        return '
                        <div class="flex justify-center">
                            <a href="' . route('admin.item.edit', $item->id) . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                            <form action="' . route('admin.item.destroy', $item->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                            </form>
                        </div>
                    ';
                    }
                )
                ->rawColumns(['action'])
                ->make();
        }
        return view('admin.item.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        $types = Type::all();
        return view('admin.item.create', compact('brands', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        $data = $request->all();
        try {
            $data['slug'] = Str::slug($request->name . '-' . Str::lower(Str::random(5)));
            // Store Images
            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->images as $image) {
                    $imgPath = $image->store('assets/item', 'public');
                    array_push($images, $imgPath);
                }
                $data['images'] = json_encode($images);
            }
            Item::create($data);
            return redirect()->route('admin.item.index')->with('success', 'Item created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
