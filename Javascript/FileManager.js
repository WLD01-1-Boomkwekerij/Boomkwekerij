var currentPathHistory = [];
var currentPathNumber = 0;
var futurePathNumber = 0;
var currentSelectedPath = "";
var isUploading;

//Catalog
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
 *Checks the arrow color, if there is an history / future, change the color
 */
function checkArrowColor()
{
    var left = getElementById("LeftArrow");
    if (currentPathNumber > 0)
    {
        left.style.color = "#222222";
    } else
    {
        left.style.color = "#777777";
    }
    var right = getElementById("RightArrow");
    if (futurePathNumber > 0)
    {
        right.style.color = "#222222";
    } else
    {
        right.style.color = "#777777";
    }
}

/**
 * Creates a folder icon and makes it clickable
 * @param {type} url
 * @param {type} name
 */
function createFolderIcon(url, name)
{
    var fileManager = getElementById("Files");
    var folder = createElement("div");
    folder.className = "fileManagerFolder";
    folder.addEventListener("dblclick", function ()
    {
        openFolder(url + "/" + name);
        currentPathHistory[currentPathHistory.length] = url + "/" + name;
        currentPathNumber++;
        checkArrowColor();

        if (isUploading)
        {
            getElementById("uploadFilePathURL").value = currentPathHistory[currentPathHistory.length - 1];
        }

    });
    fileManager.appendChild(folder);

    var folderIcon = createElement("img");
    folderIcon.src = "../Images/folder.png";
    folder.appendChild(folderIcon);

    var folderName = createElement("p");
    folderName.innerHTML = name;
    folder.appendChild(folderName);
}

/**
 * Creates a file icon and makes it selectable / unselectable
 * @param {type} url
 * @param {type} name
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
            currentSelectedPath = url + "/" + name;
            file.style.boxShadow = "0px 0px 4px 0px lightgray";
            file.style.backgroundColor = "lightgray";
            getElementById("fileManagerSelectButton").value = currentSelectedPath;
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
 * @param {type} directory
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

            var arrayInt = 0;
            var filesWidth = parseInt(getElementById("Files").style.width);

            if (filesWidth > 150 && filesWidth < 600)
            {
                arrayInt = fileArray.length % 3;
            } else
            {
                arrayInt = fileArray.length % 4;
            }

            for (var i = 0; i < fileArray.length - 1; i++)
            {
                if (fileArray[i].includes("."))
                {
                    createFileIcon(directory, fileArray[i]);
                } else
                {
                    createFolderIcon(directory, fileArray[i]);
                }
            }

            for (var j = 0; j < arrayInt; j++)
            {
                createEmtpyIcon();
            }
        }
    };
    xmlhttp.send();
}

/**
 * Opens a folder and creates all the icons
 * @param {string} directory
 */
function openFolder(directory)
{
    while (getElementById("Files").firstChild)
    {
        getElementById("Files").removeChild(getElementById("Files").firstChild);
    }
    createFileIcons(directory);
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
    currentPathHistory[0] = "../Images/";

    document.body.style.overflow = "hidden";

    var backgroundColor = createElement("div");
    backgroundColor.id = "BackgroundColor";
    backgroundColor.style.backgroundColor = "Gray";
    backgroundColor.style.opacity = "0.7";
    backgroundColor.style.width = "100vw";
    backgroundColor.style.height = "100vh";
    backgroundColor.style.zIndex = "100";
    backgroundColor.style.top = "0";
    backgroundColor.style.left = "0";
    backgroundColor.style.position = "fixed";
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
        if (currentPathNumber > 0)
        {
            currentPathNumber--;
            openFolder(currentPathHistory[currentPathNumber]);
            futurePathNumber++;
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
        if (futurePathNumber > 0)
        {
            currentPathNumber++;
            openFolder(currentPathHistory[currentPathNumber]);
            futurePathNumber--;
            checkArrowColor();
        }
    };
    topInfo.appendChild(rightArrow);

    var positionSetter = createElement("div");
    positionSetter.style.position = "absolute";
    positionSetter.style.left = "50%";
    positionSetter.style.top = "10px";
    positionSetter.style.width = "70%";
    topInfo.appendChild(positionSetter);

    var pathSelectedBar = createElement("div");
    pathSelectedBar.style.position = "relative";
    pathSelectedBar.style.backgroundColor = "beige";
    pathSelectedBar.style.minWidth = "200px";
    pathSelectedBar.style.height = "30px";
    pathSelectedBar.style.boxShadow = "0px 0px 2px 0px black";
    pathSelectedBar.style.left = "-50%";
    positionSetter.appendChild(pathSelectedBar);


    var filesDiv = createElement("div");
    filesDiv.id = "Files";
    managerDiv.appendChild(filesDiv);

    var bottomInfo = createElement("div");
    bottomInfo.id = "BottomInfo";
    managerDiv.appendChild(bottomInfo);

    var cancelButton = createElement("button");
    cancelButton.style.position = "absolute";
    cancelButton.style.marginLeft = "5px";
    cancelButton.style.border = "none";
    cancelButton.style.bottom = "5px";
    cancelButton.innerHTML = "Cancel";
    cancelButton.onclick = function ()
    {
        if (arguments.length > 1)
        {
            element.parentNode.removeChild(element);
        }

        destroyManager();
        document.body.style.overflow = "visible";
    };
    bottomInfo.appendChild(cancelButton);

    if (isUploading)
    {


        var uploadForm = createElement("form");
        uploadForm.method = "post";
        uploadForm.enctype = "multipart/form-data";

        var fileUrl = createElement("input");
        fileUrl.type = "text";
        fileUrl.name = "UploadUrl";
        fileUrl.id = "uploadFilePathURL";
        fileUrl.value = currentPathHistory[currentPathHistory.length - 1];
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

    } else
    {
        var selectButton = createElement("button");
        selectButton.id = "fileManagerSelectButton";
        selectButton.style.position = "absolute";
        selectButton.style.position = "absolute";
        selectButton.style.marginRight = "5px";
        selectButton.style.border = "none";
        selectButton.style.bottom = "5px";
        selectButton.style.right = "5px";
        selectButton.innerHTML = "Select";

        if (arguments.length === 1)
        {
            selectButton.addEventListener("click", function ()
            {
                restoreSelectorPoint();
                markupText("insertImage", currentSelectedPath);
                destroyManager();
            });
        } else
        {
            selectButton.addEventListener("click", function ()
            {
                element.value = currentSelectedPath;
                destroyManager();
                images[images.length] = element.value;
            });
        }


        bottomInfo.appendChild(selectButton);
    }

    createFileIcons("../Images");
}

