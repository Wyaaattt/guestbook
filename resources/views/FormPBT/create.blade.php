@extends('layout.main')
@section('content')
    <div class="card-header">
        <h2>
            Form Pendaftaran Buku Tamu
        </h2>
    </div>
    <div class="card-body">
        <form action="{{ route('FormPBT.store') }}" method="post" enctype="multipart/form-data">
            <div class="row">
                @csrf
                <div class="col-md-8">
                    <label for="nama" class="form-label">Nama Lengkap*</label>
                    <input type="text" class="form-control" name="nama" required>
                    <label for="instansi" class="form-label">Instansi/Perusahaan*</label>
                    <input type="text" class="form-control" name="instansi" required>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="telepon" class="form-label">Nomor Telepon*</label>
                            <input type="text" class="form-control" name="telepon" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email*</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>
                    <label for="alamat" class="form-label">Alamat*</label>
                    <textarea name="alamat" id="" cols="30" rows="3" class="form-control" required></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-center w-100 d-block">Foto</label>
                    <img id="preview-foto" src="" alt="preview foto" class="img-fluid mb-2"
                        style="max-height: 200px;" >
                    <input type="file" class="form-control" name="foto" onchange="previewFoto(event)" required>
                </div>
                <div class="col-md-12 text-end mt-2">
                    <button class="btn btn-secondary">Reset</button>
                    <button class="btn btn-primary">Daftar</button>
                </div>
            </div>
        </form>
    </div>
@endsection

<script>
    //prose preview foto
    function previewFoto(event) {
        const input = event.target;
        const preview = document.getElementById('preview-foto');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
