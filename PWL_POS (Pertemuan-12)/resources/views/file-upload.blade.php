<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>File Upload</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div class="container mt-3">
    <h2>File Upload</h2>
    <hr>

    <form action="{{url('/file-upload')}}" method="post" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="berkas" class="form-label">Nama Gambar</label>
        <input type="text" name="nama_gambar" class="form-control" id="nama_gambar">
        @error('nama_gambar')
        <div class="text-danger">{{$message}}</div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="berkas" class="form-label">Gambar Profile</label>
        <input type="file" name="berkas" class="form-control" id="berkas">
        @error('berkas')
        <div class="text-danger">{{$message}}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary my-2">Upload</button>
    </form>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>