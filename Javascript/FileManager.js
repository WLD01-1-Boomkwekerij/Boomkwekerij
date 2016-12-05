
function createElement(element)
{
    return document.createElement(element);
}

function getElementById(id)
{
    return document.getElementById(id);
}

function createManager()
{
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
    cancelButton.onclick = function(){
        destroyManager();
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
}

function destroyManager()
{
    isFileManagerOpen = false;
    getElementById("BackgroundColor").parentNode.removeChild(getElementById("BackgroundColor"));
    getElementById("FileManager").parentNode.removeChild(getElementById("FileManager"));
}