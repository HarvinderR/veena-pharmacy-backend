@extends('include.master')

@section('title')
    Home
@endsection

@section('content')
    <div class="row" style="margin-top: 20px">
        <div class="col d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">View product</h5>
                    <p class="card-text">You can view all of the products that is uploaded last.</p>
                    <a href="{{url("viewProducts")}}" class="btn btn-primary">View products</a>
                </div>
            </div>
        </div>
        <div class="col d-flex justify-content-center">
            <div class="card d-flex" style="width: 18rem;">

                <div class="card-body  align-self-center my-auto">
                    <h5 class="card-title">Upload product</h5>
                    <p class="card-text">You can upload all of the products by uploading the sheet.</p>
                    <a href="{{ url("uploadProducts") }}" class="btn btn-primary">Upload products</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Create Category</h5>
                    <p class="card-text">You can create the category.</p>
                    <a href="{{url("createCategory")}}" class="btn btn-primary">Create Category</a>
                </div>
            </div>
        </div>
        <div class="col d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">View Category</h5>
                    <p class="card-text">You can view all the category.</p>
                    <a href="{{url("viewCategory")}}" class="btn btn-primary">View All Category</a>
                </div>
            </div>
        </div>
    </div>

@endsection


