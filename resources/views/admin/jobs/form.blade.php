@extends('admin.partials.master')

@php
    $title   = isset($job) ? 'Update Job' : 'Add Job';
    $route   = isset($job) ? route('update.job') : route('store.job');
    $button  = isset($job) ? 'Update' : 'Add';
@endphp

@section('title')
    {{ $title }}
@endsection

@section('jobs')
    active
@endsection

@section('main-content')
    <section class="section">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $title }}</h5>

                    <!-- Vertical Form -->
                    <form action="{{$route}}" method="post" class="row g-3" enctype="multipart/form-data">
                        @csrf
                        @isset($job)
                            @method('put')
                        @endif
                        <div class="col-12">
                            <label for="job_type" class="form-label">Job Type</label>
                            <input type="hidden" value="{{ @$job->id }}" name="id">
                            <input type="hidden" value="{{ isset($job) }}" name="update">
                            <select class="form-select" aria-label="Select Type" name="job_type" required>
                                <option value="" selected>Select Type</option>
                                @foreach($job_types as $type)
                                    <option
                                        value="{{ $type->id }}" {{ old('job_type') == $type->id ? 'selected' : (@$job->job_type_id == $type->id ? 'selected' : '') }}>
                                        {{ $type->title }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('job_type'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('job_type') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter title" required
                                   value="{{ old('title') ? old('title') : @$job->title }}" id="title">
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
                                   value="{{ old('slug') ? old('slug') : @$job->slug }}">
                            @if ($errors->has('slug'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('slug') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" name="thumbnail" {{ !isset($job) ? 'required' : '' }} id="thumbnail">
                            @if ($errors->has('thumbnail'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('thumbnail') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="tinymce-editor" name="description" required
                                      style="height: 200px"> {{ old('description') ? old('description') : @$job->description }} </textarea>
                            @if ($errors->has('description'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('description') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title"
                                   value="{{ old('meta_title') ? old('meta_title') : @$job->meta_title }}"
                                   class="form-control">
                            @if ($errors->has('meta_title'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('meta_title') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords"
                                   value="{{ old('meta_keywords') ? old('meta_keywords') : @$job->meta_keywords}}"
                                   class="form-control">
                            @if ($errors->has('meta_keywords'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('meta_keywords') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description"
                                      style="height: 100px">{{ old('meta_description') ? old('meta_description') : @$job->meta_description }}</textarea>
                            @if ($errors->has('meta_description'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('meta_description') }}</p>
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
