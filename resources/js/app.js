import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


function handleFileUpload(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Hide placeholder and show loading
        document.getElementById('placeholder').style.display = 'none';
        document.getElementById('results').style.display = 'none';
        document.getElementById('loading').style.display = 'block';

        // Update upload area to show selected file
        const uploadArea = document.querySelector('.upload-area');
        const fileName = file.name;
        uploadArea.innerHTML = `
                    <div class="upload-icon">✅</div>
                    <h3>Image Uploaded</h3>
                    <p><strong>${fileName}</strong></p>
                    <p>Analyzing with AI technology...</p>
                `;

        // Simulate AI processing time
        setTimeout(() => {
            // Hide loading and show results
            document.getElementById('loading').style.display = 'none';
            document.getElementById('results').style.display = 'flex';

            // Reset upload area
            setTimeout(() => {
                uploadArea.innerHTML = `
                            <div class="upload-icon">📸</div>
                            <h3>Upload Another Photo</h3>
                            <p>Drag & drop or click to select an image</p>
                            <button class="upload-btn">Choose File</button>
                        `;
                uploadArea.onclick = () => document.getElementById('fileInput').click();
            }, 1000);

            // Animate severity bar
            setTimeout(() => {
                const severityFill = document.querySelector('.severity-fill');
                severityFill.style.width = '65%';
            }, 500);

        }, 3500);
    }
}

function bookExpert() {
    alert('Redirecting to expert consultation booking...');
    // In a real app, this would navigate to booking page
}

function saveResult() {
    alert('Result saved to your plant health dashboard!');
    // In a real app, this would save to user's account
}

// Drag and drop functionality
const uploadArea = document.querySelector('.upload-area');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    uploadArea.style.borderColor = '#22c55e';
    uploadArea.style.background = 'rgba(34, 197, 94, 0.15)';
}

function unhighlight(e) {
    uploadArea.style.borderColor = 'rgba(34, 197, 94, 0.5)';
    uploadArea.style.background = 'rgba(34, 197, 94, 0.05)';
}

uploadArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;

    if (files.length > 0) {
        document.getElementById('fileInput').files = files;
        handleFileUpload(document.getElementById('fileInput'));
    }
}
