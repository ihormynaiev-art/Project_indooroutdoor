<?php

namespace App\Jobs;

use App\Mail\PdfToImageProcessCompleted;
use App\Models\Magazine;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;

class ProcessPdfToImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Magazine $magazine,
        public User $user
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! Storage::disk('public')->exists('images')) {
            Storage::disk('public')->makeDirectory('images');
        }

        $pdf = new Pdf(Storage::disk('public')->path($this->magazine->file_path));
        $pagesNumb = $pdf->getNumberOfPages();

        for ($j = 1; $j <= $pagesNumb; $j++) {
            $path = 'images/'.$this->magazine->slug.'-'.$j.'.jpg';
            $this->magazine->magazineImages()->create([
                'path' => $path,
            ]);

            $pdf->setPage($j)->saveImage(Storage::disk('public')->path($path));
        }

        Mail::to($this->user->email)->send(new PdfToImageProcessCompleted($this->user));
    }
}
