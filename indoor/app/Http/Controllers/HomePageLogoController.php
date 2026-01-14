<?php

namespace App\Http\Controllers;

use App\Http\Requests\Logos\StoreHomePageLogosRequest;
use App\Http\Requests\Logos\UpdateHomePageLogosRequest;
use App\Models\HomePageLogo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class HomePageLogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return DataTables::of(HomePageLogo::query()->with('file'))->make();
        }

        return view('admin.logos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.logos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHomePageLogosRequest $request)
    {
        $logo = HomePageLogo::create([
            'slug' => $request->input('slug'),
            'prio' => $request->input('prio'),
            'is_active' => boolval($request->input('is_active')),
        ]);

        $file = $request->file('file');
        $filePath = $file->store('logos', 'public');

        $logo->file()->create([
            'name' => $file->getClientOriginalName(),
            'path' => $filePath,
        ]);

        return redirect(route('admin.logos.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(HomePageLogo $logo): View
    {
        $logo->load('file');

        return view('admin.logos.show', compact('logo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomePageLogo $logo): View
    {
        $logo->load('file');

        return view('admin.logos.edit', compact('logo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHomePageLogosRequest $request, HomePageLogo $logo)
    {
        $file = $request->file('file');
        if ($file) {
            $filePath = $file->store('logos', 'public');
            $logo->file->update(['path' => $filePath]);
        }

        $logo->update([
            'slug' => $request->input('slug'),
            'prio' => $request->input('prio'),
            'is_active' => $request->input('is_active'),
        ]);

        return redirect()->route('admin.logos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomePageLogo $logo): JsonResponse
    {
        $logo->delete();

        return response()->json(['status' => 'success']);
    }

    public function updateIsActive(Request $request, HomePageLogo $logo)
    {
        $logo->update([
            'is_active' => filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN),
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
