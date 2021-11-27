@extends('admin.partials.master')

@section('title')
    Job Type List
@endsection
@section('job_types')
    active
@endsection

@section('main-content')
    <div class="d-flex justify-content-between">
        <div class="d-block">
            <h2 class="pagetitle">Job Types</h2>
            <p>You have total {{ $job_types->total() }} job types</p>
        </div>
        <div class="buttons add-button">
            <a href="{{ route('job-type.create') }}" class="btn btn-icon icon-left btn-outline-primary">
                <i class="bi bi-plus"></i>{{ __('Add') }}</a>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Job Type Lists</h5>

                        <!-- Table with hoverable rows -->
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($job_types as $key => $job_type)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $job_type->title }}</td>
                                    <td>{{ $job_type->slug }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-change" value="job_types/{{$job_type->id}}"
                                                   {{ $job_type->status == 1 ? 'checked' : '' }} type="checkbox"
                                                   id="flexSwitchCheckDefault">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('edit.job-type',$job_type->id) }}"
                                           class="btn btn-outline-secondary btn-circle" data-bs-toggle="tooltip"
                                           data-bs-placement="top" title="" data-bs-original-title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           onclick="delete_row('delete/job_types/', {{ $job_type->id }})"
                                           class="btn btn-outline-danger btn-circle" data-bs-toggle="tooltip"
                                           data-bs-placement="top" title="" data-bs-original-title="Delete">
                                            <i class='bi bi-trash'></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with hoverable rows -->

                    </div>
                    <div class="card-footer py-0 border-0">
                        <nav class="d-inline-block">
                            {{ $job_types->appends(Request::except('page'))->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@include('admin.common.delete')
@include('admin.common.change-status')
