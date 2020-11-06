<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <title>Document</title>
</head>
<body>
<div class="card-body">
    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="file" class="form-control">
        <br>
        <button class="btn btn-success">Import Bulk Data</button>
        <a class="btn btn-warning" href="{{ route('export') }}">Export Bulk Data</a>
    </form>
</div>
</body>
</html>
