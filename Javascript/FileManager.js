
/* global managerImageList, getElementById */

//The history of all items clicked, left arrow will use it to go back
var PathHistory = [];
//The first history is always the main folder
PathHistory[0] = "../Images/Afbeeldingen";
//The currentPathIndex, used to determine where in the PathHistory you are
var currentPathIndex = 0;
//The url of the current selected path
var currentSelectedPath = "";
//The current selected Element
var currentSelectedElement;
//The current selected Image, in the sidebar
var currentSelectedSidebarImage;
//Is uploading, should de manager upload or not
var isUploading = false;
//The fileSend element where the name of the image goes as value
var fileSend;

//Catalog
//If you added a plant
var plantAdded = false;
var images = [];

/**
 * Sends an XML http request for image php commands
 * @param {string} GetArray
 */
function doXMLHttpImages(GetArray)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../Php/DatabaseImages.php?" + GetArray, true);
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (xmlhttp.responseText !== "")
            {
                createPopupError(xmlhttp.responseText);
            }
            else
            {
                openFolder(PathHistory[currentPathIndex]);
            }
        }
    };
    xmlhttp.send();
}

/**
 * Cancel default event on items that are allowed to be dropped on
 * @param {event} ev
 */
function allowDrop(ev)
{
    ev.preventDefault();
}

/**
 * Sets the Icon data of the current dragged item
 * @param {event} ev
 */
function drag(ev)
{
    ev.dataTransfer.setData("Icon", ev.target.id);
}

/**
 * Updates the image url in the database
 * @param {event} ev
 */
function drop(ev)
{
    ev.preventDefault();
    var data = ev.dataTransfer.getData("Icon");

    if (ev.target.id === "sideMenu" || $(ev.target).hasClass("imageImg"))
    {
        addImageToList(PathHistory[currentPathIndex] + "/" + ev.dataTransfer.getData("Icon"));
    }
    else if ($(ev.target).hasClass("specialHomeFolder"))
    {
        var specialFolderData = ev.dataTransfer.getData("specialHomeFolderUrl");

        doXMLHttpImages("updateImageByName=" + data +
                "&oldImageUrl=" + PathHistory[currentPathIndex] +
                "&newImageUrl=" + PathHistory[currentPathIndex - 1] + "/" + specialFolderData);
    }
    else
    {
        doXMLHttpImages("updateImageByName=" + data +
                "&oldImageUrl=" + PathHistory[currentPathIndex] +
                "&newImageUrl=" + PathHistory[currentPathIndex] + "/" + ev.target.id);
    }
}

/**
 * Loads all the images from the database and sets their .src
 */
function loadImagesFromDatabase()
{
    $(".imageDatabaseLoading").each(function ()
    {                                                                                                                     
        var imageId = $(this).attr("id");

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "../Php/DatabaseImages.php?getImageByID=" + imageId, true);
        xmlhttp.onreadystatechange = function ()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                getElementById(imageId).src = xmlhttp.responseText;
            }
        };
        xmlhttp.send();
    });
}

/**
 * Selects a clicked item and deselects the previous
 * @param {element} element
 * @param {string} url 
 * @param {string} name 
 */
function setItemSelected(element, url, name)
{
    if (currentSelectedElement)
    {
        var selectedItem = $(currentSelectedElement).children()[0];

        if ($(selectedItem).hasClass("selectedItem"))
        {
            $(selectedItem).removeClass("selectedItem");
        }
    }

    currentSelectedElement = element;
    var selectedItem = $(currentSelectedElement).children()[0];
    $(selectedItem).addClass("selectedItem");
    currentSelectedPath = url + "/" + name;
}

/**
 *Checks the arrow color, if there is an history / future, change the color
 */
