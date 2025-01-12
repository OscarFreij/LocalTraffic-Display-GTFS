
document.getElementById('createScreenForm').addEventListener('submit', function(event) {
    //event.preventDefault();


    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = "stop_queue";
    hiddenInput.value = JSON.stringify(ReadComponents());
    this.appendChild(hiddenInput);

    // The form will now submit with the added hidden fields
});


const selectElement = document.querySelector("#addRow");

selectElement.addEventListener("click", (event) => {
    let templateNode = document.getElementById('rowTemplate').cloneNode(true);
    document.getElementById('icTableBody').appendChild(templateNode);
});


function ReadComponents() {
    let rows = document.getElementById('icTableBody').children;

    let objs = new Array;

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        let numericInputs = row.getElementsByTagName('input');
        let selectionInputs = row.getElementsByTagName('select');

        let obj = new Object;
        if (numericInputs[0].value != "")
        {
            obj.stop_id = numericInputs[0].value;
            obj.travle_time = numericInputs[1].value;
            obj.combine_children = selectionInputs[0].value;
            obj.enabled = selectionInputs[1].value;
            obj.order = numericInputs[2].value;
            objs.push(obj);
        }
    }
    return objs;
}