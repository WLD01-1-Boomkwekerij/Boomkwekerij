
//The history of all items clicked, left arrow will use it to go back
var PathHistory = [];
//The first history is always the main folder
PathHistory[0] = "../Images/Afbeeldingen";
//All the selected items in the right side list
var managerImageList = [];
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

/**
 * Selects a clicked item and deselects the previous
 * @param {element} element
 * @param {string} url 
 * @param {string} name 
 */
function setItemSelected(element, url, name)
{
    $(currentSelectedElement).removeClass("selectedItem");
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

/**
 * Creates a folder icon and makes it clickable
 * @param {string} url The url of the folder
 * @param {string} name The name of the folder
 */
function createFolderIcon(url, name)
{
    var fileManager = getElementById("Files");

    //Create a folder Div
    var folder = createElement("div");
    folder.className = "fileManagerFolder";
    folder.addEventListener("dblclick", function ()
    {
        //On Double click: Open the folder
        openFolder(url + "/" + name);
        //--Change to always current--
        PathHistory[PathHistory.length] = url + "/" + name;
        currentPathIndex++;
        //Arrow color (Maybe change to classes)
        checkArrowColor();

        if (isUploading)
        {
            getElementById("uploadFilePathURL").value = PathHistory[PathHistory.length - 1];
        }

    });
    fileManager.appendChild(folder);

    //Adds the icon for the folder
    var folderIcon = createElement("img");
    folderIcon.src = "../Images/SiteImages/folder.png";
    folder.appendChild(folderIcon);

    //Adds the name for the folder
    var folderName = createElement("p");
    folderName.innerHTML = name;
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
    file.className = "fileManagerFile";
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
    getElementById("PullButton").parentNode.removeChild(getElementById("PullButton"));
    getElementById("sideMenu").parentNode.removeChild(getElementById("sideMenu"));
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
            imageDeleteButton.onclick = function ()
            {
                removeImageFromList(managerImageList[j]);
            };
            sidebar.appendChild(imageDeleteButton);
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

function getImageByName(name)
{
    var urlArray = name.split("/");
    var realName = urlArray[urlArray.length - 1];

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/DatabaseImages.php?getImageByName" + realName, true);
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            console.log(xmlhttp.responseText);
            return xmlhttp.responseText;
        }
    };
    xmlhttp.send();
}


/**
 * Creates the file manager
 * @param {bool} uploading
 * @param {element} element
 */
function createManager(uploading, element)
{
    isUploading = uploading;
    currentSelectedPath = "";

    document.body.style.overflow = "hidden";

    var backgroundColor = createElement("div");
    backgroundColor.id = "BackgroundColor";
    document.body.appendChild(backgroundColor);

    var managerDiv = createElement("div");
    managerDiv.id = "FileManager";
    document.body.appendChild(managerDiv);

    var topInfo = createElement("div");
    topInfo.id = "topInfo";
    managerDiv.appendChild(topInfo);

    var leftArrow = createElement("div");
    leftArrow.className = "ArrowHistory";
    leftArrow.innerHTML = "&#8592;";
    leftArrow.id = "LeftArrow";
    leftArrow.onclick = function ()
    {
        //Go back in history
        if (currentPathIndex > 0)
        {
            currentPathIndex--;
            openFolder(PathHistory[PathHistory]);
            currentPathIndex++;
            checkArrowColor();
        }
    };
    topInfo.appendChild(leftArrow);

    var rightArrow = createElement("div");
    rightArrow.className = "ArrowHistory";
    rightArrow.id = "RightArrow";
    rightArrow.innerHTML = "&#8594;";
    rightArrow.onclick = function ()
    {
        //Go to the future
        if (currentPathIndex > 0)
        {
            currentPathIndex++;
            openFolder(PathHistory[currentPathIndex]);
            currentPathIndex--;
            checkArrowColor();
        }
    };
    topInfo.appendChild(rightArrow);

    var positionSetter = createElement("div");
    positionSetter.id = "positionSetter";
    topInfo.appendChild(positionSetter);

    var pathSelectedBar = createElement("div");
    pathSelectedBar.id = "pathSelectedBar";
    positionSetter.appendChild(pathSelectedBar);

    var filesDiv = createElement("div");
    filesDiv.id = "Files";
    managerDiv.appendChild(filesDiv);

    var bottomInfo = createElement("div");
    bottomInfo.id = "BottomInfo";
    managerDiv.appendChild(bottomInfo);

    var cancelButton = createElement("button");
    cancelButton.id = "cancelButton";
    cancelButton.innerHTML = "Cancel";
    cancelButton.onclick = function ()
    {
        destroyManager();
    };
    bottomInfo.appendChild(cancelButton);

    //Create the Upload Images HTML
    if (isUploading)
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

        var fileInput = createElement("input");
        fileInput.type = "file";
        fileInput.name = "UploadFile";
        uploadForm.appendChild(fileInput);

        var fileSend = createElement("input");
        fileSend.type = "submit";
        fileSend.name = "submitUploadFile";
        uploadForm.appendChild(fileSend);

        bottomInfo.appendChild(uploadForm);
    }
    else
    {
        //Create the select button
        var selectButton = createElement("button");
        selectButton.id = "fileManagerSelectButton";
        selectButton.innerHTML = "Select";

        //General Text image adding
        if (arguments.length === 1)
        {
            selectButton.addEventListener("click", function ()
            {
                restoreSelectorPoint();
                for (var i = 0; i < managerImageList.length; i++)
                {
                    var img = "<img src='" + getImageByName(managerImageList[i]) + "' onclick='editImage(this)' style='" +
                            "width: 50%;" +
                            "float: right;" +
                            "clear: right;" +
                            "top: 0;" +
                            "'>";
                    document.execCommand("insertHTML", false, img);
                    destroyManager();
                }
            });
        }
        //Input image adding
        else
        {
            //If the managerlist is not empty
            selectButton.addEventListener("click", function ()
            {
                //Loop through every image array item and create a new input item
                for (var i = 0; i <  managerImageList.length; i++)
                {
                    var imgInput = createElement("input");
                    imgInput.readOnly = true;
                    imgInput.value = managerImageList[i];
                    element.insertBefore(imgInput, element.lastChild);
                    images[images.length] = managerImageList[i];
                }
                destroyManager();
            });
        }
        bottomInfo.appendChild(selectButton);
    }

    createFileIcons(PathHistory[0]);

    var sideMenu = createElement("div");
    sideMenu.id = "sideMenu";
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

    var PullButton = createElement("div");
    PullButton.id = "PullButton";
    PullButton.innerHTML = "<";
    PullButton.addEventListener("click", function ()
    {
        removeImageFromList(currentSelectedPath);
    });
    document.body.appendChild(PullButton);
}

