const config = {
    notificationTimer: 3000,
    tiny_mce: {
        api_key: "cw2b5h08m56tofzikcrxps9lufci53ls315hmwvf1eje98bu",
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality ' +
            'code visualblocks visualchars fullscreen image link media template codesample table ' +
            'charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount ' +
            'textpattern noneditable help charmap emoticons image imagetools',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect ' +
            'formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  ' +
            'numlist bullist | image editimage |  forecolor backcolor removeformat | pagebreak | ' +
            'charmap emoticons | fullscreen  preview save print | insertfile media ' +
            'template link anchor codesample | ltr rtl',
        images_upload_url: '/api/upload_image',
        automatic_uploads: true,
        file_picker_types: 'image',
        file_picker_callback: function (callback, value, meta) {
            if (meta.filetype === 'image') {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function () {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        callback(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            }
        },
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/api/upload_image');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.onload = function () {
                var json;
                if (xhr.status !== 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);
                if (!json || typeof json.location !== 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        },
        setup: function (editor) {
            editor.ui.registry.addButton('editimage', {
                text: 'Edit Image',
                onAction: function () {
                    const selectedNode = editor.selection.getNode();
                    if (selectedNode && selectedNode.nodeName === 'IMG') {
                        const imageUrl = selectedNode.src;
                        // Call the function to edit the image
                        editImage(imageUrl, function (newImageUrl) {
                            editor.dom.setAttrib(selectedNode, 'src', newImageUrl);
                        });
                    } else {
                        alert('Please select an image to edit.');
                    }
                }
            });
        }
    },
    languages: ['vi', 'en'],
    langOptions: {
        'vi': "Tiếng Việt",
        'en': "Tiếng Anh"
    },
    sub_pages: ['about', 'products', 'news', 'terms-and-cond']
};

export default config;
