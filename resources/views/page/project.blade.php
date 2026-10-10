@extends('layouts.app')

@section('title', 'Project')

@section('content')
    <div class="container flex-grow-1">
        <div class="mb-4 text-center">
            <h2 class="fw-bold">Portofolio Project</h2>
            <p class="text-muted">Daftar project yang pernah dikerjakan oleh mahasiswa</p>
        </div>
        <div class="row g-4">
            @foreach ($projects as $project)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ asset('images/' . $project->image) }}" class="rounded-circle img-thumbnail shadow-sm"
                            style="width: 120px; height: 120px; object-fit: cover;" alt="">

                        <div class="card-body">
                            <span
                                class="badge {{ $project->status == 'Selesai' ? 'bg-success' : 'bg-warning' }} mb-2">{{ $project->status }}</span>
                            <h4 class="card-title fw-bold">{{ $project->title }}</h4>
                            <p class="text-muted card-text">{{ Str::limit($project->description, 50) }}</p>

                            <div class="card-footer bg-white border-0 pb-3">
                                <div class="mb-2">
                                    <small class="text-muted">Tech {{ $project->teknologi }}</small>
                                </div>
                                <a href="{{ route('project.show', $project->id) }}" class="btn btn-primary w-100">Detail
                                    Project</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $projects->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection