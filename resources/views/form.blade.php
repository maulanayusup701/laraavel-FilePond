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
            @foreach ($questions as $question)
                @if($question->question_type == 'text')
                    <input type="text" name="j{{ $question->id }}" id="j{{ $question->id }}" placeholder="{{ $question->question }}">
                @elseif($question->question_type == 'number')
                    <input type="number" name="j{{ $question->id }}" id="j{{ $question->id }}" placeholder="{{ $question->question }}">
                @elseif($question->question_type == 'file')
                    <input type="file" name="j{{ $question->id }}" id="j{{ $question->id }}" multiple data-max-files="5">
                @endif
            @endforeach
            <input type="submit" value="Upload">
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

            let formData = new FormData(this); // This will automatically append all form fields

            // Tambahkan setiap file dari FilePond ke FormData
            pond.getFiles().forEach(file => {
                formData.append('j{{ $question->id }}[]', file.file);
            });

            // Kirim data menggunakan AJAX
            $.ajax({
                url: '{{ route("user.post") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('Data berhasil diupload!'); // Provide success feedback
                    // Optionally, you can clear the form and reset FilePond here
                    $('#uploadForm')[0].reset();
                    pond.removeFiles(); // Reset FilePond
                },
                error: function(xhr) {
                    alert('Gagal mengupload data!'); // Provide error feedback
                    console.error(xhr.responseText); // Log the error response for debugging
                }
            });
        });
    </script>
</body>
</html>
