@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <product-create></product-create>
                </div>
                <br>
                <div class="card">
                    <product-index></product-index>
                </div>
            </div>
        </div>
    </div>
@endsection


