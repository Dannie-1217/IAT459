$(document).ready(function () {
    $('input[name="profile_photo"]').on('change', function (e) {
        const preview = $('#profile-preview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.attr('src', e.target.result).show();
            };

            reader.readAsDataURL(file);
        }
    });
});
