@extends('layouts.admin')

@section('title', 'Edit Note - Admin Panel | Ruang Sunyi')

@section('content')
<main class="flex-grow-1 py-4">
    <div class="container-fluid px-3 px-md-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Breadcrumb & title --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 font-mono small text-secondary">
                        <li class="breadcrumb-item"><a class="text-secondary text-decoration-none" href="{{ route('admin.index') }}">Writing Space</a></li>
                        <li aria-current="page" class="breadcrumb-item active text-light">Edit Note</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-light mb-4">Edit Note</h1>

                <div class="card card-custom shadow-sm">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex align-items-center gap-2">
                        <div class="text-primary bg-primary bg-opacity-10 p-1.5 rounded">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <span class="fw-semibold text-light small text-uppercase font-mono">Edit Note &amp; Status</span>
                    </div>

                    <div class="card-body p-3 p-md-4">
                        <form method="POST" action="{{ route('admin.notes.update', $note) }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')

                            @include('admin.notes._form', ['note' => $note])

                            <div class="d-flex justify-content-between align-items-center gap-2 mt-4 pt-3 border-top border-secondary border-opacity-25">
                                <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                                    <i class="bi bi-arrow-left me-1"></i>Cancel
                                </a>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-secondary btn-sm px-3" type="submit" name="status" value="draft">
                                        <i class="bi bi-file-earmark-text me-1"></i>Save as Draft
                                    </button>
                                    <button class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-1.5 shadow" type="submit" name="status" value="published">
                                        <span>Save &amp; Publish</span>
                                        <i class="bi bi-check2-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
