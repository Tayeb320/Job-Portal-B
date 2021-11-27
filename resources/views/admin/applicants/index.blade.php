@extends('admin.partials.master')

@section('title')
    Applicants List
@endsection
@section('applicants')
    active
@endsection

@section('main-content')

    <div class="pagetitle">
        <h1>Applicants</h1>
        <p>You have total {{ $applicants->total() }} applicants</p>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Applicant Lists</h5>

                        <!-- Table with hoverable rows -->
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Age</th>
                                <th scope="col">Status</th>
                                <th scope="col">Job Applied</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applicants as $key => $applicant)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $applicant->name }}</td>
                                    <td>{{ $applicant->phone }}</td>
                                    <td>28</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-change" value="applicants/{{$applicant->id}}"
                                                   {{ $applicant->status == 1 ? 'checked' : '' }} type="checkbox"
                                                   id="flexSwitchCheckDefault">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                                        </div>
                                    </td>
                                    <td>{{ $applicant->jobs->count() }}</td>
                                    <td>
                                        <a href="{{ route('applicant.detail',$applicant->id) }}"
                                           class="btn btn-outline-info btn-circle" data-bs-toggle="tooltip"
                                           data-bs-placement="top" title="" data-bs-original-title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           onclick="delete_row('delete/applicant/', {{ $applicant->id }})"
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
                </div>

            </div>
        </div>
    </section>
@endsection
@include('admin.common.delete')
@include('admin.common.change-status')
