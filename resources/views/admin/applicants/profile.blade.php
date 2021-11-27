@extends('admin.partials.master')

@section('title')
    Applicant Profile
@endsection
@section('applicants')
    active
@endsection

@section('main-content')

    <div class="pagetitle">
        <h1>Applicant Profile</h1>
        <p>Total job applied {{ $applicant->jobs->count() }}</p>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        @if($applicant->image != [] && file_exists($applicant->image['image_thumbnail']))
                            <img src="{{ asset($applicant->image['image_thumbnail']) }}" alt="Profile" class="rounded-circle">
                        @else
                            <img src="{{ asset('images/user.jpg') }}" alt="Profile" class="rounded-circle">
                        @endif
                        <h2>{{ $applicant->name }}</h2>
                        <p>Total job applied {{ $applicant->jobs->count() }}</p>
{{--                        <div class="social-links mt-2">--}}
{{--                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>--}}
{{--                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>--}}
{{--                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>--}}
{{--                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>--}}
{{--                        </div>--}}
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#applied-jobs">Applied Jobs</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">About</h5>
                                <p class="small fst-italic">{{ $applicant->profile->about }}</p>

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Name</div>
                                    <div class="col-lg-9 col-md-8">{{ $applicant->name }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">{{ $applicant->phone }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $applicant->email }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">CV</div>
                                    <div class="col-lg-9 col-md-8">
                                        @if($applicant->profile->cv != '' && file_exists($applicant->profile->cv))
                                            <a target="_blank" href="{{ asset($applicant->profile->cv) }}" download="{{ $applicant->name.' CV' }}" class="dropdown-item">
                                                <i class='bi bi-download'></i> {{ __('Download') }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade applied-jobs pt-3" id="applied-jobs">

                                <!-- Profile Edit Form -->

                                <div class="row mb-3">
                                    <table class="table table-responsive table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Thumb</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Job Type</th>
                                            <th scope="col">Total Applicants</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($applicant->jobs as $key => $job)
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
                                                <td>{{ $job->applicants->count() }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- End Bordered Tabs -->
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
