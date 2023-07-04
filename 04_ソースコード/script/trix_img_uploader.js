(function () {
    // フォルダパス
    // var HOST = "./img/detail/";
    // var HOST = "http://localhost/Web/github/2023Dev3Early/04_ソースコード/img/detail/"

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
                    url: HOST + key,
                    // href: HOST + key + "?content-disposition=attachment"
                    // url: key,
                    href: HOST + key
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

// License - Trix editor
// Copyright (c) 2022 37signals, LLC

// Permission is hereby granted, free of charge, to any person obtaining
// a copy of this software and associated documentation files (the
// "Software"), to deal in the Software without restriction, including
// without limitation the rights to use, copy, modify, merge, publish,
// distribute, sublicense, and/or sell copies of the Software, and to
// permit persons to whom the Software is furnished to do so, subject to
// the following conditions:

// The above copyright notice and this permission notice shall be
// included in all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
// MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
// LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
// OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
// WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
