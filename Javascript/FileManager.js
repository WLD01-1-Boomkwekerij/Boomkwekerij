
/* global managerImageList */

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
var isUploading;
//The fileSend element where the name of the image goes as value
var fileSend;

//Catalog
//If you added a plant
var plantAdded = false;
var images = [];

/**
 * Create an element
 * @param {type} element
 * @returns {Element}
 */
function createElement(element)
{
    return document.createElement(element);
}

/**
 * Gets an element in the document by id
 * @param {type} id
 * @returns {Element}
 */
function getElementById(id)
{
    return document.getElementById(id);
}

function doXMLHttpImages(GetArray)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/DatabaseImages.php?" + GetArray, true);
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (xmlhttp.responseText !== "")
            {
                console.log(xmlhttp.responseText);
            }
            else
            {
                $("#Files").load(document.URL + "#Files");
            }
        }
    };
    xmlhttp.send();
}

/**
 * Cancel default event on items that are allowed to be dropped on
 * @param {type} ev
 */
function allowDrop(ev)
{
    ev.preventDefault();
}

/**
 * Sets the Icon data of the current dragged item
 * @param {type} ev
 */
function drag(ev)
{
    ev.dataTransfer.setData("Icon", ev.target.id);
}

/**
 * Updates the image url in the database
 * @param {type} ev
 */
