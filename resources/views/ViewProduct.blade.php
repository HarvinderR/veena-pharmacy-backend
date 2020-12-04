@extends('include.master')

@section('title')
    Home
@endsection

@section('content')

    <div class="container mt-5">
        <table class="table table-bordered table-striped  table-dark table-sm">
            <thead>
            <tr class="table-info">
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Salt</th>
                <th scope="col">Price</th>
                <th scope="col">Image url</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody id ="tbodyid">

            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $product->links('pagination::bootstrap-4') !!}
        </div>
    </div>

@endsection

@section('script')
    <script >
        var a = [];
        @foreach($product as $data)
            var d =[];
            d['id'] = {{$data->id}};
            d['name'] = "{{$data->name}}";
            d['salt'] = "{{$data->salt}}";
            d['price'] = "{{$data->price}}";
            d['manufacture'] = "{{$data->manufacture}}";
            d['salt_link'] = "{{$data->salt_link}}";
            d['img'] = "{{$data->img}}";
            a[{{$data->id}}] = d;
        @endforeach
        console.log(a);
        $("#tbodyid").empty();

        a.forEach(myFunction);

        function myFunction(value, index, array) {
            //console.log(value)
            txt =
                "<tr>"+
                "<th scope='row'>"+value['id']+"</th>"
                +"<td>"+value['name']+"</td>"
                +"<td>"+value['salt']+"</td>"
                +"<td>"+value['price']+"</td>"
                +"<td><a href='"+value['img']+"' target='_blank'>"+value['img']+"</a> </td>"
                +"<td><p onclick=\"log([\""+value['id']+"\",\""+value['name']+"\",\""+value['salt']+"\"])\">Edit</p><p>Delete</p></td>"
                +"</tr>";
            $("#tbodyid").append(txt)
        }


        function log(a){
            console.log(a)
        }
    </script>
@endsection