function checkArrowColor()
{
    var rightArrow = getElementById("RightArrow");
    var leftArrow = getElementById("LeftArrow");

    if (currentPathIndex + 1 < PathHistory.length)
    {
        $(rightArrow).removeClass("ArrowHistory");
        $(rightArrow).addClass("ArrowHasHistory");
    }
    else
    {
        $(rightArrow).removeClass("ArrowHasHistory");
        $(rightArrow).addClass("ArrowHistory");
    }

    if (currentPathIndex > 0)
    {
        $(leftArrow).removeClass("ArrowHistory");
        $(leftArrow).addClass("ArrowHasHistory");
    }
    else
    {
        $(leftArrow).removeClass("ArrowHasHistory");
        $(leftArrow).addClass("ArrowHistory");
    }
}

/**
 * Go back in history
 */
function goBackInPath()
{
    if (currentPathIndex > 0)
    {
        currentPathIndex--;
        openFolder(PathHistory[currentPathIndex]);
        checkArrowColor();
    }
}

/**
 * Go to the future
 */
function goForwardInPath()
{
    if (currentPathIndex < PathHistory.length - 1)
    {
        currentPathIndex++;
        openFolder(PathHistory[currentPathIndex]);
        checkArrowColor();
    }
}

/**
 * Creates a folder icon and makes it clickable
 * @param {string} url The url of the folder
 * @param {string} name The name of the folder
 * @param {bool} isReturn If the folder is a return folder, make it a bit special
 */
function createFolderIcon(url, name, isReturn)
{
    var fileManager = getElementById("Files");

    //Create a folder Div
    var folder = createElement("div");
    folder.id = name;

    if (isReturn)
    {
        $(folder).addClass("specialHomeFolder");
    }

    $(folder).addClass("fileManagerFolder");
    folder.ondrop = function ()
    {
        drop(event);
    };
    folder.ondragover = function ()
    {
        allowDrop(event);
    };
    folder.draggable = true;
    folder.ondragstart = function ()
    {
        drag(event);
    };
    folder.addEventListener("dblclick", function ()
    {
        if (isReturn)
        {
            goBackInPath();
        }
        else
        {
            //--Change to always current--        
            PathHistory[PathHistory.length] = url + "/" + name;

            currentPathIndex++;
            //Arrow color (Maybe change to classes)
            checkArrowColor();

            if (isUploading)
            {
                getElementById("uploadFilePathURL").value = PathHistory[PathHistory.length - 1];
            }
            //On Double click: Open the folder
            openFolder(url + "/" + name);
        }

    });
    fileManager.appendChild(folder);

    //Adds the icon for the folder
    var folderIcon = createElement("img");
    folderIcon.src = "../Images/SiteImages/folder.png";
    folder.appendChild(folderIcon);

    //Adds the name for the folder
    var folderName = createElement("p");
    if (isReturn)
    {
        folderName.innerHTML = "...";
    }
    else
    {
        folderName.innerHTML = name;
    }

    folder.appendChild(folderName);
}

/**
 * Creates a file icon and makes it selectable / unselectable
 * @param {string} url
 * @param {string} name
 */
function createFileIcon(url, name)
{
    var fileManager = getElementById("Files");
    var file = createElement("div");
    file.id = name;
    $(file).addClass("fileManagerFile");
    file.draggable = true;
    file.ondragstart = function (event)
    {
        drag(event);
    };
    fileManager.appendChild(file);
    $(file).attr('title', name);

    var filebackground = createElement("div");
    $(filebackground).addClass("fileBackground");
    file.appendChild(filebackground);

    var fileIcon = createElement("img");
    fileIcon.src = url + "/" + name;
    file.appendChild(fileIcon);


    var fileName = createElement("p");

    var giveName = name;

    var maxLength = 16;
    if (name.length > maxLength)
    {
        name = name.substr(0, maxLength) + '...';
        fileName.innerHTML = name;
    }
    else
    {
        fileName.innerHTML = name;
    }
    file.appendChild(fileName);

    if (!isUploading)
    {
        file.addEventListener("click", function ()
        {
            setItemSelected(this, url, giveName);
        });
    }
}

/**
 * Creates all the icons
 * @param {string} directory
 */
