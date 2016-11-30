//Variables

//Saved Selection
var savedSelectorPoint;

/**
 * Inserts markup with execCommand
 * @param {type} type
 * @param {type} parameter
 */
function markupText(type, parameter) {

    if (arguments.length === 1) {
        document.execCommand(type, false);
    } else {
        document.execCommand(type, false, parameter);
    }
}

/**
 * Saves the provided text to the database
 * @param {type} text
 * @param {type} textID
 */
function saveTextToDatabase(text, textID) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/XMLRequest.php?htmlText=" + text + "&textID=" + textID, true);
    xmlhttp.send();
}

function createButton(type) {

    var button = document.createElement("button");

    switch (type) {
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

    switch (type) {
        case "image":
            button.onclick = function () {
                // insertImage();
            };
            break;
        case "link":
            button.onclick = function () {
                createLink();
            };
            break;
        default:
            button.onclick = function () {
                markupText(type);
            };
            break;
    }

    return button;
}

function createLink() {

    var editorDiv = document.getElementById("Editor");

    var linkInput = document.createElement("input");
    linkInput.setAttribute("type", "text");
    linkInput.id = "url";
    linkInput.style.position = "absolute";
    linkInput.style.left = "175px";
    linkInput.style.top = "-30px";
    linkInput.style.border = "solid 3px red";
    linkInput.style.boxShadow = "0px 0px 5px 3px black";
    editorDiv.appendChild(linkInput);

    var submit = document.createElement("button");
    submit.innerHTML = "Invoegen";
    submit.style.position = "absolute";
    submit.style.left = "350px";
    submit.style.top = "-30px";
    submit.onclick = function () {
        insertLink();
        linkInput.parentNode.removeChild(linkInput);
        submit.parentNode.removeChild(submit);
    };
    editorDiv.appendChild(submit);
}

/**
 * Sets the clicked element editable and adds the editing system
 * @param {type} element
 */
function setContentEditable(element) {
    element.contentEditable = true;
    element.style.backgroundColor = "white";
    element.className = "";
    element.addEventListener("focusout", saveSelectorPoint());

    var parent = element.parentNode;

    var editorDiv = document.createElement("div");
    editorDiv.id = "Editor";
    editorDiv.style.position = "relative";
    parent.insertBefore(editorDiv, parent.childNodes[0]);

    //Buttons
    var buttonArray = [
        "bold", "italic", "underline",
        "justifyLeft", "justifyCenter", "justifyRight",
        "insertOrderedList", "insertUnorderedList",
        "link", "image"
    ];

    for (var i = 0; i < buttonArray.length; i++) {
        editorDiv.appendChild(createButton(buttonArray[i]));
    }


    var saveButton = document.createElement("button");
    saveButton.innerHTML = "Save";
    saveButton.onclick = function () {
        saveTextToDatabase(element.innerHTML, parseInt(element.id.replace("textID", "")));
        //window.location.reload(false);
    };

    document.body.appendChild(saveButton);
}

/**
 * Save the current position of the cursor when called
 */
function saveSelectorPoint() {
    if (window.getSelection) {
        var sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            var ranges = [];
            for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                ranges.push(sel.getRangeAt(i));
            }
            savedSelectorPoint = ranges;
        }
    } else if (document.selection && document.selection.createRange) {
        savedSelectorPoint = document.selection.createRange();
    }
}

function restoreSelectorPoint(savedSel) {
    if (savedSel) {
        if (window.getSelection) {
            var sel = window.getSelection();
            sel.removeAllRanges();
            for (var i = 0, len = savedSel.length; i < len; ++i) {
                sel.addRange(savedSel[i]);
            }
        } else if (document.selection && savedSel.select) {
            savedSel.select();
        }
    }
}

/**
 * Inserts a link at a saved cursor position
 */
function insertLink() {

    var url = document.getElementById("url").value;
    restoreSelectorPoint(savedSelectorPoint);
    document.execCommand("CreateLink", false, url);
}

//Get image url from database
function selectImage(imageID) {

    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "../PHP/GetImages.php?imageList=" + imageID, true);
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            //Create image
            var img = document.createElement("img");
            img.src = "../images/" + xhttp.responseText;
            img.className = "editableImage";
            img.style.width = "300px";
            img.style.border = "solid 2px black";
            //img.onclick = function () {
            //    editImage(this);
            //  };
            document.body.appendChild(img);
        }
    };
    xhttp.send();
}

var map = {};
document.onkeydown = document.onkeyup = function (e) {
    e = e || event;
    map[e.keyCode] = e.type === "keydown";

    //Redo and Undo
    if (map[17] && map[90] && map[16]) {
        document.execCommand("redo", false);
        return false;
    } else if (map[17] && map[90]) {
        document.execCommand("undo", false);
        return false;
    }

    //Enter
    if (map[13]) {
        //  markupText("insertHTML", "<br><br>");
        //  return false;
    }
    //Tab
    if (map[9]) {
        markupText("insertHTML", "&emsp;");
        return false;
    }
};

//Jquery Code
$(document).ready(function () {

    $(".ContentEditable").one("click", function () {
        setContentEditable($(this)[0]);
    });
});