
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
                console.log(xmlhttp.responseText);
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
 * Creates the div for adding an image
 * @param {element} element
 */
function addPlantImage(element)
{
    var plantPositioner = createElement("div");
    plantPositioner.id = "plantPositioner";
    document.getElementById("maincontent").appendChild(plantPositioner);

    var plantDiv = createElement("div");
    plantDiv.id = "plantDiv";
    plantPositioner.appendChild(plantDiv);

    var buttonAddImage = createElement("button");
    buttonAddImage.innerHTML = "Voeg toe";
    buttonAddImage.id = "buttonAddPlant";
    buttonAddImage.addEventListener("click", function ()
    {
        var imageList = "";
        for (var i = 0; i < managerImageList.length; i++)
        {
            imageList += managerImageList[i] + "*";
        }

        doXMLHttp("addPlantImages=" + imageList + "&plantID=" + element.id);
    });
    plantDiv.appendChild(buttonAddImage);

    var addButton = createElement("button");
    addButton.innerHTML = "Voeg foto toe";
    addButton.addEventListener("click", function ()
    {
        createManager("MultipleInput", plantDiv);
    });
    plantDiv.appendChild(addButton);
}

function editPlantImage()
{    
    createManager("SingleInput");
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
        editPlantImage();
    });
    $(parent).append(changeButton);
}