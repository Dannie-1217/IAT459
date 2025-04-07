$(document).ready(function() {
    $("input[name='images[]']").on("change", function() {
        let previewContainer = $("#image_preview");

        // If not created yet, create it
        if (previewContainer.length === 0) {
            $(this).after("<div id='image_preview' style='margin-top: 10px; display: flex; flex-wrap: wrap; gap: 10px;'></div>");
            previewContainer = $("#image_preview");
        } else {
            previewContainer.html(""); // Clear previous previews
        }

        const files = this.files;
        if (files.length > 0) {
            $.each(files, function(i, file) {
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = $("<img>").attr("src", e.target.result).css({
                            width: "100px",
                            height: "100px",
                            objectFit: "cover",
                            borderRadius: "8px",
                            border: "1px solid #ccc"
                        });
                        previewContainer.append(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.append(`<p>${file.name} (Not an image)</p>`);
                }
            });
        }
    });
});