function drop(ev)
{
    ev.preventDefault();
    var data = ev.dataTransfer.getData("Icon");

    if (ev.target.id === "sideMenu")
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
 * Loads all the images from the databse and sets their .src
 */
function loadImagesFromDatabase()
{
    $(".imageDatabaseLoading").each(function ()
    {
        var imageId = $(this).attr("id");

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "../PHP/DatabaseImages.php?getImageByName=" + imageId, true);
        xmlhttp.onreadystatechange = function ()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                getElementById(imageId).src = xmlhttp.responseText + "/" + imageId;
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
    if ($(currentSelectedElement).hasClass("selectedItem"))
    {
        $(currentSelectedElement).removeClass("selectedItem");
    }
    currentSelectedElement = element;
    $(currentSelectedElement).addClass("selectedItem");
    currentSelectedPath = url + "/" + name;
}

/**
 *Checks the arrow color, if there is an history / future, change the color
 */
function checkArrowColor()
{
    //TODO
}

function goBackInPath()
{
    //Go back in history
    if (currentPathIndex > 0)
    {
        currentPathIndex--;
        openFolder(PathHistory[currentPathIndex]);
        checkArrowColor();
    }
}

function goForwardInPath()
{
    //Go to the future
    if (currentPathIndex > 0)
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
    file.className = "fileManagerFile";
    file.draggable = true;
    file.ondragstart = function (event)
    {
        drag(event);
    };
    fileManager.appendChild(file);

    var fileIcon = createElement("img");
    fileIcon.src = url + "/" + name;
    file.appendChild(fileIcon);

    var fileName = createElement("p");
    fileName.innerHTML = name;
    file.appendChild(fileName);

    if (!isUploading)
    {
        file.addEventListener("click", function ()
        {
            setItemSelected(this, url, name);
        });
    }
}

/**
 * Creates an empty icon for aligning purposes
 */
function createEmtpyIcon()
{
    var fileManager = getElementById("Files");
    var empty = createElement("div");
    empty.className = "fileManagerEmpty";
    fileManager.appendChild(empty);
}

/**
 * Creates all the icons
 * @param {string} directory
 */
function createFileIcons(directory)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/XMLRequest.php?fileDirectory=" + directory, true);
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
    getElementById("PushButton").parentNode.removeChild(getElementById("PushButton"));
    getElementById("sideMenu").parentNode.removeChild(getElementById("sideMenu"));

    managerImageList = [];
    PathHistory = [];
    currentPathIndex = 0;
    PathHistory[0] = "../Images/Afbeeldingen";
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

function createImageByName(name)
{
    var urlArray = name.split("/");
    var realName = urlArray[urlArray.length - 1];

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/DatabaseImages.php?getImageByName=" + realName, true);
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            var img = "<img id='" + realName + "' class='imageDatabaseLoading imageDraggable' src='' onclick='editImage(this)' style='" +
                    "width: 50%;" +
                    "float: right;" +
                    "clear: right;" +
                    "top: 0;" +
                    "'>";
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
    var pathSelectedBar = createElement("div");
    pathSelectedBar.id = "pathSelectedBar";
    positionSetter.appendChild(pathSelectedBar);

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
    cancelButton.innerHTML = "Cancel";
    cancelButton.onclick = function ()
    {
        destroyManager();
    };
    bottomInfo.appendChild(cancelButton);
}

function createUploadingBottom()
{
    var uploadForm = createElement("form");
    uploadForm.method = "post";
    uploadForm.enctype = "multipart/form-data";

    var fileUrl = createElement("input");
    fileUrl.type = "text";
    fileUrl.name = "UploadUrl";
    fileUrl.id = "uploadFilePathURL";
    fileUrl.value = PathHistory[PathHistory.length - 1];
    uploadForm.appendChild(fileUrl);

    //The file upload input
    var fileInput = createElement("input");
    fileInput.type = "file";
    fileInput.multiple = true;
    fileInput.name = "UploadFile[]";
    uploadForm.appendChild(fileInput);

    fileSend = createElement("input");
    fileSend.type = "submit";
    fileSend.name = "submitUploadFile";
    uploadForm.appendChild(fileSend);

    getElementById("BottomInfo").appendChild(uploadForm);
}

function createManagerSideMenu()
{

    createFileIcons(PathHistory[0]);
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
        createUploadingBottom();
    }
    else
    {
        //Create the select button
        var selectButton = createElement("button");
        selectButton.id = "fileManagerSelectButton";
        selectButton.innerHTML = "Select";
        selectButton.addEventListener("click", function ()
        {
            if (type === "Insert")
            {
                restoreSelectorPoint();
                console.log(managerImageList.length);
                if (managerImageList.length === 0)
                {
                    if (!currentSelectedPath !== null)
                    {
                        createImageByName(currentSelectedPath);
                    }
                }
                else
                {
                    for (var i = 0; i < managerImageList.length; i++)
                    {
                        createImageByName(managerImageList[i]);
                    }
                }
            }
            else
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
                destroyManager();
            }
        });
        getElementById("BottomInfo").appendChild(selectButton);
    }

    //Create the sideMenu
    if (type === "Insert" || type === "MultipleInput")
    {
        createManagerSideMenu();
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

    if ($(ev.target).hasClass("fileManagerFile") ||
                $(ev.target).hasClass("fileManagerFolder"))
    {
        var deleteButton = createElement("div");
        deleteButton.id = "ContextDeleteButton";
        $(deleteButton).addClass("contextMenu");
        deleteButton.innerHTML = "Verwijder";
        deleteButton.addEventListener("click", function ()
        {

        });
        contextDiv.appendChild(deleteButton);
    }

    var createFolder = createElement("div");
    createFolder.id = "ContextCreateButton";
    $(createFolder).addClass("contextMenu");
    createFolder.innerHTML = "Nieuwe folder";
    createFolder.addEventListener("click", function ()
    {
        var positionerFolderDiv = createElement("div");
        positionerFolderDiv.id = "positionerFolderDiv";
        document.body.appendChild(positionerFolderDiv);
        
        var createFolderDiv = createElement("div");
        createFolderDiv.id = "createFolderDiv";
        createFolderDiv.innerHTML = "Folder Naam:";
        positionerFolderDiv.appendChild(createFolderDiv);
        
        var folderInput = createElement("input");
        folderInput.id = "contextFolderInput";
        createFolderDiv.appendChild(folderInput);
        
        var folderCancelButton = createElement("button");
        folderCancelButton.id = "contextFolderCancel";
        folderCancelButton.innerHTML = "Cancel";
        folderCancelButton.addEventListener("click", function()
        {
            positionerFolderDiv.parentNode.removeChild(positionerFolderDiv);
        });            
        createFolderDiv.appendChild(folderCancelButton);
        
        var folderSelectButton = createElement("button");
        folderSelectButton.id = "folderSelectButton";
        folderSelectButton.innerHTML = "Nieuwe Folder";
        folderSelectButton.addEventListener("click", function()
        {
            doXMLHttp("createNewDirectory=" + PathHistory[currentPathIndex] + "/" + folderInput.value);
        });
        createFolderDiv.appendChild(folderSelectButton);        
    });
    contextDiv.appendChild(createFolder);
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
    xmlhttp.open("GET", "../PHP/XMLRequest.php?DeleteArticle=" + newsID, true);
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
else
{
    document.attachEvent('oncontextmenu', function ()
    {
        alert("You've tried to open context menu");
        window.event.returnValue = false;
    });
}

window.onmousedown = function (e)
{
    if (!$(e.target).hasClass("contextMenu"))
    {
        DeleteImageContextMenu();
    }
};