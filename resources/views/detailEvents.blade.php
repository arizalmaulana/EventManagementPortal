@extends('template')
@section('content') 
    <figure>
        <div class="container" id="detail-event">
            <form action="{{ route('event.delete', $event->id)}}" method="POST">    
                @csrf
                @method('DELETE')
                <div class="mt-5">
                    <h1>{{ $event->title}}</h1>
                </div>
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center">
                        <img src="{{ asset('uploads/'.$event->poster)}}" alt="imagePreview" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <h4>Detail Event</h4>
                        <div class="d-flex">
                            <div class="col-md-4">
                                <p>Tanggal Mulai</p>
                                <p>Tanggal Berakhir</p>
                                <p>Pembicara</p>
                            </div>
                            <div class="col-md-6">
                                <p>: {{ date('d F Y', strtotime($event->start))}}</p>
                                <p>: {{ date('d F Y', strtotime($event->end))}}</p>
                                <p>: {{ $event->pembicara }}</p>
                            </div>
                        </div>
                        <h4 class="m-0 mt-3">Deskripsi</h4>
                        <p class="mt-1">{{ $event->description }}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary mx-2" id="edit-button" type="button">Edit</button>
                    <button class="btn btn-danger" type="button" id="delete-button">Delete</button>
                    <button class="btn btn-danger" type="submit" id="delete-button-submit">Delete</button>

                </div>
            </form>
        </div>

        {{-- Setelah tombol edit klik sembunyikan kode atas tampilkan kode bawah --}}

        <div class="container" id="detail-event-update">
            <form action="{{ route('events.update', $event->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class=" mt-5" id="page-desc">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Event Name" name="title" value="{{$event->title}}">
                        <label for="floatingInput">Event Name</label>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <!-- Input untuk memilih gambar -->
                        <img id="previewImage" src="{{ asset('uploads/'.$event->poster)}}" alt="hero" style="width: 100%; object-fit:cover" >
                        <div class="form-group mt-2">
                            <label for="imageInput">Pilih Gambar</label>
                            <input type="file" class="form-control-file" id="imageInput" name="poster" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4>Detail Event</h4>
                        <div class="d-flex flex-column">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="floatingInput" placeholder="Tanggal Mulai" style="width: 100%" name="start" value="{{ \Carbon\Carbon::parse($event->start)->format('Y-m-d')}}"/>
                                <label for="floatingInput">Tanggal Mulai</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="floatingInput" placeholder="Tanggal Berakhir" name="end"  value="{{ \Carbon\Carbon::parse($event->end)->format('Y-m-d')}}">
                                <label for="floatingInput">Tanggal Berakhir</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Pembicara" name="pembicara" value="{{$event->pembicara}}">
                                <label for="floatingInput">Pembicara</label>
                            </div>  
                        </div>
                        <h4 class="m-0 mt-3">Deskripsi</h4>
                        <div class="form-floating mt-3">
                            <textarea class="form-control" placeholder="Deskripsi Event" id="floatingTextarea2" style="height: 10rem" name="description">{{$event->description}}</textarea>
                            <label for="floatingTextarea2">Deskripsi Event</label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mt-3" id='button-update'>Update</button>
                    <button type="button" class="btn btn-secondary mt-3 mx-2" id="button-cancel">Cancel</button>
                </div>
            </form>
        </div>

    </figure>

    <script>
        const detailEvent = document.getElementById('detail-event');
        const detailEventUpdate = document.getElementById('detail-event-update');
        const buttonEdit = document.getElementById('edit-button');
        const buttonUpdate = document.getElementById('button-update');
        const buttonCancel = document.getElementById('button-cancel');
        const imageInput = document.getElementById('imageInput');

        detailEventUpdate.style.display = 'none';
        buttonEdit.addEventListener('click', function(){
            detailEvent.style.display = 'none';
            detailEventUpdate.style.display = 'block';
        })

        buttonCancel.addEventListener('click', function(){
            detailEvent.style.display = 'block';
            detailEventUpdate.style.display = 'none';
        })

        imageInput.addEventListener('change', function(event) {
            const preview = document.getElementById('previewImage');
            preview.src = URL.createObjectURL(event.target.files[0]);
        });

        const success = @json(session()->get('success'));

        if(success){
            Toastify({
                text: success,
                duration: 3000,
                gravity: 'top',
                position: 'right',
                backgroundColor: 'green',
                stopOnFocus: true,
            }).showToast();
        }

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Toastify({
                    text: "{{ $error }}",
                    duration: 3000,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: 'red',
                    stopOnFocus: true,
                }).showToast();
            @endforeach
        @endif
        
        const deleteButton = document.getElementById('delete-button');
        const deleteButtonSubmit = document.getElementById('delete-button-submit');

        deleteButtonSubmit.style.display = 'none';
        deleteButton.addEventListener('click', function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Event yang dihapus tidak dapat dikembalikan!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Delete Event'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteButtonSubmit.click();
                }
            })
        })
        
    </script>
@endsection