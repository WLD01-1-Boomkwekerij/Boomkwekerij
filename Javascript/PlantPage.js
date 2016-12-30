
function addPlantImage(element)
{
    var plantDiv = createElement("div");
    plantDiv.id = "plantDiv";
    document.body.appendChild(plantDiv);
    
    var buttonAddImage = createElement("button");
    buttonAddImage.innerHTML = "Voeg toe";
    buttonAddImage.id = "buttonAddPlant";
    buttonAddImage.addEventListener("click", function ()
    {
        
    });
    plantDiv.appendChild(buttonAddImage);
    
    var addButton = createElement("button");
    addButton.innerHTML = "Voeg foto toe";
    addButton.addEventListener("click", function()
    {
        createManager(false, plantDiv);
    });
    plantDiv.appendChild(addButton);

    
    
}