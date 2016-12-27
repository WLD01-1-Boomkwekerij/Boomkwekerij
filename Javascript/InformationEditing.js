//Variables

//Saved Selection
var savedSelectorPoint;
var isLinkWindowOpen = false;
var isFileManagerOpen = false;
var isEditorOpen = false;
var currentSavedHTML;
var currentSavedTitle;

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
        createManager(false);
        isFileManagerOpen = true;
    }
}

/**
 * Creates the fileManager for the image uploading
 */
function uploadImage()
{
    if (!isFileManagerOpen)
    {
        createManager(true);
        isFileManagerOpen = true;
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

        var editorDiv = createElement("div");
        $(editorDiv).addClass("Editor");
        $(editorDiv).insertBefore(parent);

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

        var saveButton = createElement("button");
        $(saveButton).addClass("EditorBottomButton");
        saveButton.innerHTML = "Save";
        saveButton.addEventListener("click", function ()
        {
            if (isNew)
            {
                if (isNews)
                {
                    insertNewsTextToDatabase(1, element.innerHTML, elementTitle.innerHTML);
                }
            }
            else
            {
                if (isNews)
                {
                    //newsID, visibility, text, title
                    updateNewsTextToDatabase(parseInt($(parent).attr('id').replace("newsID", "")), 1, element.innerHTML, elementTitle.innerHTML);
                }
                else
                {
                    updateTextToDatabase(element.innerHTML, parseInt(element.id.replace("textID", "")));
                }

            }
        });
        $(saveButton).insertAfter(parent);

        var deleteButton;

        var cancelButton = createElement("button");
        cancelButton.innerHTML = "Cancel";
        $(cancelButton).addClass("EditorBottomButton");
        cancelButton.onclick = function ()
        {
            //Delete editor and buttons
            editorDiv.parentNode.removeChild(editorDiv);
            saveButton.parentNode.removeChild(saveButton);
            cancelButton.parentNode.removeChild(cancelButton);

            if (isNews && !isNew)
            {
                deleteButton.parentNode.removeChild(deleteButton);
            }

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
        $(cancelButton).insertAfter(saveButton);

        if (isNews && !isNew)
        {
            var deleteButton = createElement("button");
            $(deleteButton).addClass("fa fa-trash-o");
            $(deleteButton).addClass("EditorBottomButton");
            deleteButton.addEventListener("click", function ()
            {
                deleteNewsText(parseInt($(parent).attr('id').replace("newsID", "")));
            });
            $(deleteButton).insertAfter(cancelButton);
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