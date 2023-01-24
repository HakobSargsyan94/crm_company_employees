@extends('layouts.app')

@section('content')

    <h3 class="mb-3">Company name : <?= $companyInfo->name ?></h3>
    <h3 class="mb-3">Company logo : <?= $companyInfo->logo ? "<img width='100' src='/uploads/".$companyInfo->logo."'>" : ''?></h3>
    <h3 class="mb-3">Company address : <?= $companyInfo->address ?></h3>
    <h3 class="mb-3">Company email : <?= $companyInfo->email ?></h3>
    @if (!empty($employees))
        @foreach($employees as $key => $employee)
            <h4 class="mb-3">Employee <?= $key+1 ?> name : <?= $employee->name ?></h4>
        @endforeach
    @endif

@endsection
