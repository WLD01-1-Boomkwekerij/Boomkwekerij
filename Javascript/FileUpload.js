
function fileUploadFormData(formData, uploadUrl)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../Php/FileUpload.php");
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (xmlhttp.responseText !== "")
            {
                createPopupError(xmlhttp.responseText);
            }
        }
    };
    formData.append("UploadUrl", uploadUrl.value);

    popupAddProgressBar(xmlhttp);

    xmlhttp.send(formData);
}

function formDataAppendIndex(fileInput, fileUrl)
{
    var fileLength = fileInput.length;
    var fileModulo = fileLength % 20;
    var uploadAmount = (fileLength - fileModulo) / 20;
    var formData = new FormData();

    for (var i = 0; i < uploadAmount; i++)
    {
        i *= 10;

        for (var x = 0; x < 20; x++)
        {
            formData.append("fileToUpload[]", fileInput.files[i + x]);
        }

        fileUploadFormData(formData, fileUrl);
    }
}

function formDataAppendModulo(fileInput, fileUrl, popupFileProgres)
{
    var fileLength = fileInput.length;
    var fileModulo = fileLength % 20;
    var uploadAmount = (fileLength - fileModulo) / 20;
    var formData = new FormData();

    for (var j = (uploadAmount * 20); j < (uploadAmount * 20) + fileModulo; j++)
    {
        formData.append("fileToUpload[]", fileInput[j]);
    }

    fileUploadFormData(formData, fileUrl);
}

function formAppend(fileInput, fileUrl)
{
    var fileLength = fileInput.length;
    var formData = new FormData();

    for (var j = 0; j < fileLength; j++)
    {
        formData.append("fileToUpload[]", fileInput[j]);
    }

    fileUploadFormData(formData, fileUrl);
}

function sendFileBatch(fileArray, fileUrl, popupFileProgres)
{

    if (fileArray.length > 20)
    {
        formDataAppendIndex(fileArray, fileUrl, popupFileProgres);
        formDataAppendModulo(fileArray, fileUrl, popupFileProgres);
    }
    else
    {
        formAppend(fileArray, fileUrl, popupFileProgres);
    }
}

/**
 * Validates the files and sends them
 * @param {element} fileInput
 * @param {element} fileUrl
 */
function validateFiles(fileInput, fileUrl)
{
    var fileArray = fileInput.files;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../Php/FileUpload.php?getMaxFileAllowed=yes");
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            createPopupFilesProgress();
            
            var maxSize = xmlhttp.responseText.split("*");

            var maxFileSize = parseInt(maxSize[0]);
            var maxFileAmount = parseInt(maxSize[1]);

            var currentBatchSize = 0;
            var currentBatchFiles = [];

            var fileToBigArray = [];

            fileToBigArray[0] = maxFileSize;

            for (var i = 0; i < fileArray.length; i++)
            {
                if (fileArray[i].size > maxFileSize)
                {
                    fileToBigArray[fileToBigArray.length] = fileArray[i].name + " <span>|</span> ~" + ((fileArray[i].size / 1024) / 1024).toFixed(2) + " mb";
                }
                else
                {
                    if (currentBatchFiles.length < maxFileAmount)
                    {
                        if (currentBatchSize + fileArray[i].size < maxFileSize)
                        {
                            currentBatchSize += fileArray[i].size;
                            currentBatchFiles[currentBatchFiles.length] = fileArray[i];
                        }
                        else
                        {
                            //send the current batch to upload
                            sendFileBatch(currentBatchFiles, fileUrl);
                            currentBatchSize = fileArray[i].size;
                            currentBatchFiles = [];
                            currentBatchFiles[currentBatchFiles.length] = fileArray[i];
                        }
                    }
                    else
                    {
                        sendFileBatch(currentBatchFiles, fileUrl);
                        currentBatchSize = fileArray[i].size;
                        currentBatchFiles = [];
                        currentBatchFiles[currentBatchFiles.length] = fileArray[i];
                    }

                }
            }
            
            if(fileToBigArray.length > 1)
            {
                createPopupFilesWarning(fileToBigArray);
            }

            if (currentBatchFiles.length > 0)
            {
                sendFileBatch(currentBatchFiles, fileUrl);
            }

            destroyManager();
        }
    };
    xmlhttp.send();
}