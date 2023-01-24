@extends('layouts.app')

@section('content')
    <h3 class="mb-3">Companies</h3>
    <div class="mb-5">
        <a class="btn btn-success btn-sm" href="<?= route('company.create') ?>">Create company</a>
    </div>
    <table class="table table-bordered yajra-datatable-company">
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Logo</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

@endsection