//CATALOG
function createCatalogAddition()
{
    var section = createElement("section");
    section.id = "addPlantMenu";
    getElementById("mid").appendChild(section);

    var topDiv = createElement("div");
    topDiv.id = "topDiv";
    section.appendChild(topDiv);

    var buttonAddPlant = createElement("button");
    buttonAddPlant.innerHTML = "Voeg toe";
    buttonAddPlant.style.float = "right";
    buttonAddPlant.style.marginTop = "5px";
    buttonAddPlant.style.marginRight = "5px";
    buttonAddPlant.addEventListener("click", function ()
    {
        if (!plantAdded)
        {
            plantAdded = true;
            var one = getElementById("Name");
            var two = getElementById("groep");
            var three = getElementById("hoogte_min");
            var four = getElementById("hoogte_max");
            var five = getElementById("Bloeitijd1");
            var six = getElementById("Bloeitijd2");
            var seven = getElementById("Bloeiwijze");
            var eight = "";


            if (one.checkValidity() && one.value !== "" &&
                    two.checkValidity() &&
                    three.checkValidity() && three.value !== "" &&
                    four.checkValidity() && four.value !== "" &&
                    five.checkValidity() &&
                    six.checkValidity() &&
                    seven.checkValidity() && seven.value !== "")
            {

                for (var i = 0; i < images.length; i++)
                {
                    eight += images[i] + "*";
                }

                var requestString = "../PHP/XMLRequest.php?" +
                        "name=" + one.value +
                        "&groep=" + two.value +
                        "&hoogte_min=" + three.value +
                        "&hoogte_max=" + four.value +
                        "&bloeitijd1=" + five.value +
                        "&bloeitijd2=" + six.value +
                        "&bloeiwijze=" + seven.value +
                        "&imageUrl=" + eight;

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", requestString, true);
                xmlhttp.onreadystatechange = function ()
                {
                    if (this.readyState === 4 && this.status === 200)
                    {
                        //console.log(xmlhttp.responseText);
                        location.reload();
                    }
                };
                xmlhttp.send();
            }
        }
    });
    topDiv.appendChild(buttonAddPlant);

    var textAddPlant = createElement("p");
    textAddPlant.innerHTML = "Plant Toevoegen";
    textAddPlant.style.lineHeight = "30px";
    textAddPlant.style.margin = "0";
    textAddPlant.style.marginLeft = "5px";
    textAddPlant.style.fontWeight = "bold";
    topDiv.appendChild(textAddPlant);

    var sectionDiv = createElement("div");
    sectionDiv.id = "catalogAddDivSide";
    section.appendChild(sectionDiv);

    var rightDiv = createElement("div");
    rightDiv.id = "elementTwo";
    rightDiv.style.width = "60%";
    rightDiv.style.height = "auto";
    rightDiv.style.float = "right";
    rightDiv.style.marginTop = "10px";
    sectionDiv.appendChild(rightDiv);

    var leftDiv = createElement("div");
    leftDiv.id = "elementOne";
    leftDiv.style.width = "40%";
    leftDiv.style.height = "auto";
    leftDiv.style.marginTop = "10px";
    sectionDiv.appendChild(leftDiv);


    //Naam | Inputs
    //Naam
    var textNaam = createElement("p");
    textNaam.class += "catalogAddingName";
    textNaam.innerHTML = "Naam:";
    leftDiv.appendChild(textNaam);

    var inputNaam = createElement("input");
    inputNaam.class = "catalogAddingInput";
    inputNaam.id = "Name";
    inputNaam.placeholder = "Naam";
    inputNaam.type = "text";
    rightDiv.appendChild(inputNaam);

    //Select Groep
    var textGroep = createElement("p");
    textGroep.class += "catalogAddingName";
    textGroep.innerHTML = "Groep:";
    leftDiv.appendChild(textGroep);


    var selectElement = createElement("select");
    selectElement.id = "groep";
    rightDiv.appendChild(selectElement);

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/XMLRequest.php?CatalogSelectOptions=yes", true);

    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            var optionArray = xmlhttp.responseText.split("*");

            for (var i = 0; i < optionArray.length - 1; i += 2)
            {
                var option = createElement("option");
                option.value = optionArray[i + 1];
                option.innerHTML = optionArray[i];
                selectElement.appendChild(option);
            }
        }
    };
    xmlhttp.send();

    //Min hoogte
    var textMinHoogte = createElement("p");
    textMinHoogte.class += "catalogAddingName";
    textMinHoogte.innerHTML = "Min.Hoogte";
    leftDiv.appendChild(textMinHoogte);

    var inputMinHoogte = createElement("input");
    inputMinHoogte.class = "catalogAddingInput";
    inputMinHoogte.id = "hoogte_min";
    inputMinHoogte.type = "number";
    inputMinHoogte.placeholder = "Hoogte (in cm)";
    rightDiv.appendChild(inputMinHoogte);

    //Max Hoogte
    var textMaxHoogte = createElement("p");
    textMaxHoogte.class += "catalogAddingName";
    textMaxHoogte.innerHTML = "Max.Hoogte";
    leftDiv.appendChild(textMaxHoogte);

    var inputMaxHoogte = createElement("input");
    inputMaxHoogte.class = "catalogAddingInput";
    inputMaxHoogte.id = "hoogte_max";
    inputMaxHoogte.placeholder = "Hoogte (in cm)";
    inputMaxHoogte.type = "number";
    rightDiv.appendChild(inputMaxHoogte);

    //Bloeitijd
    var textBloeitijd = createElement("p");
    textBloeitijd.class += "catalogAddingName";
    textBloeitijd.innerHTML = "Bloeitijd";
    leftDiv.appendChild(textBloeitijd);

    var monthArray = [
        "Januari",
        "Februari",
        "Maart",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Augustus",
        "September",
        "Oktober",
        "November",
        "December"
    ];

    var inputBloeitijd1 = createElement("select");
    inputBloeitijd1.class = "catalogAddingInput";
    inputBloeitijd1.id = "Bloeitijd1";
    rightDiv.appendChild(inputBloeitijd1);

    for (var i = 0; i < monthArray.length; i++)
    {
        var option = createElement("option");
        option.value = monthArray[i];
        option.innerHTML = monthArray[i];
        inputBloeitijd1.appendChild(option);
    }

    var inputBloeitijd2 = createElement("select");
    inputBloeitijd2.class = "catalogAddingInput";
    inputBloeitijd2.id = "Bloeitijd2";
    rightDiv.appendChild(inputBloeitijd2);


    for (var i = 0; i < monthArray.length; i++)
    {
        var option = createElement("option");
        option.value = monthArray[i];
        option.innerHTML = monthArray[i];
        inputBloeitijd2.appendChild(option);
    }

    //Bloeitijd
    var textBloeiwijze = createElement("p");
    textBloeiwijze.class += "catalogAddingName";
    textBloeiwijze.innerHTML = "Bloeiwijze";
    leftDiv.appendChild(textBloeiwijze);

    var inputBloeiwijze = createElement("input");
    inputBloeiwijze.class = "catalogAddingInput";
    inputBloeiwijze.id = "Bloeiwijze";
    inputBloeiwijze.placeholder = "Bloeiwijze";
    rightDiv.appendChild(inputBloeiwijze);

    var imageButton = createElement("Button");
    imageButton.innerHTML = "Voeg foto toe";
    imageButton.style.marginLeft = "105px";
    imageButton.style.backgroundColor = "#f2f2f2";

    sectionDiv.appendChild(imageButton);
    imageButton.addEventListener("click", function ()
    {
        createManager(false, sectionDiv);
    });
}

//NEWS PAGE
function deleteArticle(newsID)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/XMLRequest.php?DeleteArticle=" + newsID, true);
    xmlhttp.send();
}