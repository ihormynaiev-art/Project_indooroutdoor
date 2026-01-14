<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileUploadPreview extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $inputId,
        public string $previewClass,
        public string $uploadBtnId,
        public string $errorId,
        public string $variableName,
        public string $accept = '',
        public string $fileRequirements = 'Allowed file types: JPG, PNG, PDF, DOC, DOCX<br>Maximum file size: 5MB'
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.file-upload-preview');
    }
}
