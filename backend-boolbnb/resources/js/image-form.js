const imageInput = document.getElementById('image');
const imagePreview = document.getElementById('image-preview');
const changeImage = document.getElementById('change-image');
const removeImage = document.getElementById('remove-image');
const deleteImage = document.getElementById('delete_image');

// variable declaration
const placeholder = 'https://media.istockphoto.com/id/1147544807/vector/thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=rnCKVbdxqkjlcs3xH87-9gocETqpspHFXu5dIGB4wuM=';
let blobUrl = null;

// ______________Arrow functions
// Image preview
const add_image_preview = () => {
    if(imageInput.files[0]){
        // Get file
        const file=imageInput.files[0];
        // Created blob url
        blobUrl=URL.createObjectURL(file);
        // Add blob url to the preview
        imagePreview.src = blobUrl;
        // Add buitton to remove img
        removeImage.classList.remove('d-none');
    }else{
        // Remove placeholder
        imagePreview.src = placeholder;
        // Remove button for remove img
        removeImage.classList.add('d-none');
    }

    console.log(imageInput.value);
};

// Change image
const change_image = () => {
    // Toggle input
    changeImage.classList.add('d-none');
    imageInput.classList.remove('d-none');
    // Remove image preview
    imagePreview.src = placeholder;
    // Click image input
    imageInput.click();
    // Remove button to remove img
    removeImage.classList.add('d-none');

    console.log(imageInput.value);
};

// Remove image
const remove_image = () => {
    // Toggle input
    changeImage.classList.add('d-none');
    imageInput.classList.remove('d-none');
    imageInput.value = '';
    // Remove image preview
    imagePreview.src = placeholder;
    // Remove button
    removeImage.classList.add('d-none');
    // Delete image
    deleteImage.checked = true;
}

// ______________Event listener
// Add image preview
imageInput.addEventListener('change', add_image_preview);

// Change image
changeImage.addEventListener('click', change_image);

// Remove image
removeImage.addEventListener('click', remove_image);


// Delete blob url
window.addEventListener('beforeunload', ()=>{
    if(blobUrl) URL.revokeObjectURL(blobUrl);
})