@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">
            <div>
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                @if($providerMessage->user)
                    <div class="border border-black col-md-6 rounded-1 p-2 my-4">
                        <p class="text-black">User Information:</p>
                        <p><b>Name: </b>{{ $providerMessage->user->name  }}</p>
                        <p><b>Email: </b>{{ $providerMessage->user->email  }}</p>
                    </div>
                @endif

                <div class="col-lg-6 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label"> Contact </label>
                        <input
                            required
                            name="name"
                            disabled
                            type="text"
                            class="form-control"
                            value="{{ $providerMessage->contact }}"
                        >
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label"> Message </label>
                        <textarea
                            name="slug"
                            type="text"
                            required
                            rows="15"
                            disabled
                            class="form-control"
                        >{{ $providerMessage->message }}</textarea>
                    </div>
                </div>

                @foreach($providerMessage->images as $image)
                    <div class="col-md-3 col-sm-12">
                        <div class="testimonial-image w-100 p-2 d-flex justify-content-center">
                            <a target="_blank" href="{{ url('storage/' . $image->path) }}">
                                <img src="{{ url('storage/' . $image->path) }}" alt="Image - {{ $loop->index }}">
                            </a>
                        </div>
                    </div>
                @endforeach

                <form action="{{ route('provider.provider-messages.update', ['provider_message' => $providerMessage]) }}"
                      method="post">
                    @method('put')
                    @csrf
                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label"> Internal Comment </label>
                            <textarea
                                name="comment"
                                type="text"
                                rows="15"
                                class="form-control"
                            >{{ $providerMessage->comment }}</textarea>
                        </div>
                    </div>
                    <button class="site-button site-button-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            @if(session('status'))
            Swal.fire({
                toast: true,
                icon: 'success',
                title: @json(session('status')),
                animation: false,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            @endif
        });
    </script>
@endsection

