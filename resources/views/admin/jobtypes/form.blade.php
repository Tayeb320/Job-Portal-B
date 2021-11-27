@extends('admin.partials.master')

@php
    $title   = isset($job_type) ? 'Update Job Type' : 'Add Job Type';
    $route   = isset($job_type) ? route('update.job-type') : route('store.job-type');
    $button  = isset($job_type) ? 'Update' : 'Add';
@endphp

@section('title')
    {{ $title }}
@endsection

@section('job_types')
    active
@endsection

@section('main-content')
    <section class="section">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $title }}</h5>

                    <!-- Vertical Form -->
                    <form action="{{$route}}" method="post" class="row g-3">
                        @csrf
                        @isset($job_type)
                            @method('put')
                        @endif
                        <div class="col-12">
                            <label for="title" class="form-label">Title</label>
                            <input type="hidden" value="{{ @$job_type->id }}" name="id">
                            <input type="text" class="form-control" name="title" placeholder="Enter title" required
                                   value="{{ old('title') ? old('title') : @$job_type->title }}" id="title">
                            @if ($errors->has('title'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('title') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug"
                                   placeholder="Enter slug"
                                   value="{{ old('slug') ? old('slug') : @$job_type->slug }}">
                            @if ($errors->has('slug'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('slug') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">{{ $button }}</button>
                        </div>
                    </form><!-- Vertical Form -->

                </div>
            </div>
        </div>
    </section>
@endsection
