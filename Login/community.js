document.addEventListener('DOMContentLoaded', () => {
    const postForm = document.getElementById('postForm');

    postForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const image = document.getElementById('image').files[0];
        const caption = document.getElementById('caption').value;
        const formData = new FormData();
        formData.append('image', image);
        formData.append('caption', caption);

        const response = await fetch('/api/posts', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: formData
        });

        if (response.ok) {
            alert('Post created successfully!');
            // Load posts
        } else {
            alert('Error creating post.');
        }
    });
});
