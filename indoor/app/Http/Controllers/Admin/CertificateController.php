<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{

    public function destroy(File $file)
    {
        if (
            $file->fileable_type !== 'App\\Models\\ProviderDetail' ||
            !auth()->user()->hasRole('admin|super admin')
        ) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        $file->delete();

        return response()->json(['status' => 'success']);
    }
}
