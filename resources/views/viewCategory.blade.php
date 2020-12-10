@extends('include.master')

@section('title')
    View Category
@endsection

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="showProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="catNameModal">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped  table-dark table-sm">
                        <thead>
                        <tr>
                            <th>Product id</th>
                            <th>Product Name</th>
                            <th>Product Salt</th>
                        </tr>
                        </thead>
                        <tbody id ="tbodyProduct">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped  table-dark table-sm">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Title</th>
            <th>Option</th>
        </tr>
        </thead>
        <tbody id ="tbodyid">

        </tbody>
    </table>

@endsection

@section('script')
    <link rel="stylesheet" href="{{ asset('css/create-category.css') }}">
    <script src="{{asset('js/view-category.js')}}"></script>
@endsection


