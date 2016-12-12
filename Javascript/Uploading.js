
var isUploaderOpen;

window.onload = function ()
{
    isUploaderOpen = false;
};

function createElement(element)
{
    return document.createElement(element);
}

function getElementById(id)
{
    return document.getElementById(id);
}

function insertUploader(element)
{
    if (!isUploaderOpen)
    {
        isUploaderOpen = true;

        var uploaderDiv = createElement("div");
        uploaderDiv.style.width = "200px";
        uploaderDiv.style.height = "50px";
        uploaderDiv.style.border = "solid 2px black";
        uploaderDiv.style.backgroundColor = "white";
        element.appendChild(uploaderDiv);

        var uploadForm = createElement("form");
        uploadForm.action = "../Upload.php";
        uploadForm.method = "post";
        uploadForm.enctype = "multipart/form-data";
        uploaderDiv.appendChild(uploadForm);

        var fileInput = createElement("input");
        fileInput.type = "file";
        fileInput.name = "Bestand";
        uploadForm.appendChild(fileInput);

        var fileSend = createElement("input");
        fileSend.type = "submit";
        fileSend.name = "submitUploadFile";
        uploadForm.appendChild(fileSend);
    }
}

function destroyUploader()
{
    if (isUploaderOpen)
    {
        isUploaderOpen = false;
    }
}