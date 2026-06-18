{{-- filepath: resources/views/Recycle.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recycle Post') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        @if ($contents->isEmpty())
            <div class="alert alert-warning text-center">NO POST</div>
        @else
            <div class="row">
                @php $hasRejected = false; @endphp
                @foreach ($contents as $content)
                    @if ($content->Status == 'rejected')
                        @php $hasRejected = true; @endphp
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">By {{ $content->name ?? 'Anonymous' }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $content->title ?? '' }}</h6>
                                    <p class="card-text">{{ $content->body }}</p>
                                </div>
                                @php
                                    $mediaArray = is_array($content->media)
                                        ? $content->media
                                        : (json_decode($content->media, true) ?? []);
                                @endphp
                                @if (!empty($mediaArray))
                                    <div class="card-footer bg-white">
                                        <div class="d-flex flex-wrap gap-2 justify-content-start">
                                            @foreach ($mediaArray as $media)
                                                @php $mediaPath = 'storage/' . $media; @endphp
                                                <img src="{{ asset($mediaPath) }}" class="img-thumbnail media-thumb" alt="Media">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <div class="card-footer bg-white d-flex justify-content-between mt-2">
                                    <form action="{{ route('recover', $content->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        
                                        <button type="submit" class="btn btn-success btn-sm" value="" name='Status' id='Status'>Recover</button>
                                    </form>
                                    <form action="{{route('delete', $content->id)}}" method="POST" style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to permanently delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if (!$hasRejected)
                    <div class="alert alert-warning text-center">NO POST</div>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>