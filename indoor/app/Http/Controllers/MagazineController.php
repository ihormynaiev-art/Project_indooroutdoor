<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPdfToImage;
use App\Models\Magazine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class MagazineController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return DataTables::of(Magazine::query())->make();
        }

        return view('admin.magazines.index');
    }

    public function create(): View
    {
        return view('admin.magazines.create');
    }

    public function edit(Magazine $magazine): View
    {
        return view('admin.magazines.edit', [
            'magazine' => $magazine,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'slug' => ['required', 'unique:magazines'],
            'file' => ['required', 'file', 'mimes:pdf'],
        ]);

        $file = $request->file('file');
        $filePath = $file->store('uploads', 'public');

        $magazine = Magazine::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'prio' => $request->prio,
            'is_active' => boolval($request->is_active),
            'file_path' => $filePath,
        ]);

        if ($magazine) {
            ProcessPdfToImage::dispatch($magazine, auth()->user());
        }

        return redirect()->route('admin.magazines.index');
    }

    public function update(Magazine $magazine, Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'file' => ['file', 'mimes:pdf'],
        ]);

        $file = $request->file('file');

        if ($file) {
            $filePath = $file->store('uploads', 'public');
            $magazine->update(['file_path' => $filePath]);
        }

        $magazine->update([
            'name' => $request->name,
            'prio' => $request->prio,
            'is_active' => boolval($request->is_active),
        ]);

        if ($file) {
            ProcessPdfToImage::dispatch($magazine, auth()->user());
        }

        return redirect()->route('admin.magazines.index');
    }

    public function destroy(Magazine $magazine)
    {
        $magazine->delete();

        return response()->json(['status' => 'success']);
    }
}