function createFileIcons(directory)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../Php/XMLRequest.php?fileDirectory=" + directory, true);
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            var files = xmlhttp.responseText;

            var fileArray = files.split("*");

            if (directory !== PathHistory[0])
            {
                var fileName = PathHistory[PathHistory.length - 2].split("/");
                createFolderIcon(PathHistory[PathHistory.length - 2], fileName[fileName.length - 1], true);
            }

            for (var i = 0; i < fileArray.length - 1; i++)
            {
                if (fileArray[i].includes("."))
                {
                    createFileIcon(directory, fileArray[i]);
                }
                else
                {
                    createFolderIcon(directory, fileArray[i]);
                }
            }
        }
    };
    xmlhttp.send();
}

/**
 * Destroys the manager
 */
function destroyManager()
{
    isFileManagerOpen = false;
    document.body.style.overflow = "scroll";
    getElementById("BackgroundColor").parentNode.removeChild(getElementById("BackgroundColor"));
    getElementById("FileManager").parentNode.removeChild(getElementById("FileManager"));

    if (getElementById("PushButton"))
    {
        getElementById("PushButton").parentNode.removeChild(getElementById("PushButton"));
        getElementById("sideMenu").parentNode.removeChild(getElementById("sideMenu"));
    }

    managerImageList = [];
    PathHistory = [];
    currentPathIndex = 0;
    PathHistory[0] = "../Images/Afbeeldingen";
    isUploading = false;
}

/**
 * Opens a folder and creates all the icons
 * @param {string} directory
 */
function openFolder(directory)
{
    //Goes through all the current displayed files and deletes them.
    while (getElementById("Files").firstChild)
    {
        getElementById("Files").removeChild(getElementById("Files").firstChild);
    }
    //Create the icons from the new directory
    createFileIcons(directory);
}

function updateImageList()
{
    //The sidebar menu
    var sidebar = getElementById("sideMenu");

    //First delete every item
    while (sidebar.firstChild)
    {
        sidebar.removeChild(sidebar.firstChild);
    }

    for (var j = 0; j < managerImageList.length; j++)
    {
        (function (j)
        {
            var imageDiv = createElement("div");
            $(imageDiv).addClass("imageDiv");
            sidebar.appendChild(imageDiv);

            var imageImg = createElement("img");
            imageImg.src = managerImageList[j];
            $(imageImg).addClass("imageImg");
            imageDiv.appendChild(imageImg);

            var imageDeleteButton = createElement("div");
            $(imageDeleteButton).addClass("imageDeleteButton");
            $(imageDeleteButton).addClass("fa fa-trash fa-2x");
            imageDeleteButton.onclick = function ()
            {
                removeImageFromList(managerImageList[j]);
            };
            imageDiv.appendChild(imageDeleteButton);
        }(j));
    }
}

/**
 * Adds an Image to the list of selected images
 * @param {string} selectedImage
 */
function addImageToList(selectedImage)
{
    managerImageList[managerImageList.length] = selectedImage;
    updateImageList();
}

/**
 * Removes an Image from the list of selected images
 * @param {string} selectedImage
 */
function removeImageFromList(selectedImage)
{
    for (var i = 0; i < managerImageList.length; i++)
    {
        if (managerImageList[i] === selectedImage)
        {
            managerImageList.splice(i, 1);
            updateImageList();
        }
    }
}

function createImage(name)
{
    var urlArray = name.split("/");
    var realName = urlArray[urlArray.length - 1];
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../Php/DatabaseImages.php?getImageIDByName=" + realName, true);
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {         
            createImageByID(xmlhttp.responseText);
        }
    };
    xmlhttp.send();
}

