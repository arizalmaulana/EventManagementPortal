@extends('template')
@section('content')
    <div>
        <div class="container">
            <div class="mt-5">
                <h1>Add Event</h1>
                <p>Disini kita bisa menambahkan event</p>
            </div>
            <form method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-center">
                        <img id="imagePreview" src="https://via.placeholder.com/400" class="img-fluid" alt="Dummy Image">
                    </div>
                    <div class="form-group mt-2">
                        <label for="poster">Pilih Gambar</label>
                        <input type="file" class="form-control-file" id="poster" name="poster" />
                        @if ($errors->has('poster'))
                            <span class="text-danger">{{ $errors->first('poster') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="title" placeholder="" name="title">
                        <label for="title">Nama Event</label>
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="form-floating mb-3 col-md-6">
                            <input type="date" class="form-control" id="start" placeholder="" name="start">
                            <label for="start">Tanggal Mulai</label>
                            @if ($errors->has('start'))
                            <span class="text-danger">{{ $errors->first('start') }}</span>
                        @endif
                        </div>
                        <div class="form-floating mb-3 col-md-6">
                            <input type="date" class="form-control" id="end" placeholder="" name="end">
                            <label for="end">Tanggal Berakhir</label>
                            @if ($errors->has('end'))
                            <span class="text-danger">{{ $errors->first('end') }}</span>
                        @endif
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="pembicara" placeholder="" name="pembicara">
                        <label for="pembicara">Pembicara</label>
                        @if ($errors->has('pembicara'))
                            <span class="text-danger">{{ $errors->first('pembicara') }}</span>
                        @endif
                    </div>
                    <div class="form-floating mb-3">
                        <textarea type="text" class="form-control" id="description" placeholder="" style="height: 15rem" name="description"></textarea>
                        <label for="description">Deskripsi</label>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" type="submit"> Tambah Event</button>
            </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('poster').addEventListener('change', function(event){
            const previewImage = document.getElementById('imagePreview');
            previewImage.src = URL.createObjectURL(event.target.files[0])
        })
    </script>
@endsection