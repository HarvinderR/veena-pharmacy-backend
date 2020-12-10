@extends('include.master')

@section('title')
    Create Category
@endsection

@section('content')
    <button type="button" class="btn btn-primary editMode" onclick="saveCategory()" >Save</button>
    <a  class="btn btn-primary editMode" href="viewCategory" >View All</a>
    <form>
        <div class="form-group">
            <label for="CategoryNameControlInput1">Category Name</label>
            <input type="text" class="form-control" id="CategoryNameControlInput1" placeholder="Category Name">
        </div>
        <div class="form-group">
            <label for="CategoryTitleControlInput1">Category Title</label>
            <input type="text" class="form-control" id="CategoryTitleControlInput1" placeholder="Category Title">
        </div>
        <div class="form-group" style="display: none">
            <label for="exampleFormControlSelect1">Category Type</label>
            <select class="form-control" id="exampleFormControlSelect1">
                <option>Cat 1</option>
                <option>Cat 2</option>
                <option>Cat 3</option>
                <option>Cat 4</option>
                <option>Cat 5</option>
            </select>
        </div>
    </form>
    <table class="table table-bordered table-striped  table-dark table-sm">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody id ="tbodyid">

        </tbody>
    </table>

    <div class="autocomplete" style="width:400px;">
        <p class="add-product">Add Product</p>
        <input id="myInput" type="text" name="myCountry" placeholder="Add Product">
    </div>

@endsection

@section('script')
    <link rel="stylesheet" href="{{ asset('css/create-category.css') }}">
    <script src="{{asset('js/create-category.js')}}"></script>
@endsection


