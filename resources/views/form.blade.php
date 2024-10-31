<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Upload</title>
    <!-- Tambahkan CSS FilePond -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div>
        <form id="uploadForm">
            @csrf
            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" required>

            <label for="nim">NIM:</label>
            <input type="text" name="nim" id="nim" required>

            <label for="foto">Foto:</label>
            <input type="file" name="foto[]" id="foto" multiple data-max-files="5">

            <button type="submit" id="submitBtn">Submit</button>
        </form>
    </div>

    <!-- Tambahkan Script FilePond -->
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/jquery/dist/jquery.min.js"></script>


    <script>
        // Inisialisasi FilePond
        const pond = FilePond.create(document.querySelector('input[type="file"]'), {
            allowMultiple: true,
            maxFiles: 5,
            instantUpload: false
        });

        $('#uploadForm').on('submit', function(e) {
            e.preventDefault();

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            let formData = new FormData();
            formData.append('nama', $('#nama').val());
            formData.append('nim', $('#nim').val());

            // Tambahkan setiap file dari FilePond ke FormData
            pond.getFiles().forEach(file => {
                formData.append('foto[]', file.file);
            });

            // Kirim data menggunakan AJAX
            $.ajax({
                url: '{{ route("user.post") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('Data berhasil diupload!');
                },
                error: function(xhr) {
                    alert('Gagal mengupload data!');
                }
            });
        });
    </script>
</body>
</html>
