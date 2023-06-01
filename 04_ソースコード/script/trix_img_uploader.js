(function () {
    // フォルダパス
    var HOST = "./"
    // var HOST = "http://localhost/Web/github/2023Dev3Early/04_ソースコード/trix_editor_test/"

    // 画像添付時発火イベント===
    addEventListener("trix-attachment-add", function (event) {
        if (event.attachment.file) {
            uploadFileAttachment(event.attachment);
        }
    });
    // ===

    // 添付画像削除時発火イベント===
    addEventListener("trix-attachment-remove", function (event) {
        console.log(event.attachment.file);
    });
    // ===


    function uploadFileAttachment(attachment) {
        uploadFile(attachment.file, setProgress, setAttributes)

        function setProgress(progress) {
            attachment.setUploadProgress(progress)
        }

        function setAttributes(attributes) {
            attachment.setAttributes(attributes)
            console.log(attributes);
        }
    }

    function uploadFile(file, progressCallback, successCallback) {
        var key = createStorageKey(file)
        var formData = createFormData(key, file)
        var xhr = new XMLHttpRequest()

        xhr.open("POST", "./php/trix_img_uploader.php", true)

        xhr.upload.addEventListener("progress", function (event) {
            var progress = event.loaded / event.total * 100
            progressCallback(progress)
        })

        xhr.addEventListener("load", function (event) {
            if (xhr.status == 200) {
                var attributes = {
                    // url: HOST + key,
                    // href: HOST + key + "?content-disposition=attachment"
                    url: key,
                    href: key
                }
                successCallback(attributes)
            } else {
                console.log("something happen", xhr.status);
            }
        })

        console.log([...formData.entries()]);
        xhr.send(formData)
    }

    function createStorageKey(file) {
        var date = new Date();
        var day = date.toISOString().slice(0, 10);
        var name = date.getTime() + "-" + file.name;
        // return ["tmp", day, name].join("/");
        return name;
    }

    function createFormData(key, file) {
        var data = new FormData();
        data.append("key", key);
        data.append("Content-Type", file.type);
        data.append("file", file, key);
        return data;
    }
})();
