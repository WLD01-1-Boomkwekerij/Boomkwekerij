
function createElement(element)
{
    return document.createElement(element);
}

function getElementById(id)
{
    return document.getElementById(id);
}

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
        var one = getElementById("Name");
        var two = getElementById("groep");
        var three = getElementById("hoogte_min");
        var four = getElementById("hoogte_max");
        var five = getElementById("bloeitijd");
        var six = getElementById("bloeiwijze");
        var seven = getElementById("");
        
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "../PHP/XMLRequest.php?"+
                "name="+one+
                "&groep="+two+
                "&hoogte_min="+three+
                "&hoogte_max="+four+
                "&bloeitijd="+five+
                "&bloeiwijze="+six+
                "&="+seven, true);
        
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200)
            {
               console.log(xmlhttp.responseText);
            }
        };
        
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
        
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200)
            {
                var optionArray = xmlhttp.responseText.split("*");
                
                for(var i = 0; i < optionArray.length - 1; i+= 2)
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
    
}