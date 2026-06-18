<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="Main-Container">
        <div class="left-content">

            <div class="content-all">
                <p class='Header-dashboard'>Freedom Wall Post</p>

                <div class="review-content">
                    <div class="container mt-4">
                        @php
                            $acceptedContents = $contents->where('Status', 'accepted');
                        @endphp
                        @if ($acceptedContents->isEmpty())
                            <div class="alert alert-warning text-center">NO POST</div>
                        @else
                            <div class="review-content-inside">
                                @foreach ($acceptedContents as $content)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card-content h-100 shadow-sm">
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
                                                            @if (file_exists(public_path($mediaPath)))
                                                                <img src="{{ asset($mediaPath) }}" class="img-thumbnail media-thumb"
                                                                    alt="Media">
                                                            @else
                                                                <img src="{{ asset('images/placeholder.png') }}"
                                                                    class="img-thumbnail media-thumb" alt="No Image">
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="card-footer-content bg-white d-flex justify-content-end mt-2">
                                                <form action="{{route('reject', $content->id)}}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" name="Status"
                                                        value="rejected" id="Status" name="Status">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div><!-- End of review-content -->

            </div>

        </div><!-- End of left-content -->

        <div class="right-content">

            <div class="content-all">
                <p class='Header-dashboard'>Freedom Wall Post Request</p>

                <div class="review-content">
                    <div class="container mt-4">
                        @php
                            $pendingContents = $contents->where('Status', null);
                        @endphp
                        @if ($pendingContents->isEmpty())
                            <div class="alert alert-warning text-center">NO POST</div>
                        @else
                            <div class="review-content-inside">
                                @foreach ($pendingContents as $content)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card-content h-100 shadow-sm">
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
                                                            @if (file_exists(public_path($mediaPath)))
                                                                <img src="{{ asset($mediaPath) }}" class="img-thumbnail media-thumb"
                                                                    alt="Media">
                                                            @else
                                                                <img src="{{ asset('images/placeholder.png') }}"
                                                                    class="img-thumbnail media-thumb" alt="No Image">
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="card-footer-content bg-white d-flex justify-content-between mt-2">
                                                <form action="{{ route('accept', $content->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" value="accepted"
                                                        name="Status" id="Status">Accept</button>
                                                </form>

                                                <form action="{{route('reject', $content->id)}}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" name="Status"
                                                        value="rejected" id="Status" name="Status">Reject</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div><!-- End of review-content -->

            </div>

        </div><!-- End of right-content -->

    </div>
</x-app-layout>