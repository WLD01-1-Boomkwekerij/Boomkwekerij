//Variables

//Saved Selection
var savedSelectorPoint;
var isLinkWindowOpen;
var isFileManagerOpen;
var isEditorOpen;

window.onload = function ()
{
    isLinkWindowOpen = false;
    isFileManagerOpen = false;
    isEditorOpen = false;
};

function createElement(element)
{
    return document.createElement(element);
}

function getElementById(id)
{
    return document.getElementById(id);
}

/**
 * Inserts markup with execCommand
 * @param {type} type
 * @param {type} parameter
 */
function markupText(type, parameter)
{
    if (arguments.length === 1) {
        document.execCommand(type, false);
    } else {
        document.execCommand(type, false, parameter);
    }
}

/**
 * Creates the fileManager for image inserting
 */
function insertImage()
{
    if (!isFileManagerOpen)
    {
        createManager(false);
        isFileManagerOpen = true;
    }
}

/**
 * Creates the fileManager for the image uploading
 */
function uploadImage()
{
    if(!isFileManagerOpen)
    {
        createManager(true);
        isFileManagerOpen = true;
    }
}

/**
 * Saves the provided text to the database
 * @param {type} text
 * @param {type} textID
 */
function saveTextToDatabase(text, textID)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/XMLRequest.php?htmlText=" + text + "&textID=" + textID, true);
    xmlhttp.send();
}

/**
 * Save the current position of the cursor when called
 */
function saveSelectorPoint()
{
    if (window.getSelection)
    {
        var sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount)
        {
            var ranges = [];
            for (var i = 0, len = sel.rangeCount; i < len; ++i)
            {
                ranges.push(sel.getRangeAt(i));
            }
            savedSelectorPoint = ranges;
        }
    } else if (document.selection && document.selection.createRange)
    {
        savedSelectorPoint = document.selection.createRange();
    }
}

function restoreSelectorPoint()
{
    var savedSel = savedSelectorPoint;
    if (savedSel)
    {
        if (window.getSelection)
        {
            var sel = window.getSelection();
            sel.removeAllRanges();
            for (var i = 0, len = savedSel.length; i < len; ++i)
            {
                sel.addRange(savedSel[i]);
            }
        } else if (document.selection && savedSel.select)
        {
            savedSel.select();
        }
    }
}

/**
 * Insert a link at the saved selector point
 * @param {type} name
 * @param {type} url
 */
function insertLink(name, url)
{
    var linkHTML = "<a href='" + url + "'>" + name + "</a>";
    restoreSelectorPoint();
    markupText("insertHTML", linkHTML);
}

function createLink()
{
    var editorDiv = getElementById("Editor");

    var linkDiv = createElement("div");
    linkDiv.style.width = "235px";
    linkDiv.style.height = "110px";
    linkDiv.style.backgroundColor = "white";
    linkDiv.style.position = "absolute";
    linkDiv.style.top = "-130px";
    linkDiv.style.left = "70px";
    linkDiv.style.boxShadow = "0px 0px 5px 3px black";
    editorDiv.appendChild(linkDiv);

    var linkName = createElement("input");
    linkName.setAttribute("type", "text");
    linkName.style.marginRight = "0px";
    linkName.style.float = "Right";
    linkName.style.marginTop = "15px";
    linkName.style.marginRight = "5px";
    linkDiv.appendChild(linkName);

    var linkInput = createElement("input");
    linkInput.setAttribute("type", "text");
    linkInput.id = "url";
    linkInput.style.marginTop = "12px";
    linkInput.style.marginRight = "5px";
    linkInput.style.float = "Right";
    linkDiv.appendChild(linkInput);

    var linkText1 = createElement("p");
    linkText1.innerHTML = "Naam:";
    linkText1.style.marginLeft = "5px";
    linkDiv.appendChild(linkText1);

    var linkText2 = createElement("p");
    linkText2.innerHTML = "Link:";
    linkText2.style.marginLeft = "5px";
    linkDiv.appendChild(linkText2);

    var submit = createElement("button");
    submit.innerHTML = "Invoegen";
    submit.style.position = "absolute";
    submit.style.right = "0px";
    submit.style.top = "80px";
    submit.style.marginRight = "5px";
    submit.onclick = function ()
    {
        insertLink(linkName.value, linkInput.value);
        linkDiv.parentNode.removeChild(linkDiv);
        isLinkWindowOpen = false;
    };
    linkDiv.appendChild(submit);

    var cancel = createElement("button");
    cancel.innerHTML = "Cancel";
    cancel.style.position = "absolute";
    cancel.style.left = "0px";
    cancel.style.top = "80px";
    cancel.style.marginLeft = "5px";
    cancel.onclick = function ()
    {
        linkDiv.parentNode.removeChild(linkDiv);
        isLinkWindowOpen = false;
    };
    linkDiv.appendChild(cancel);
}

function createButton(type)
{
    var button = createElement("button");

    switch (type)
    {
        case "justifyLeft":
            button.className = "fa fa-align-left";
            break;
        case "justifyCenter":
            button.className = "fa fa-align-justify";
            break;
        case "justifyRight":
            button.className = "fa fa-align-right";
            break;
        case "insertOrderedList":
            button.className = "fa fa-list-ol";
            break;
        case "insertUnorderedList":
            button.className = "fa fa-list-ul";
            break;
        default:
            button.className = "fa fa-" + type;
            break;
    }

    switch (type)
    {
        case "image":
            button.onclick = function ()
            {
                insertImage();
            };
            break;
        case "link":
            button.onclick = function ()
            {
                if (!isLinkWindowOpen) {
                    createLink();
                }
                isLinkWindowOpen = true;
            };
            break;
        case "upload":
        button.onclick = function ()
        {
            uploadImage();
        };
        break;
        default:
            button.onclick = function ()
            {
                markupText(type);
            };
            break;
    }

    return button;
}

/**
 * Togles the clicked element editable and adds the editing system
 * @param {type} element
 */
function setContentEditable(element)
{

    if (!isEditorOpen) {
        isEditorOpen = true;
        element.contentEditable = true;
        element.className = "";
        element.className = "ContentEditableOpen";
        element.style.backgroundColor = "white";
        element.style.border = "solid 2px black";
        element.addEventListener("focusout", saveSelectorPoint());

        var parent = element.parentNode;

        var editorDiv = createElement("div");
        editorDiv.id = "Editor";

        editorDiv.style.position = "relative";
        parent.insertBefore(editorDiv, parent.childNodes[0]);

        //Buttons
        var buttonArray =
                [
                    "bold", "italic", "underline",
                    "justifyLeft", "justifyCenter", "justifyRight",
                    "insertOrderedList", "insertUnorderedList",
                    "link", "image", "upload"
                ];

        for (var i = 0; i < buttonArray.length; i++)
        {
            editorDiv.appendChild(createButton(buttonArray[i]));
        }

        var cancelButton = createElement("button");
        cancelButton.innerHTML = "Cancel";
        cancelButton.onclick = function ()
        {
            editorDiv.parentNode.removeChild(editorDiv);
            saveButton.parentNode.removeChild(saveButton);
            cancelButton.parentNode.removeChild(cancelButton);
            element.contentEditable = false;
            element.style.border = "solid 0px black";
            element.style.backgroundColor = element.parentNode.style.backgroundColor;
            element.className = "ContentEditable";
            isEditorOpen = false;
        };

        parent.appendChild(cancelButton);
        var saveButton = createElement("button");
        saveButton.innerHTML = "Save";
        saveButton.onclick = function ()
        {
            saveTextToDatabase(element.innerHTML, parseInt(element.id.replace("textID", "")));
            //window.location.reload(false);
        };
        parent.appendChild(saveButton);
    }
}

//Get image url from database
function selectImage(imageID)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/GetImages.php?imageList=" + imageID, true);
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200)
        {
            //Create image
            var img = createElement("img");
            img.src = "../images/" + xmlhttp.responseText;
            img.className = "editableImage";
            img.style.width = "300px";
            img.style.border = "solid 2px black";
            //img.onclick = function () {
            //    editImage(this);
            //  };
            document.body.appendChild(img);
        }
    };
    xmlhttp.send();
}

var map = {};
document.onkeydown = document.onkeyup = function (e)
{

    e = e || event;
    map[e.keyCode] = e.type === "keydown";

    //Redo and Undo
    if (map[17] && map[90] && map[16])
    {
        document.execCommand("redo", false);
        return false;
    } else if (map[17] && map[90])
    {
        document.execCommand("undo", false);
        return false;
    }
    //Tab
    if (map[9])
    {
        markupText("insertHTML", "&emsp;");
        return false;
    }

    //Space
    if (map[32] && e.target.className === "ContentEditableOpen") {
        e.preventDefault();
        markupText("insertHTML", "&#8197;");
        return false;
    }
};

//Jquery Code
$(document).ready(function ()
{
    $(".ContentEditable").click(function ()
    {
        if (!isEditorOpen) {
            setContentEditable($(this)[0]);
            isEditorOpen = true;
        }
    });
});