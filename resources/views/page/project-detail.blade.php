@extends('layouts.app')

@section('title', 'Project Detail' . $project->title)

@section('content')
    <div class="container py-4">
        <div class="mb-4 g-4">
            <a href="{{ route('project.index') }}" class="btn btn-danger">Kembali</a>
        </div>
        <div class="row g-4">
            <div class="col-md-7">
                <img src="{{ asset('images/' . $project->image) }}" class="img-fluid h-100 w-100"
                    style="min-height: 300px; object-fit: cover;" alt="">
            </div>
            <div class="col-md-5">
                <div class="card-body">
                    <div class="mb-2">
                        <span
                            class="badge {{ $project->status == 'Selesai' ? 'bg-success' : 'bg-warning' }} mb-2">{{ $project->status }}</span>
                    </div>

                    <h4 class="card-title fw-bold">{{ $project->title }}</h4>
                    <p class="text-muted card-text">{{$project->description}}</p>
                    <div class="mb-2">
                        <small class="text-muted">Tech: {{ $project->teknologi }}</small>
                    </div>
                    <hr>
                    <div class="text-muted small">
                        <span>Dibuat pada : {{ $project->created_at->format('d M y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection