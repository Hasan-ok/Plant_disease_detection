@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-green-50 py-8 px-4">
    <form method="POST" action="{{ route('detection.detect') }}" enctype="multipart/form-data" class="max-w-2xl mx-auto">
        @csrf

        <div class="upload-area text-center border-2 border-dashed border-green-300 p-8 rounded-xl bg-white shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="upload-icon text-5xl mb-4 text-green-500">🌿</div>
            <h3 class="text-2xl font-bold mb-2 text-green-800">Upload Plant Photo</h3>
            <p class="text-gray-500 mb-6">Help us identify plant diseases by uploading a clear photo</p>

            <input
                type="file"
                name="image"
                id="fileInput"
                accept="image/*"
                class="hidden"
                onchange="previewSelectedFile(this)"
            >

            <button type="button"
                    onclick="document.getElementById('fileInput').click();"
                    class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors duration-200 font-medium shadow-md hover:shadow-lg">
                Choose File
            </button>

            <p id="fileName" class="text-sm text-gray-500 mt-3">No file selected</p>
            <div id="previewContainer" class="mt-6 flex justify-center"></div>
        </div>

        <div class=" mt-8 text-center">
            <button type="submit" class="bg-green-800 text-white px-8 py-3 rounded-lg hover:bg-green-900 transition-colors duration-200 font-semibold text-lg shadow-md hover:shadow-lg w-full max-w-xs mx-auto">
                Analyze Image
            </button>
        </div>
    </form>

    <!-- Upload Tips -->
    <div class="upload-tips mt-10 bg-white rounded-xl shadow-sm p-6 max-w-2xl mx-auto">
        <h4 class="text-xl font-semibold mb-4 text-green-800 flex items-center gap-2">
            <span class="bg-green-100 p-2 rounded-full">📋</span>
            Photo Tips for Best Results
        </h4>
        <ul class="space-y-3 text-gray-700">
            <li class="flex items-start gap-2">
                <span class="text-green-500">✓</span>
                <span>Use natural lighting or bright indoor light</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="text-green-500">✓</span>
                <span>Focus on affected leaves or plant parts</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="text-green-500">✓</span>
                <span>Keep the camera steady and close</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="text-green-500">✓</span>
                <span>Avoid blurry or dark images</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="text-green-500">✓</span>
                <span>Include multiple affected areas if possible</span>
            </li>
        </ul>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mt-6 max-w-2xl mx-auto">
            <p>{{ session('error') }}</p>
        </div>
    @endif
</div>

<script>
    function previewSelectedFile(input) {
        const file = input.files[0];
        const fileName = file ? file.name : 'No file selected';
        document.getElementById('fileName').innerText = fileName;

        const previewContainer = document.getElementById('previewContainer');
        previewContainer.innerHTML = '';

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'max-w-full h-auto rounded-lg shadow-md border border-green-200';
                img.style.maxHeight = '300px';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection