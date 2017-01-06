//Variables
//Saved Selection
var savedSelectorPoint;
var isLinkWindowOpen = false;
var isFileManagerOpen = false;
var isEditorOpen = false;
var isImageEditorOpen = false;
var currentSavedHTML;
var currentSavedTitle;
var currentSelectedImage = null;

function createElement(element)
{
    return document.createElement(element);
}

function getElementById(id)
{
    return document.getElementById(id);
}

function doXMLHttp(GetArray)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/XMLRequest.php?" + GetArray, true);
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (xmlhttp.responseText === "")
            {
                location.reload();
            }
            else
            {
                console.log(xmlhttp.responseText);
            }
        }
    };
    xmlhttp.send();
}

/**
 * Inserts markup with execCommand
 * @param {type} type
 * @param {type} parameter
 */
function markupText(type, parameter)
{
    if (arguments.length === 1)
    {
        document.execCommand(type, false);
    }
    else
    {
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
        isFileManagerOpen = true;
        createManager("Insert");
    }
}

/**
 * Creates the fileManager for the image uploading
 */
function uploadImage()
{
    if (!isFileManagerOpen)
    {
        isFileManagerOpen = true;
        createManager("Uploading");
    }
}

/**
 * Updates the provided text to the database
 * @param {string} text
 * @param {int} textID
 */
function updateTextToDatabase(text, textID)
{
    doXMLHttp("textID=" + textID + "&htmlUpdateText=" + text);
}

//News Inserting, Updating and Deleteing

/**
 * 
 * @param {int} visibility
 * @param {string} text
 * @param {string} title
 */
function insertNewsTextToDatabase(visibility, text, title)
{
    doXMLHttp("newsVisibility=" + visibility + "&newsHtmlInsertText=" + text + "&newsTitle=" + title);
}

/**
 * 
 * @param {int} newsID
 * @param {int} visibility
 * @param {string} text
 * @param {string} title
 */
function updateNewsTextToDatabase(newsID, visibility, text, title)
{
    doXMLHttp("newsHtmlUpdateText=" + text + "&newsID=" + newsID + "&newsTitle=" + title + "&newsVisibility=" + visibility);
}

function deleteNewsText(newsID)
{
    doXMLHttp("newsDeleteID=" + newsID);
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
    }
    else if (document.selection && document.selection.createRange)
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
        }
        else if (document.selection && savedSel.select)
        {
            savedSel.select();
        }
    }
}

function moveImageHorizontal(amount)
{
    if (currentSelectedImage.style.cssFloat === "right")
    {
        amount *= -1;
    }



    var marginRight = parseInt(currentSelectedImage.style.marginRight, 10) + amount;
    var marginLeft = parseInt(currentSelectedImage.style.marginLeft, 10) + amount;


    var parentNodeThing = currentSelectedImage.parentNode.parentNode.parentNode;
    var topEditor = window.getComputedStyle(parentNodeThing);


    //Flipping image side
    if (marginLeft > (parseInt(topEditor.width) - parseInt(currentSelectedImage.style.width)) / 2)
    {
        currentSelectedImage.style.marginLeft = "0px";
        currentSelectedImage.style.cssFloat = "right";
        currentSelectedImage.style.marginRight = ((parseInt(topEditor.width) - parseInt(currentSelectedImage.style.width)) / 2 - (amount * 2)).toString() + "px";
    }
    
    console.log(parseInt(topEditor.width));
    console.log(parseInt(currentSelectedImage.style.width));
    console.log((parseInt(topEditor.width) - parseInt(currentSelectedImage.style.width)) / 2);

    if (marginRight > (parseInt(topEditor.width) - parseInt(currentSelectedImage.style.width)) / 2)
    {
        currentSelectedImage.style.marginRight = "0px";
        currentSelectedImage.style.cssFloat = "left";
        currentSelectedImage.style.marginLeft = ((parseInt(topEditor.width) - parseInt(currentSelectedImage.style.width)) / 2 - (amount * 2)).toString() + "px";
    }



    //Moving Image
    if (currentSelectedImage.style.cssFloat === "left")
    {

        if (marginLeft >= 0 && marginLeft <= parseInt(topEditor.width) - parseInt(currentSelectedImage.style.width) / 2)
        {
            currentSelectedImage.style.marginLeft = (parseInt(currentSelectedImage.style.marginLeft) + amount).toString() + "px";

        }
    }
    else
    {
        if (marginRight >= 0 && marginRight <= parseInt(topEditor.width) - parseInt(currentSelectedImage.style.width))
        {
            var newAmount = (parseInt(currentSelectedImage.style.marginRight) + amount) + "px";
            currentSelectedImage.style.marginRight = newAmount;
        }
    }
}

function createImageButton(type)
{
    var button = createElement("button");
    $(button).addClass("fa");
    $(button).addClass("ImageEditor");

    switch (type)
    {
        case "justifyLeft":
            $(button).addClass("fa-align-left");
            button.addEventListener("click", function ()
            {
                currentSelectedImage.style.float = "left";
            });
            break;
        case "justifyCenter":
            $(button).addClass("fa-align-center");
            button.addEventListener("click", function ()
            {
                currentSelectedImage.style.float = "right";
                currentSelectedImage.style.marginRight = "25%";
                currentSelectedImage.style.marginLeft = "5px";
            });
            break;
        case "justifyRight":
            $(button).addClass("fa-align-right");
            button.addEventListener("click", function ()
            {
                currentSelectedImage.style.float = "right";
                currentSelectedImage.style.marginRight = "0";
                currentSelectedImage.style.marginLeft = "5px";
            });
            break;
        case "justifyNone":
            $(button).addClass("fa-align-justify");
            button.addEventListener("click", function ()
            {
                currentSelectedImage.style.float = "none";
            });
            break;
        case "plus":
            $(button).addClass("fa-plus");
            button.addEventListener("click", function ()
            {
                currentSize = parseInt(currentSelectedImage.style.width, 10);
                if (currentSize <= 90)
                {
                    currentSize += 10;
                    currentSelectedImage.style.width = currentSize + "%";
                }
            });
            break;
        case "minus":
            $(button).addClass("fa-minus");
            button.addEventListener("click", function ()
            {
                currentSize = parseInt(currentSelectedImage.style.width, 10);
                if (currentSize >= 20)
                {
                    currentSize -= 10;
                    currentSelectedImage.style.width = currentSize + "%";
                }
            });
            break;
        case "arrowLeft":
            $(button).addClass("fa-arrow-left");
            button.addEventListener("click", function ()
            {
                //WIP
                //moveImageHorizontal(-10);
            });
            break;
        case "arrowUp":
            $(button).addClass("fa-arrow-up");
            button.addEventListener("click", function ()
            {
                var styling = $(currentSelectedImage).parent().children()[0];
                var stylingHtml = styling.innerHTML;

                var height = stylingHtml.substring(stylingHtml.lastIndexOf("height:") + 7, stylingHtml.lastIndexOf(";"));
                var newHeight = parseInt(height, 10) - 10 + "px";
                stylingHtml = stylingHtml.replace("height:" + height, "height: " + newHeight);
                styling.innerHTML = stylingHtml;
            });
            break;
        case "arrowDown":
            $(button).addClass("fa-arrow-down");
            button.addEventListener("click", function ()
            {
                var styling = $(currentSelectedImage).parent().children()[0];
                var stylingHtml = styling.innerHTML;

                var height = stylingHtml.substring(stylingHtml.lastIndexOf("height:") + 7, stylingHtml.lastIndexOf(";"));
                var newHeight = parseInt(height, 10) + 10 + "px";
                stylingHtml = stylingHtml.replace("height:" + height, "height: " + newHeight);
                styling.innerHTML = stylingHtml;
            });
            break;
        case "arrowRight":
            $(button).addClass("fa-arrow-right");
            button.addEventListener("click", function ()
            {
                //WIP
               // moveImageHorizontal(10);
            });
            break;
    }
    return button;
}

/**
 * Edits an Image
 * @param {element} element
 */
function editImage(element)
{
    if (!isImageEditorOpen)
    {
        isImageEditorOpen = true;
        currentSelectedImage = element;
        $(element).addClass("selectedImage");

        var imageEditDiv = createElement("div");
        imageEditDiv.id = "imageEditDiv";
        $(imageEditDiv).addClass("ImageEditor");
        imageEditDiv.innerHTML = "Afbeelding:";
        getElementById("editorPositioner").appendChild(imageEditDiv);

        var buttonArray =
                [
                    "justifyLeft",
                    "justifyCenter",
                    "justifyRight",
                    "justifyNone",
                    "minus", "plus",
                    "arrowUp", "arrowDown",
                ];

        for (var i = 0; i < buttonArray.length; i++)
        {
            imageEditDiv.appendChild(createImageButton(buttonArray[i]));
        }
    }
}

function destroyImageEditing()
{
    var editDiv = getElementById("imageEditDiv");
    editDiv.parentNode.removeChild(editDiv);
    isImageEditorOpen = false;
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
    var editorDiv = $(".Editor");

    var linkDiv = createElement("div");
    linkDiv.id = "linkDiv";
    $(editorDiv).append(linkDiv);

    var linkName = createElement("input");
    linkName.id = "linkName";
    linkName.setAttribute("type", "text");
    linkDiv.appendChild(linkName);

    var linkInput = createElement("input");
    linkInput.setAttribute("type", "text");
    linkInput.id = "url";
    linkDiv.appendChild(linkInput);

    var linkText1 = createElement("p");
    linkText1.innerHTML = "Naam:";
    linkText1.id = "linkText1";
    linkDiv.appendChild(linkText1);

    var linkText2 = createElement("p");
    linkText2.innerHTML = "Link:";
    linkText2.id = "linkText2";
    linkDiv.appendChild(linkText2);

    var submit = createElement("button");
    submit.innerHTML = "Invoegen";
    submit.id = "linkSubmit";
    submit.onclick = function ()
    {
        insertLink(linkName.value, linkInput.value);
        linkDiv.parentNode.removeChild(linkDiv);
        isLinkWindowOpen = false;
    };
    linkDiv.appendChild(submit);
    var cancel = createElement("button");
    cancel.innerHTML = "Cancel";
    cancel.id = "linkCancel";
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
            button.className = "fa fa-align-center";
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
                if (!isLinkWindowOpen)
                {
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
 * @param {element} element
 * @param {bool} isNew
 * @param {bool} isNews
 */
function setContentEditable(element, isNew, isNews)
{
    if (!isEditorOpen)
    {
        isEditorOpen = true;
        var parent = $(element).parent();
        var elementTitle;

        if (!isNews)
        {
            element.contentEditable = true;
        }
        else
        {
            element = $(parent).children()[2];
            element.contentEditable = true;
            elementTitle = $(parent).children()[1];
            elementTitle.contentEditable = true;
        }

        currentSavedHTML = element.innerHTML;
        if (isNews)
        {
            currentSavedTitle = elementTitle.innerHTML;
        }

        var childZero = $(element).parent().children()[0];
        $(childZero).hide();
        $(childZero).removeClass("ContentEditable");
        $(element).addClass("ContentEditableOpen");
        $(element).addClass("clearFix");
        element.addEventListener("focusout", function ()
        {
            saveSelectorPoint();
        });
        if (isNews)
        {
            $(elementTitle).addClass("ContentTitle");
            elementTitle.addEventListener("focusout", function ()
            {
                saveSelectorPoint();
            });
        }

        var editorPositioner = createElement("section");
        editorPositioner.id = "editorPositioner";
        $(editorPositioner).insertBefore(parent);

        var editorDiv = createElement("div");
        $(editorDiv).addClass("Editor");
        editorPositioner.appendChild(editorDiv);

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

        var underDiv = createElement("div");
        underDiv.id = "underDiv";
        $(underDiv).insertAfter(parent);

        var saveButton = createElement("button");
        $(saveButton).addClass("EditorBottomSaveButton");
        saveButton.innerHTML = "Save";
        saveButton.addEventListener("click", function ()
        {
            if (isNew)
            {
                if (isNews)
                {
                    var visibilityButton = getElementById("visibilityButton");
                    var visibility = 1;
                    if (!visibilityButton.checked)
                    {
                        visibility = 0;
                    }
                    insertNewsTextToDatabase(visibility, element.innerHTML, elementTitle.innerHTML);
                }
            }
            else
            {
                if (isNews)
                {
                    var visibilityButton = getElementById("visibilityButton");
                    var visibility = 1;
                    if (!visibilityButton.checked)
                    {
                        visibility = 0;
                    }
                    //newsID, visibility, text, title
                    updateNewsTextToDatabase(parseInt($(parent).attr('id').replace("newsID", "")), visibility, element.innerHTML, elementTitle.innerHTML);
                }
                else
                {
                    updateTextToDatabase(element.innerHTML, parseInt(element.id.replace("textID", "")));
                }

            }
        });
        underDiv.appendChild(saveButton);

        var deleteButton;

        var cancelButton = createElement("button");
        cancelButton.innerHTML = "Cancel";
        $(cancelButton).addClass("EditorBottomCancelButton");
        cancelButton.onclick = function ()
        {
            //Delete editor and buttons
            editorDiv.parentNode.removeChild(editorDiv);

            underDiv.parentNode.removeChild(underDiv);

            //Change the element
            element.contentEditable = false;
            $(element).removeClass("ContentEditableOpen");

            var childZero = $(element).parent().children()[0];
            $(childZero).show();
            $(childZero).addClass("ContentEditable");

            if (isNews)
            {
                elementTitle.contentEditable = false;
                $(elementTitle).removeClass("ContentTitle");
            }
            isEditorOpen = false;
            element.innerHTML = currentSavedHTML;
        };
        underDiv.appendChild(cancelButton);

        if (isNews)
        {
            if (!isNew)
            {
                var deleteButton = createElement("button");
                $(deleteButton).addClass("fa fa-trash-o");
                $(deleteButton).addClass("EditorBottomDeleteButton");
                deleteButton.addEventListener("click", function ()
                {
                    deleteNewsText(parseInt($(parent).attr('id').replace("newsID", "")));
                });
                underDiv.appendChild(deleteButton);
            }

            var visibilityText = createElement("p");
            visibilityText.defaultChecked = true;
            visibilityText.innerHTML = "Zichtbaar";
            underDiv.appendChild(visibilityText);

            var visibilityButton = createElement("input");
            visibilityButton.type = "checkbox";
            var visibility = true;
            if (elementTitle.id === "0")
            {
                visibility = false;
            }
            visibilityButton.defaultChecked = visibility;
            visibilityButton.id = "visibilityButton";
            underDiv.appendChild(visibilityButton);


        }
        $(parent).append(element);
    }
}

var map = {};
document.onkeydown = document.onkeyup = function (e)
{
    var element = e.target;
    e = e || event;
    map[e.keyCode] = e.type === "keydown";
    //Redo and Undo
    if (map[17] && map[90] && map[16])
    {
        document.execCommand("redo", false);
        return false;
    }
    else if (map[17] && map[90])
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
    if (map[32] && element.className === "ContentEditableOpen")
    {
        e.preventDefault();
        markupText("insertHTML", "&#8197;");
        return false;
    }

    //Enter
    if (map[13] && element.className === "")
    {
        e.preventDefault();

    }

    if ($(element).hasClass("newsTop"))
    {
        if (map[13])
        {
            e.preventDefault();
        }

        if (element.innerHTML.length >= 45 && !map[8])
        {
            e.preventDefault();
        }
    }
};

document.onclick = function (e)
{
    e = e || event;

    var element = e.target;

    if (currentSelectedImage !== null)
    {
        if (!$(element).hasClass("selectedImage") && !$(element).hasClass("ImageEditor"))
        {
            $(currentSelectedImage).removeClass("selectedImage");
            currentSelectedImage = null;
            destroyImageEditing();
        }
    }
};

//Jquery Code
$(document).ready(function ()
{
    $(".ContentEditable").click(function (event)
    {
        if (!isEditorOpen)
        {
            var parent = $(event.target).parent();
            var elementToPass = $(parent).children()[1];

            var string = elementToPass.id.toString();
            var parentString = parent.attr('id');

            //SETS the correct editor
            if (string.indexOf("textID") !== -1)
            {
                //GENERAL TEXT EDITOR
                setContentEditable(elementToPass, false);
            }
            else if (parentString.indexOf("newNews") !== -1)
            {
                //New News editor
                setContentEditable(elementToPass, true, true);
            }
            else if (parentString.indexOf("newsID") !== -1)
            {
                //NEWS EDITOR
                setContentEditable(elementToPass, false, true);
            }

            //isEditorOpen = true;
        }
    });
});