/**
 * Destroys the manager
 */
function destroyManager()
{
    getElementById("BackgroundColor").parentNode.removeChild(getElementById("BackgroundColor"));
    getElementById("FileManager").parentNode.removeChild(getElementById("FileManager"));
}


//CATALOG
function createCatalogAddition()
{
    var section = createElement("section");
    section.id = "addPlantMenu";
    section.style.boxShadow = "0px 0px 20px 5px black";
    getElementById("mid").appendChild(section);

    var topDiv = createElement("div");
    topDiv.style.height = "30px";
    topDiv.style.width = "auto";
    topDiv.style.backgroundColor = "#8D99C8";
    topDiv.style.borderBottom = "solid 1px gray";
    section.appendChild(topDiv);

    var buttonAddPlant = createElement("button");
    buttonAddPlant.innerHTML = "Voeg toe";
    buttonAddPlant.style.float = "right";
    buttonAddPlant.style.marginTop = "5px";
    buttonAddPlant.style.marginRight = "5px";
    buttonAddPlant.addEventListener("click", function ()
    {
        var one = getElementById("Name").value;
        var two = getElementById("groep").value;
        var three = getElementById("hoogte_min").value;
        var four = getElementById("hoogte_max").value;
        var five = getElementById("bloeitijd").value;
        var six = getElementById("bloeiwijze").value;
        var seven = "";

        for (var i = 0; i < images.length; i++)
        {
            seven += images[i] + "*";
        }

        var requestString = "../PHP/XMLRequest.php?" +
                "name=" + one +
                "&groep=" + two +
                "&hoogte_min=" + three +
                "&hoogte_max=" + four +
                "&bloeitijd=" + five +
                "&bloeiwijze=" + six +
                "&imageUrl=" + seven;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", requestString, true);
        xmlhttp.send();
    });
    topDiv.appendChild(buttonAddPlant);

    var textAddPlant = createElement("p");
    textAddPlant.innerHTML = "Plant Toevoegen";
    textAddPlant.style.lineHeight = "30px";
    textAddPlant.style.margin = "0px";
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
    rightDiv.appendChild(inputMaxHoogte);

    //Bloeitijd
    var textBloeitijd = createElement("p");
    textBloeitijd.class += "catalogAddingName";
    textBloeitijd.innerHTML = "Bloeitijd";
    leftDiv.appendChild(textBloeitijd);

    var inputBloeitijd = createElement("input");
    inputBloeitijd.class = "catalogAddingInput";
    inputBloeitijd.id = "bloeitijd";
    inputBloeitijd.placeholder = "Bloeitijd";
    rightDiv.appendChild(inputBloeitijd);

    //Bloeitijd
    var textBloeiwijze = createElement("p");
    textBloeiwijze.class += "catalogAddingName";
    textBloeiwijze.innerHTML = "Bloeiwijze";
    leftDiv.appendChild(textBloeiwijze);

    var inputBloeiwijze = createElement("input");
    inputBloeiwijze.class = "catalogAddingInput";
    inputBloeiwijze.id = "bloeiwijze";
    inputBloeiwijze.placeholder = "Bloeiwijze";
    rightDiv.appendChild(inputBloeiwijze);


    var imageButton = createElement("Button");
    imageButton.innerHTML = "Voeg foto toe";
    sectionDiv.appendChild(imageButton);
    imageButton.addEventListener("click", function ()
    {
        var imgInput = createElement("input");
        imgInput.readOnly = true;
        sectionDiv.insertBefore(imgInput, sectionDiv.lastChild);
        createManager(false, imgInput);
    });
}

//NEWS PAGE

function deleteArticle(newsID)
{
   var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/XMLRequest.php?DeleteArticle=" + newsID, true);
    xmlhttp.send();
}