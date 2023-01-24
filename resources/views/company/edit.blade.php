@extends('layouts.app')

@section('content')
    <h3 class="mb-3">Update company</h3>
    <div class="mb-5">
        <a class="btn btn-success btn-sm" href="<?= route('company.index') ?>">Companies</a>
    </div>
    <div>
        @if($errors->any())
            <div  class="alert alert-danger" role="alert">
                {{ implode('', $errors->all(':message')) }}
            </div>
        @endif
    </div>
    <form enctype="multipart/form-data" action="/company/update/<?= $company->id ?>" method="post">
        @csrf
        <input type="hidden" name="id" value="<?= $company->id ?>">
        <div class="form-group">
            <label for="name">Company name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Fill the company name" value="<?= $company->name ?>">
        </div>
        <div class="form-group">
            <label for="email">Company email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Fill the company email"  value="<?= $company->email ?>">
        </div>
        <div class="form-group">
            <label for="address">Company address</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="Fill the company address" value="<?= $company->address ?>">
        </div>
        @if ($company->logo)
        <div class="form-group">
            <img width="150" src="/uploads/<?=$company->logo?>" alt="">
        </div>
        @endif
        <div class="form-group">
            <label for="logo">Choose the company logo</label>
            <input type="file" class="form-control-file" name="logo" id="logo">
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
@endsection
