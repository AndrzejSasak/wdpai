clothingParts = document.querySelectorAll('div.clothing-part img');
clothingPartItems = [].slice.call(clothingParts);
console.log(clothingPartItems);

let elementsToDelete = [];

function markValidation(element) {
    if(element.classList.contains('to-delete')) {
        elementsToDelete = elementsToDelete.filter(function(e) { return e !== element});
        element.classList.remove('to-delete');
    } else {
        elementsToDelete.push(element);
        element.classList.add('to-delete');
    }
}

function selectImage() {
    markValidation(this);
    console.log(elementsToDelete);
}

for(let i = 0; i < clothingPartItems.length; i++) {
    let item = clothingPartItems[i];
    console.log(item);
    item.addEventListener('click', selectImage);
}

deleteButton = document.getElementById('deleteButton');
deleteButton.addEventListener("click", function(event) {
    event.preventDefault();

    elementsToDelete = elementsToDelete.map(element => element.src);
    console.log(elementsToDelete)
    const data = elementsToDelete;

    fetch("/delete", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    })

});