function createImageByID(id)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../Php/DatabaseImages.php?getImageByID=" + id, true);
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            var maxNumber = 1;

            //Get all Images
            if ($(".ContentEditableOpen img").length)
            {
                var imagesArray = $(".ContentEditableOpen img").parent();

                maxNumber = parseInt($(imagesArray)[imagesArray.length - 1].id) + 1;

            }

            var img = "<div class='editableImage" + maxNumber + "' id='" + maxNumber + "'> " +
                    "<style>" +
                    ".editableImage" + maxNumber + ":before { " +
                    "content: '';" +
                    "display:block; " +
                    "float: right; " +
                    "height: 0;} " +
                    "</style>"
                    +
                    "<img id='" + id + "' class='imageDatabaseLoading imageDraggable editableImage' src='' onclick='editImage(this)' style='" +
                    "width: 50%;" +
                    "float: right;" +
                    "clear: right;" +
                    "margin-right: 0;" +
                    "margin-left: 0;" +
                    "'></div>";

            /*
             var imageDiv = createElement("div");
             $(imageDiv).addClass("editableImage" + maxNumber);
             imageDiv.id = maxNumber;
             $(imageDiv).insertBefore($(".ContentEditableOpen p"));
             
             var imageStyle = createElement("style");
             imageStyle.innerHTML =
             ".editableImage"+ maxNumber + ":before { " +
             "content: '';" +
             "display:block; "+
             //  "float: right; "+
             "height: 0;}";
             imageDiv.appendChild(imageStyle);
             
             var imageImage = createElement("img");     
             imageImage.id = realName;
             $(imageImage).addClass("imageDatabaseLoading");
             $(imageImage).addClass("imageDraggable");
             $(imageImage).addClass("editableImage");
             imageImage.addEventListener("click", function()
             {
             editImage(this);
             });
             imageImage.style.width = "50%";
             imageImage.style.float = "right";
             imageImage.style.clear = "right";
             imageImage.style.marginRight = "0";
             imageImage.style.marginLeft = "0";
             imageDiv.appendChild(imageImage);
             */

            document.execCommand("insertHTML", false, img);
            destroyManager();
            loadImagesFromDatabase();

        }
    };
    xmlhttp.send();
}

function createManagerBase()
{
    document.body.style.overflow = "hidden";

    //Background color
    var backgroundColor = createElement("div");
    backgroundColor.id = "BackgroundColor";
    document.body.appendChild(backgroundColor);

    //Main manager div
    var managerDiv = createElement("div");
    managerDiv.id = "FileManager";
    document.body.appendChild(managerDiv);

    //Top part
    var topInfo = createElement("div");
    topInfo.id = "topInfo";
    managerDiv.appendChild(topInfo);

    //Back in history arrow
    var leftArrow = createElement("div");
    leftArrow.className = "ArrowHistory";
    leftArrow.innerHTML = "&#8592;";
    leftArrow.id = "LeftArrow";
    leftArrow.onclick = function ()
    {
        goBackInPath();
    };
    topInfo.appendChild(leftArrow);

    //Forward in history arrow
    var rightArrow = createElement("div");
    rightArrow.className = "ArrowHistory";
    rightArrow.id = "RightArrow";
    rightArrow.innerHTML = "&#8594;";
    rightArrow.onclick = function ()
    {
        goForwardInPath();
    };
    topInfo.appendChild(rightArrow);

    //Positionsetter for the pathSelectedBar
    var positionSetter = createElement("div");
    positionSetter.id = "positionSetter";
    topInfo.appendChild(positionSetter);

    //Displays the current selected Path
    //var pathSelectedBar = createElement("div");
    //pathSelectedBar.id = "pathSelectedBar";
    //positionSetter.appendChild(pathSelectedBar);

    //The div where all the folders and files are displayed
    var filesDiv = createElement("div");
    filesDiv.id = "Files";
    managerDiv.appendChild(filesDiv);

    //Bottom bar with buttons
    var bottomInfo = createElement("div");
    bottomInfo.id = "BottomInfo";
    managerDiv.appendChild(bottomInfo);

    //Cancel button to close the fileManager without any action done
    var cancelButton = createElement("button");
    cancelButton.id = "cancelButton";
    $(cancelButton).addClass("fileManagerButtons");
    cancelButton.innerHTML = "Cancel";
    cancelButton.onclick = function ()
    {
        destroyManager();
    };
    bottomInfo.appendChild(cancelButton);
    openFolder(PathHistory[0]);
}

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

function formDataAppendModulo(fileInput, fileUrl)
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

