<?php

namespace App\Jobs;

use App\Models\File;
use App\Models\ProviderDetail;
use App\Services\TinifyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tinify\Exception;

class OptimizeImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ProviderDetail $providerDetail;

    private TinifyService $tinyfyServcie;

    /**
     * Create a new job instance.
     */
    public function __construct(ProviderDetail $providerDetail)
    {
        $this->providerDetail = $providerDetail;
        $this->providerDetail->load('portfolioImages');
        $this->tinyfyServcie = new TinifyService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->providerDetail->portfolioImages()->each(function ($image) {
            if (! File::exists($image->path) || $image->is_optimized) {
                Log::error("File dont exist: {$image->path}");

                return;
            }
            try {
                $mimeType = FileFacade::mimeType(storage_path(('app/public/'.$image->path)));
                if (! in_array($mimeType, ['image/png', 'image/jpeg', 'image/jpg'])) {
                    $image->is_optimized = true;

                    Log::error("Unsupported file type for TinyPNG: {$mimeType} for image {$image->path}");

                    return;
                }

                $this->tinyfyServcie->setKey(config('tinify.api_key'));

                $imageBuffer = file_get_contents(storage_path(('app/public/'.$image->path)));

                $optimizedBuffer = $this->tinyfyServcie->fromBuffer($imageBuffer)->toBuffer();

                if ($optimizedBuffer) {
                    FileFacade::delete($image->path);
                    Storage::put('public/'.$image->path, $optimizedBuffer);
                    $image->is_optimized = true;
                    $image->save();
                }
            } catch (Exception $e) {
                Log::error("Image optimized error {$image->path}: {$e->getMessage()}");
            }
        });
    }
}
