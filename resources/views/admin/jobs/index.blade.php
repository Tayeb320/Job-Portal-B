@extends('admin.partials.master')

@section('title')
    Job List
@endsection
@section('jobs')
    active
@endsection

@section('main-content')
    <div class="d-flex justify-content-between">
        <div class="d-block">
            <h2 class="pagetitle">Jobs</h2>
            <p>You have total {{ $jobs->total() }} jobs</p>
        </div>
        <div class="buttons add-button">
            <a href="{{ route('job.create') }}" class="btn btn-icon icon-left btn-outline-primary">
                <i class="bi bi-plus"></i>{{ __('Add') }}</a>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Job Lists</h5>

                        <!-- Table with hoverable rows -->
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Thumb</th>
                                <th scope="col">Title</th>
                                <th scope="col">Job Type</th>
                                <th scope="col">Status</th>
                                <th scope="col">Total Applicants</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($jobs as $key => $job)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>
                                        @if ($job->thumbnail != [] && file_exists($job->thumbnail['image_thumbnail']))
                                            <img src="{{ asset($job->thumbnail['image_thumbnail']) }}"
                                                 alt="{{ $job->title }}"
                                                 class="rounded">
                                        @else
                                            <img src="{{ asset('images/default-40x40.png') }}"
                                                 alt="{{ $job->title }}"
                                                 class="mr-3 rounded">
                                        @endif
                                    </td>
                                    <td> {{ $job->title }}</td>
                                    <td>{{ @$job->jobType->title }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-change" value="jobs/{{$job->id}}"
                                                   {{ $job->status == 1 ? 'checked' : '' }} type="checkbox"
                                                   id="flexSwitchCheckDefault">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                                        </div>
                                    </td>
                                    <td>{{ $job->applicants->count() }}</td>
                                    <td>
{{--                                        <a href="{{ route('edit.job',$job->id) }}"--}}
{{--                                           class="btn btn-outline-info btn-circle" data-bs-toggle="tooltip"--}}
{{--                                           data-bs-placement="top" title="" data-bs-original-title="View">--}}
{{--                                            <i class="bi bi-eye"></i>--}}
{{--                                        </a>--}}
                                        <a href="{{ route('edit.job',$job->id) }}"
                                           class="btn btn-outline-secondary btn-circle" data-bs-toggle="tooltip"
                                           data-bs-placement="top" title="" data-bs-original-title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           onclick="delete_row('delete/jobs/', {{ $job->id }})"
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
                            {{ $jobs->appends(Request::except('page'))->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@include('admin.common.delete')
@include('admin.common.change-status')