function sendFileBatch(fileArray, fileUrl)
{

    if (fileArray.length > 20)
    {
        formDataAppendIndex(fileArray, fileUrl);
        formDataAppendModulo(fileArray, fileUrl);
    }
    else
    {
        formAppend(fileArray, fileUrl);
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
            var maxSize = xmlhttp.responseText.split("*");

            var maxFileSize = parseInt(maxSize[0]);
            var maxFileAmount = parseInt(maxSize[1]);

            var currentBatchSize = 0;
            var currentBatchFiles = [];

            var fileToBigArray = {};

            for (var i = 0; i < fileArray.length; i++)
            {
                if (fileArray[i].size > maxFileSize)
                {
                    fileToBigArray[fileToBigArray.length] = i + 1;
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
            
            if(fileToBigArray.length > 0)
            {
                createPopupInfo("FilesBig", fileToBigArray);
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

function createUploadingBottom()
{
    var uploadForm = createElement("form");
    uploadForm.method = "post";
    uploadForm.id = "uploadForm";
    uploadForm.enctype = "multipart/form-data";

    var fileUrl = createElement("input");
    fileUrl.type = "text";
    fileUrl.name = "UploadUrl";
    fileUrl.id = "uploadFilePathURL";
    fileUrl.value = PathHistory[PathHistory.length - 1];
    uploadForm.appendChild(fileUrl);

    //The file upload input
    var fileInput = createElement("input");
    fileInput.id = "uploadFileInput";
    $(fileInput).addClass("fileManagerButtons");
    fileInput.type = "file";
    fileInput.multiple = true;
    fileInput.name = "UploadFile[]";
    uploadForm.appendChild(fileInput);

    var fileSend = createElement("input");
    fileSend.id = "uploadFileSend";
    $(fileSend).addClass("fileManagerButtons");
    fileSend.type = "submit";

    uploadForm.addEventListener("submit", function (evt)
    {
        evt.preventDefault();
        validateFiles(fileInput, fileUrl);
    }, true);
    uploadForm.appendChild(fileSend);

    getElementById("BottomInfo").appendChild(uploadForm);
}

function createSingleInputBottom(imageID)
{
    var bottom = getElementById("BottomInfo");

    var imageInput = createElement("input");
    imageInput.id = "singleInputImageFile";
    bottom.appendChild(imageInput);

    var selectButton = createElement("button");
    selectButton.id = "singleInputSelect";
    $(selectButton).addClass("fileManagerButtons");
    selectButton.innerHTML = "Selecteer";
    selectButton.addEventListener("click", function ()
    {
        if (currentSelectedPath !== null)
        {
            doXMLHttp("updatePlantImages=" + currentSelectedPath + "&imageID=" + imageID);
        }
    });
    bottom.appendChild(selectButton);
}

function createManagerSideMenu()
{
    var sideMenu = createElement("div");
    sideMenu.id = "sideMenu";
    sideMenu.ondrop = function ()
    {
        drop(event);
    };
    sideMenu.ondragover = function ()
    {
        allowDrop(event);
    };
    document.body.appendChild(sideMenu);

    var PushButton = createElement("div");
    PushButton.id = "PushButton";
    PushButton.innerHTML = ">";
    PushButton.addEventListener("click", function ()
    {
        if (currentSelectedPath !== "")
        {
            addImageToList(currentSelectedPath);
        }
    });
    document.body.appendChild(PushButton);
}

/**
 * Creates the file manager
 * @param {string} type
 * @param {element} element (optional) The element for creating the Input fields
 */
function createManager(type, element)
{
    //Creates the base Manager
    createManagerBase();

    currentSelectedPath = "";

    //Create the bottom select button
    if (type === "Uploading")
    {
        isUploading = true;
        createUploadingBottom();
    }
    else if (type === "PlantPageSingleInput")
    {
        createSingleInputBottom(element.className);
    }
    else
    {
        //Create the select button
        var selectButton = createElement("button");
        selectButton.id = "fileManagerSelectButton";
        $(selectButton).addClass("fileManagerButtons");
        selectButton.innerHTML = "Select";
        selectButton.addEventListener("click", function ()
        {
            if (type === "Insert")
            {
                restoreSelectorPoint();
                if (managerImageList.length === 0)
                {
                    if (currentSelectedPath !== "")
                    {
                        createImage(currentSelectedPath);
                    }
                }
                else
                {
                    for (var i = 0; i < managerImageList.length; i++)
                    {
                        createImage(managerImageList[i]);
                    }
                }
            }
            else if (type === "PlantPageMultipleInput")
            {
                var imageList = "";
                if (managerImageList.length > 0)
                {
                    for (var i = 0; i < managerImageList.length; i++)
                    {
                        imageList += managerImageList[i] + "*";
                    }
                }
                else
                {
                    if (currentSelectedPath !== "")
                    {
                        doXMLHttp("addPlantImages=" + currentSelectedPath + "&plantID=" + element.id + "&singleImage=yes");
                    }
                }

            }
            else if (type === "PlantPageSingleInput")
            {
                if (currentSelectedPath !== "")
                {
                    doXMLHttp("addPlantImages=" + currentSelectedPath + "&plantID=" + element.id);
                }
            }
            else
            {
                if (managerImageList.length > 0)
                {
                    //If the managerlist is not empty
                    //Loop through every managerImageList array item and create a new input item
                    for (var i = 0; i < managerImageList.length; i++)
                    {
                        var imgInput = createElement("input");
                        $(imgInput).addClass("imgInput");
                        imgInput.readOnly = true;
                        imgInput.value = managerImageList[i];
                        element.insertBefore(imgInput, element.lastChild);
                        images[images.length] = managerImageList[i];
                    }
                }
                else
                {
                    var imgInput = createElement("input");
                    $(imgInput).addClass("imgInput");
                    imgInput.readOnly = true;
                    imgInput.value = currentSelectedPath;
                    element.insertBefore(imgInput, element.lastChild);
                    images[images.length] = currentSelectedPath;
                }

                destroyManager();
            }
        });
        getElementById("BottomInfo").appendChild(selectButton);
    }

    //Create the sideMenu
    if (type === "Insert" || type === "PlantPageMultipleInput" || type === "MultipleInput")
    {
        createManagerSideMenu();
    }
}

function CreateImageContextSubMenu(ev, isNew)
{
    var createFolderDiv = createElement("div");
    createFolderDiv.id = "createFolderDiv";
    createFolderDiv.style.position = "absolute";
    createFolderDiv.style.left = ev.clientX + "px";
    createFolderDiv.style.top = ev.clientY + "px";
    createFolderDiv.innerHTML = "Folder Naam:";
    document.body.appendChild(createFolderDiv);

    var folderInput = createElement("input");
    folderInput.id = "contextFolderInput";
    createFolderDiv.appendChild(folderInput);

    var folderCancelButton = createElement("button");
    folderCancelButton.id = "contextFolderCancel";
    folderCancelButton.innerHTML = "Cancel";
    folderCancelButton.addEventListener("click", function ()
    {
        createFolderDiv.parentNode.removeChild(createFolderDiv);
    });
    createFolderDiv.appendChild(folderCancelButton);

    if (isNew)
    {
        var folderSelectButton = createElement("button");
        folderSelectButton.id = "folderSelectButton";
        folderSelectButton.innerHTML = "Nieuwe Folder";
        folderSelectButton.addEventListener("click", function ()
        {
            var GetArray = "createNewDirectory=" + PathHistory[currentPathIndex] + "/" + folderInput.value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "../Php/XMLRequest.php?" + GetArray, true);
            xmlhttp.onreadystatechange = function ()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    if (xmlhttp.responseText !== "")
                    {
                        createPopupError(xmlhttp.responseText);
                    }
                    else
                    {
                        createFolderDiv.parentNode.removeChild(createFolderDiv);
                        openFolder(PathHistory[currentPathIndex]);
                    }
                }
            };
            xmlhttp.send();
        });
        createFolderDiv.appendChild(folderSelectButton);
    }
    else
    {
        var folderSelectButton = createElement("button");
        folderSelectButton.id = "folderSelectButton";
        folderSelectButton.innerHTML = "Hernaam";
        folderSelectButton.addEventListener("click", function ()
        {
            var renameWhat;
            var path = PathHistory[currentPathIndex] + "/";
            var extension = "";
            
            if ($(ev.target).hasClass("fileManagerFile"))
            {
                renameWhat = "renameFile=";
                extension = ev.target.id.substr(ev.target.id.indexOf("."));
            }
            else
            {
                renameWhat = "renameFolder=";
            }
            
            var GetArray = renameWhat + ev.target.id + "&renameNewName=" + folderInput.value + extension + "&renamePath=" + path;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "../Php/XMLRequest.php?" + GetArray, true);
            xmlhttp.onreadystatechange = function ()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    if (xmlhttp.responseText !== "")
                    {
                        createPopupError(xmlhttp.responseText);
                    }
                    else
                    {
                        createFolderDiv.parentNode.removeChild(createFolderDiv);
                        openFolder(PathHistory[currentPathIndex]);
                    }
                }
            };
            xmlhttp.send();

        });
        createFolderDiv.appendChild(folderSelectButton);
    }

}

