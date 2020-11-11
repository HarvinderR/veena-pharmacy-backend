@extends('include.master')

@section('title')
    Upload Products
@endsection

@section('content')
    <div >
        @if ($message = session()->get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container-fluid" id="cont">
            <form action="{{ route('uploadProductsPost') }}" method="POST" enctype="multipart/form-data" id ="fmsubmit">
                <div id="responseMessage">
                    <h3></h3>
                </div>
                @csrf
                <div class="row" style="justify-content: center;padding-bottom: 10px"><h2>UPLOAD FILE</h2></div>
                <div class="row" style="padding-bottom: 10px">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <div class="row" style="justify-content: flex-end;margin-top: 10px">
                    <button type="submit" id="btnSbmt" class="btn btn-primary">UPLOAD</button>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('script')
    <style>
        #cont{
            border-radius: 5px;
            border: 1px solid #c8c6c4;
            background-color: #e2e8f0;
            padding: 10px 30px;
            width: 400px;
            margin-top: 50px;
        }
    </style>
    <script>

        $(document).ready(function(){
            $('#fmsubmit').off().on('submit',function (event) {
                // Disabled with:
                $('input[type="submit"], input[type="button"], button').prop('disabled',true);

                event.preventDefault();
                var formData = new FormData();
                var imagefile = document.getElementById('customFile');
                formData.append("file", imagefile.files[0]);
                $('#responseMessage h3').html =""
                $('#success').hide();
                axios.post('uploadProductsPost', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function (response) {
                    console.log("done "+response)
                    console.log(response)
                    // Enabled with:
                    $('input[type="submit"], input[type="button"], button').prop('disabled',false);
                    $('#success').show();
                    $('#responseMessage h3').html ="File upload successfully"
                    var imagefile = document.getElementById('customFile');
                    imagefile.val = null;
                }).catch(function () {
                    console.log("fail")
                    // Enabled with:
                    $('input[type="submit"], input[type="button"], button').prop('disabled',false);
                    $('#success').show();
                    $('#responseMessage h3').html ="File upload successfully"
                    var imagefile = document.getElementById('customFile');
                    imagefile.val = null;
                })
            })
        });

        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
