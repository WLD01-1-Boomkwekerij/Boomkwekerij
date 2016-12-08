var currentPathHistory = [];
var currentPathNumber = 0;
var futurePathNumber = 0;

function createElement(element)
{
    return document.createElement(element);
}

function getElementById(id)
{
    return document.getElementById(id);
}

function checkArrowColor()
{
    var left = getElementById("LeftArrow");
    if(currentPathNumber > 0){
        left.style.color = "#222222";
    }else{
        left.style.color = "#777777";
    }
    var right = getElementById("RightArrow");
    if(futurePathNumber > 0){
        right.style.color = "#222222";
    }else{
        right.style.color = "#777777";
    }
}

function createFolderIcon(url, name)
{
    var fileManager = getElementById("Files");
    var folder = createElement("div");
    folder.className = "fileManagerFolder";
    folder.addEventListener("dblclick", function () {
        openFolder(url + "/" + name);
        currentPathHistory[currentPathHistory.length] = url + "/" + name;
        currentPathNumber++;
        checkArrowColor();
    });
    fileManager.appendChild(folder);

    var folderIcon = createElement("img");
    folderIcon.src = "../Images/folder.png";
    folder.appendChild(folderIcon);

    var folderName = createElement("p");
    folderName.innerHTML = name;
    folder.appendChild(folderName);
}

function createFileIcon(url, name)
{
    var fileManager = getElementById("Files");
    var file = createElement("div");
    file.className = "fileManagerFile";
    fileManager.appendChild(file);

    var fileIcon = createElement("img");
    fileIcon.src = url + "/" + name;
    fileIcon.style.width = "150px";
    file.appendChild(fileIcon);

    var fileName = createElement("p");
    fileName.innerHTML = name;
    file.appendChild(fileName);
}

function createEmtpyIcon()
{
    var fileManager = getElementById("Files");
    var empty = createElement("div");
    empty.className = "fileManagerEmpty";
    fileManager.appendChild(empty);
}

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
            } else {
                arrayInt = fileArray.length % 4;
            }

            for (var i = 0; i < fileArray.length - 1; i++)
            {
                if (fileArray[i].includes("."))
                {
                    createFileIcon(directory, fileArray[i]);
                } else {
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

function openFolder(directory)
{
    while (getElementById("Files").firstChild) {
        getElementById("Files").removeChild(getElementById("Files").firstChild);
    }
    createFileIcons(directory);
}

function createManager()
{

    currentPathHistory[0] = "../Images/";
    console.log(currentPathHistory[0]);

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
    leftArrow.onclick = function () {
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
    rightArrow.onclick = function () {
        if (futurePathNumber > 0)
        {
            currentPathNumber++;
            openFolder(currentPathHistory[currentPathNumber]);
            futurePathNumber--;
            checkArrowColor();
        }
    };
    topInfo.appendChild(rightArrow);

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
    cancelButton.onclick = function () {
        destroyManager();
        document.body.style.overflow = "visible";
    };
    bottomInfo.appendChild(cancelButton);

    var selectButton = createElement("button");
    selectButton.style.position = "absolute";
    selectButton.style.position = "absolute";
    selectButton.style.marginRight = "5px";
    selectButton.style.border = "none";
    selectButton.style.bottom = "5px";
    selectButton.style.right = "5px";
    selectButton.innerHTML = "Select";
    bottomInfo.appendChild(selectButton);

    var positionSetter = createElement("div");
    positionSetter.style.position = "absolute";
    positionSetter.style.left = "50%";
    positionSetter.style.top = "10px";
    positionSetter.style.width = "70%";
    bottomInfo.appendChild(positionSetter);

    var pathSelectedBar = createElement("div");
    pathSelectedBar.style.position = "relative";
    pathSelectedBar.style.backgroundColor = "beige";
    pathSelectedBar.style.minWidth = "200px";
    pathSelectedBar.style.height = "30px";
    pathSelectedBar.style.boxShadow = "0px 0px 2px 0px black";
    pathSelectedBar.style.left = "-50%";
    positionSetter.appendChild(pathSelectedBar);

    createFileIcons("../Images");
}

function destroyManager()
{
    isFileManagerOpen = false;
    getElementById("BackgroundColor").parentNode.removeChild(getElementById("BackgroundColor"));
    getElementById("FileManager").parentNode.removeChild(getElementById("FileManager"));
}