function CreateImageContextMenu(ev)
{
    var contextDiv = createElement("div");
    contextDiv.id = "contextDiv";
    $(contextDiv).addClass("contextMenu");
    contextDiv.style.position = "absolute";
    contextDiv.style.left = ev.clientX + "px";
    contextDiv.style.top = ev.clientY + "px";
    document.body.appendChild(contextDiv);

    var createFolder = createElement("div");
    createFolder.id = "ContextCreateButton";
    $(createFolder).addClass("contextMenu");
    createFolder.innerHTML = "Nieuwe folder";
    createFolder.addEventListener("click", function ()
    {
        CreateImageContextSubMenu(ev, true);
    });
    contextDiv.appendChild(createFolder);

    if ($(ev.target).hasClass("fileManagerFile") ||
            $(ev.target).hasClass("fileManagerFolder"))
    {
        var renameButton = createElement("div");
        renameButton.id = "ContextRenameButton";
        $(renameButton).addClass("contextMenu");
        renameButton.innerHTML = "Hernaam";
        renameButton.addEventListener("click", function ()
        {
            CreateImageContextSubMenu(ev, false);
        });
        contextDiv.appendChild(renameButton);

        var deleteButton = createElement("div");
        deleteButton.id = "ContextDeleteButton";
        $(deleteButton).addClass("contextMenu");
        deleteButton.innerHTML = "Verwijder";
        deleteButton.addEventListener("click", function ()
        {
            if ($(ev.target).hasClass("fileManagerFile"))
            {
                doXMLHttpImages("directory=" + PathHistory[currentPathIndex] +
                        "&deleteImageByName=" + ev.target.id +
                        "&type=file");
            }
            else
            {
                doXMLHttpImages("directory=" + PathHistory[currentPathIndex] + "/" + ev.target.id +
                        "&deleteImageByName=" + ev.target.id +
                        "&type=folder");
            }
        });
        contextDiv.appendChild(deleteButton);
    }
}

function DeleteImageContextMenu()
{
    if (getElementById("contextDiv"))
    {
        var contextMenu = getElementById("contextDiv");
        contextMenu.parentNode.removeChild(contextMenu);
    }
}

//NEWS PAGE
function deleteArticle(newsID)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../Php/XMLRequest.php?DeleteArticle=" + newsID, true);
    xmlhttp.send();
}

//JQuery
$(document).ready(function ()
{
    loadImagesFromDatabase();
});

if (document.addEventListener)
{
    document.addEventListener('contextmenu', function (e)
    {
        if ($(e.target).hasClass("fileManagerFile") ||
                $(e.target).hasClass("fileManagerFolder") ||
                e.target.id === "Files")
        {
            //here you draw your own menu
            DeleteImageContextMenu();
            CreateImageContextMenu(e);
            e.preventDefault();
        }
    }, false);
}

window.onmousedown = function (e)
{
    if (!$(e.target).hasClass("contextMenu"))
    {
        DeleteImageContextMenu();
    }
};