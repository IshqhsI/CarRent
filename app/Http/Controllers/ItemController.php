<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Type;
use App\Models\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
    public function store(Request $request)
    {
        //
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
