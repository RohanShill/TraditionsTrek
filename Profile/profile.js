// You can add JavaScript to handle file uploads, update user profile details, etc.
document.getElementById('upload-photo').addEventListener('click', () => {
    const fileInput = document.getElementById('photo-input');
    const files = fileInput.files;
    if (files.length > 0) {
        const file = files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const photoGallery = document.getElementById('photos');
            const img = document.createElement('img');
            img.src = e.target.result;
            photoGallery.appendChild(img);
        }
        reader.readAsDataURL(file);
    }
});
