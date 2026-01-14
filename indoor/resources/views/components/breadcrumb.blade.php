<!-- Breadcrumb -->

<div class="breadcrumb-bar bb-image"
      style="background-image: url('{{ $image ?? '' }}')" >
    <div class="container">
        <div class="row">
                <div class="col-md-12">
                    <h2 class="breadcrumb-title mb-0">{{ $title }}</h2>
                    @if(!empty($subtitle))
                        <h3 class="breadcrumb-subtitle mt-2">{{ $subtitle }}</h3>
                    @endif
                </div>
        </div>
    </div>
</div>


<!-- /Breadcrumb -->
