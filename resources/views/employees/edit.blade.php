@extends('layouts.app')

@section('content')
    <h3 class="mb-3">Update employees</h3>
    <div class="mb-5">
        <a class="btn btn-success btn-sm" href="<?= route('employees.index') ?>">Employees</a>
    </div>
    <div>
        @if($errors->any())
            <div  class="alert alert-danger" role="alert">
                {{ implode('', $errors->all(':message')) }}
            </div>
        @endif
    </div>
    <form action="/employees/update/<?= $employees->id ?>" method="post">
        @csrf
        <input type="hidden" name="id" value="<?= $employees->id ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Fill the name" value="<?= $employees->name ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Fill the email"  value="<?= $employees->email ?>">
        </div>
        <div class="form-group">
            <label for="telephone">Telephone</label>
            <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Fill the telephone" value="<?= $employees->telephone ?>">
        </div>
        <div class="form-group">
            <label for="company_id">Company</label>
            <select type="text" class="form-control" name="company_id" id="company_id">
                @forelse($companies as $company)
                    <option <?=  $company->id == $employees->company_id ? ' selected ' : '' ?> value="<?= $company->id ?>"><?= $company->name ?></option>
                @empty
                    <option value="">No data</option>
                @endforelse
            </select>
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
@endsection
