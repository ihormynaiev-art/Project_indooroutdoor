<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveEditionRequest;
use App\Settings\GeneralSettings;
use Illuminate\View\View;

class EditionController extends Controller
{
    public function show(GeneralSettings $settings)
    {
        return view('edition', [
            'settings' => $settings,
        ]);
    }

    public function edit(GeneralSettings $settings): View
    {
        return view('admin.edition.edit', [
            'settings' => $settings,
        ]);
    }

    public function update(GeneralSettings $settings, SaveEditionRequest $request)
    {
        $imgPaths = json_decode($request->input('image_paths'), true);

        if (count($imgPaths) > 0) {
            foreach ($imgPaths as $path) {
                $settings->removeImage($path);
            }
        }

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $settings->addImage($file->store('edition', 'public'));
            }
        }

        $settings->edition_name = $request->input('name');
        $settings->edition_code = $request->input('code');

        $settings->save();

        return redirect()->back();
    }
}
