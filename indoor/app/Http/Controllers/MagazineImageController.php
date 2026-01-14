<?php

namespace App\Http\Controllers;

use App\Models\MagazineImage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MagazineImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            return DataTables::of(MagazineImage::query()->where('magazine_id', $id))->make();
        }

        return view('admin.magazineImages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function update(Request $request, MagazineImage $magazineImage)
    {
        if ($request->has('is_active')) {
            $magazineImage->is_active = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);
        } elseif ($request->has('url')) {
            $magazineImage->url = $request->input('url');
        }

        if ($magazineImage->save()) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MagazineImage $magazineImage)
    {
        $magazineImage->delete();

        return response()->json(['status' => 'success']);
    }
}
