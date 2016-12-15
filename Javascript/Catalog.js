
function createElement(element)
{
    return document.createElement(element);
}

function getElementById(id)
{
    return document.getElementById(id);
}

function addSelectorImage()
{
    
}

function createAddButton()
{
    var addButton = createElement("button");
    addButton.id = "addButton";
    addButton.className = "fa fa-plus";
    addButton.style.height = "22px";
    addButton.addEventListener("click", addSelectorImage());    
    getElementById("catalogPhotoUrl").appendChild(addButton);
}

function createInput(name, placeHolder)
{
    var inputName = createElement("p");
    inputName.class += "catalogAddingName";
    inputName.innerHTML = name;
    getElementById("elementOne").appendChild(inputName);
    
    var input = createElement("input");
    input.class = "catalogAddingInput";
    input.name = name;
    input.placeholder = placeHolder;
    getElementById("elementTwo").appendChild(input);
}

function createCatalogAddition()
{
    var section = createElement("section");
    section.id = "addPlantMenu";
    section.style.boxShadow = "0px 0px 20px 5px black";
    getElementById("mid").appendChild(section);
    
    var topDiv = createElement("div");
    topDiv.style.height = "30px";
    topDiv.style.width = "100%";
    topDiv.style.backgroundColor = "#8D99C8";
    topDiv.style.borderBottom = "solid 1px gray";
    section.appendChild(topDiv);
        
    var buttonAddPlant = createElement("button");
    buttonAddPlant.innerHTML = "Voeg toe";
    buttonAddPlant.style.float = "right";
    buttonAddPlant.style.marginTop = "5px";
    buttonAddPlant.style.marginRight = "5px";
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
    rightDiv.style.height = "100%";
    rightDiv.style.float = "right";
    rightDiv.style.marginTop = "10px";
    sectionDiv.appendChild(rightDiv); 
    
    var leftDiv = createElement("div");
    leftDiv.id = "elementOne";
    leftDiv.style.width = "40%";
    leftDiv.style.height = "100%";
    leftDiv.style.marginTop = "10px";
    sectionDiv.appendChild(leftDiv);    
    
      
    //SELECT en SQL
    
    createInput("Naam:", "Naam");
    createInput("Min.Hoogte:", "Hoogte (in cm)");
    createInput("Max.Hoogte:", "Hoogte (in cm)");
    createInput("Bloeitijd:", "Maand");
    createInput("Bloeiwijze:", "Bloeiwijze");
    
    
    
}