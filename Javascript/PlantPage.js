
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
        createManager(false, plantDiv);
    });
    plantDiv.appendChild(addButton);
}

function deleteEditing()
{
    var deleteBttn;
    var changeBttn;
    
    if(getElementById("plantDeleteButton"))
    {
        deleteBttn = getElementById("plantDeleteButton");
        deleteBttn.parentNode.removeChild(deleteBttn);
    }
    
    if(getElementById("plantChangeButton"))
    {
       changeBttn = getElementById("plantChangeButton");
       changeBttn.parentNode.removeChild(changeBttn);
    }   
}

function loadEditing(elementId)
{
    var parent = $('#ImageFrame').parent();

    if ($(parent).hasClass("2"))
    {
        var deleteButton = createElement("div");
        deleteButton.id = "plantDeleteButton";
        $(deleteButton).addClass("fa");
        $(deleteButton).addClass("deleteButton");
        $(deleteButton).addClass("fa-trash");
        $(parent).append(deleteButton);
    }

    var changeButton = createElement("div");
    changeButton.id = "plantChangeButton";
    $(changeButton).addClass("fa");
    $(changeButton).addClass("changeButton");
    $(changeButton).addClass("fa-pencil-square-o");
    $(parent).append(changeButton);
}