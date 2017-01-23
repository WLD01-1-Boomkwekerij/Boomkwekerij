
/**
 * Sends an array for php to process
 * @param {string} GetArray
 */
function doXMLHttp(GetArray)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/XMLRequest.php?" + GetArray, true);
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
                location.reload();
            }
        }
    };
    xmlhttp.send();
}

/**
 * 
 * @param {type} element
 */
function addPlantImage(element)
{
    createManager("PlantPageMultipleInput", element);
}

function editPlantImage(element)
{
    createManager("PlantPageSingleInput", element);
}

/**
 * Deletes the editing buttons on the side
 */
function deleteEditing()
{
    var deleteBttn;
    var changeBttn;

    if (getElementById("plantDeleteButton"))
    {
        deleteBttn = getElementById("plantDeleteButton");
        deleteBttn.parentNode.removeChild(deleteBttn);
    }

    if (getElementById("plantChangeButton"))
    {
        changeBttn = getElementById("plantChangeButton");
        changeBttn.parentNode.removeChild(changeBttn);
    }
}

/**
 * creates the editing buttons on the side
 */
function loadEditing()
{
    var parent = $('#ImageFrame').parent();
    var imageFrameElement = getElementById("ImageFrame");

    if ($(parent).hasClass("2"))
    {
        var deleteButton = createElement("div");
        deleteButton.id = "plantDeleteButton";
        $(deleteButton).addClass("fa");
        $(deleteButton).addClass("fa-3x");
        $(deleteButton).addClass("deleteButton");
        $(deleteButton).addClass("plantButtonIcon");
        $(deleteButton).addClass("fa-trash");
        deleteButton.addEventListener("click", function ()
        {
            doXMLHttp("deletePlantImages=" + getElementById("ImageFrame").className);
        });
        $(parent).append(deleteButton);
    }

    var changeButton = createElement("div");
    changeButton.id = "plantChangeButton";
    $(changeButton).addClass("fa");
    $(changeButton).addClass("fa-3x");
    $(changeButton).addClass("changeButton");
    $(changeButton).addClass("plantButtonIcon");
    $(changeButton).addClass("fa-pencil-square-o");
    changeButton.addEventListener("click", function ()
    {
        editPlantImage(imageFrameElement);
    });
    $(parent).append(changeButton);
}

function firstLoad()
{
    var parent = $('#ImageFrame').parent();
    var imageFrameElement = getElementById("ImageFrame");

    var changeButton = createElement("div");
    changeButton.id = "plantChangeButton";
    $(changeButton).addClass("fa");
    $(changeButton).addClass("fa-3x");
    $(changeButton).addClass("changeButton");
    $(changeButton).addClass("plantButtonIcon");
    $(changeButton).addClass("fa-pencil-square-o");
    changeButton.addEventListener("click", function ()
    {
        editPlantImage(imageFrameElement);
    });
    $(parent).append(changeButton);
}