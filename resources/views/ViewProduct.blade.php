@extends('include.master')

@section('title')
    Home
@endsection

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id = "editProductItem">
                        <input type="hidden" id="recipient-id" >
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Salt:</label>
                            <input type="text" class="form-control" id="recipient-salt">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Price:</label>
                            <input type="number" class="form-control" id="recipient-price">
                        </div>
                    </form>
                    <div class="alert alert-danger" style="display: none" id="productItemFail">
                        Failed to submit data
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id = "saveProductItem">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-5">
        <button type="button" class="btn btn-primary editMode" data-editMode="false" onclick="changeEditMode()" >Edit</button>
        <button type="button" class="btn btn-primary bulkSubmit" data-editMode="false" onclick="submitBulkChanges()" >Submit bulk changes</button>
        <div style="height: 10px"></div>
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
    <link rel="stylesheet" href="{{ asset('css/view-product.css') }}">
    <script >
        var a = [];
        var editMode = false;
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
                "<tr id = 'r-"+value['id']+"'>"+
                "<td scope='row'>"+value['id']+"</td>"
                +"<td><textarea rows = \"3\" class = 'product-row' type ='text' disabled='true'> "+value['name']+"</textarea></td>"
                +"<td><textarea rows = \"3\" class = 'product-row' type ='text' disabled='true'>"+value['salt']+"</textarea></td>"
                +"<td><textarea rows = \"3\" class = 'product-row' type ='text' disabled='true'>"+value['price']+"</textarea></td>"
                +"<td><a href='"+value['img']+"' target='_blank'>"+value['img']+"</a> </td>"
                +"<td><p onclick=\"log("+value['id']+")\">Edit</p><p>Delete</p></td>"
                +"</tr>";
            $("#tbodyid").append(txt)
        }

        $("#saveProductItem").click(function () {
            $("#saveProductItem").attr('disabled',true);
            var sub = {"id": $("#recipient-id").attr("myData"),
                "name":$("#recipient-name").val(),
                "salt":$("#recipient-salt").val(),
                "price":$("#recipient-price").val(),
            };
            axios({
                method:'post',
                url:"editProductItem",
                data:sub
            }).then((response) => {
                console.log("success");
                console.log(response);
                //$("#saveProductItem").attr('disabled',false);
                updateProductItemData(sub);
                $('#productItemFail').hide()
                $('#exampleModal').modal('hide')
            }, (error) => {
                $("#saveProductItem").attr('disabled',false);
                console.log("error");
                console.log(error);
                $('#productItemFail').show()
            });
            console.log(sub);
        });
        function updateProductItemData(data){
            var d = a[data['id']];
            d['name']=data['name'];
            d['salt']=data['salt'];
            d['price']=data['price'];
            a[data['id']]=d;
            itemData = $( "#r-"+data['id'])
            itemData.children().eq(1).text(data['name'])
            itemData.children().eq(2).text(data['salt'])
            itemData.children().eq(3).text(data['price'])
            console.log(itemData);
        }

        function changeEditMode() {
            console.log("changeEditMode "+$(".editMode").text())
            if($(".editMode").text() == 'Edit'){
                $(".editMode").text("View");
                $(".product-row").attr('disabled',false);
                $(".bulkSubmit").show()
            }else{
                $(".editMode").text("Edit")
                $(".product-row").attr('disabled',true);
                $(".bulkSubmit").hide()
                resetOrSave(true)
            }
        }

        function submitBulkChanges(){
            ret = {"data":resetOrSave(false)};
            axios({
                method:'post',
                url:"bulkProductItem",
                data:ret
            }).then((response) => {
                console.log("success");
                console.log(response);
            }, (error) => {
                console.log("error");
                console.log(error);
            });

            console.log(ret)
        }
        function resetOrSave(isReset){
            var ite = $("#tbodyid").find("tr")
            var ret = [];
            for (i =0 ; i<ite.length;i++){
                var id = ite[i].childNodes[0].innerText;
                var ss = a[id];
                if(isReset){
                    ite[i].childNodes[1].childNodes[0].value = ss['name'];
                    ite[i].childNodes[2].childNodes[0].value = ss['salt'];
                    ite[i].childNodes[3].childNodes[0].value = ss['price'];
                }else{
                    var name = ite[i].childNodes[1].childNodes[0].value;
                    var salt = ite[i].childNodes[2].childNodes[0].value;
                    var price = ite[i].childNodes[3].childNodes[0].value;
                    var v = { "id":id,"name":name,"salt":salt,"price":price }
                    console.log(name);
                    console.log(ss['name']);
                    if(name.trim() == ss['name'].trim()){
                        console.log("name is same")
                    }

                    if( name.trim() == ss['name'].trim() && salt.trim() == ss['salt'].trim() && price.trim() == ss['price'].trim() ){
                        console.log("Skip")
                    }else{
                        ret.push(v)
                    }

                    console.log(id);
                    console.log(name);
                    console.log("salt"+salt);
                    console.log("price "+price);
                }
            }
            return ret;
        }

        function log(aa){
            $('#exampleModal').modal('show')
            v = a[aa];
            console.log(v);
            $('#productItemFail').hide()
            $("#saveProductItem").attr('disabled',false);
            $("#recipient-id").attr("myData", v['id'])//recipient-price
            $("#recipient-name").val(v['name'])//recipient-price
            $("#recipient-salt").val(v['salt'])//recipient-price
            $("#recipient-price").val(v['price'])//recipient-price
            console.log(aa)
        }
    </script>
@endsection


