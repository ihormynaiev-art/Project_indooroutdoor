<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AdminTestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return DataTables::of(Testimonial::query()->with('providerDetail'))->make();
        }

        return view('admin.testimonials.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial): View
    {
        $testimonial->load('images', 'videos');

        return view('admin.testimonials.show', compact('testimonial'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return response()->json(['status' => 'success']);
    }
}
