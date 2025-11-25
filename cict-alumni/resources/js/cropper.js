let cropper;
let currentTarget = null; // "profile" or "banner"
const cropperModal = document.getElementById('cropperModal');
const imageToCrop = document.getElementById('image-to-crop');
const cropperTitle = document.getElementById('cropperTitle');

// Profile
const profileInput = document.getElementById('profile-input');
const profilePreview = document.getElementById('profile-preview');
const selectProfile = document.getElementById('select-profile');
const croppedProfileInput = document.getElementById('cropped-profile');

// Banner
const bannerInput = document.getElementById('banner-input');
const bannerPreview = document.getElementById('banner-preview');
const selectBanner = document.getElementById('select-banner');
const croppedBannerInput = document.getElementById('cropped-banner');

// Buttons
const saveCrop = document.getElementById('saveCrop');
const cancelCrop = document.getElementById('cancelCrop');

// Open file selectors
selectProfile.addEventListener('click', () => {
    currentTarget = "profile";
    profileInput.click();
});
selectBanner.addEventListener('click', () => {
    currentTarget = "banner";
    bannerInput.click();
});

// Handle file input
function handleFile(input, target) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            imageToCrop.src = reader.result;
            cropperModal.classList.remove('hidden');
            cropperTitle.textContent = target === "profile" ? "Adjust Profile Photo" : "Adjust Banner";

            // Destroy old cropper if exists
            if (cropper) cropper.destroy();

            cropper = new Cropper(imageToCrop, {
                aspectRatio: target === "profile" ? 1 : 16 / 9,
                viewMode: 2,
                movable: true,
                zoomable: true,
                rotatable: false,
                scalable: false,
            });
        };
        reader.readAsDataURL(file);
    }
}

profileInput.addEventListener('change', () => handleFile(profileInput, "profile"));
bannerInput.addEventListener('change', () => handleFile(bannerInput, "banner"));

// Cancel crop
cancelCrop.addEventListener('click', () => {
    cropperModal.classList.add('hidden');
    if (cropper) cropper.destroy();
});

// Save cropped image
saveCrop.addEventListener('click', () => {
    if (!cropper || !currentTarget) return;

    const canvas = cropper.getCroppedCanvas(
        currentTarget === "profile"
            ? { width: 300, height: 300 }
            : { width: 1200, height: 675 }
    );

    const dataUrl = canvas.toDataURL("image/png");

    if (currentTarget === "profile") {
        profilePreview.src = dataUrl;
        croppedProfileInput.value = dataUrl;
    } else {
        bannerPreview.src = dataUrl;
        croppedBannerInput.value = dataUrl;
    }

    cropperModal.classList.add('hidden');
    cropper.destroy();
});
