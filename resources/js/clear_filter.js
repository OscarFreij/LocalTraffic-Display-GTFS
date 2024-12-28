import { formToJSON } from "axios";

const selectElement = document.querySelector(".filter-reset-btn");

selectElement.addEventListener("click", (event) => {
    clearFilter();
});

function clearFilter()
{
    console.log('Filter Reset!');
    let children = selectElement.parentNode.parentNode.children;
    for (let i = 0; i < children.length; i++) {
        const element = children[i];

        const inputElements = element.querySelectorAll("input");
        const selectElements = element.querySelectorAll("select");

        for (let j = 0; j < inputElements.length; j++) {
            let element2 = inputElements[j];
            console.log(element2);
            element2.setAttribute('value', "");
        }

        for (let j = 0; j < selectElements.length; j++) {
            let element2= selectElements[j];
            console.log(element2);
            for (let k = 0; k < element2.length; k++) {
                let element3 = element2[k];
                element3.removeAttribute('selected');
            }
        }
    }
    selectElement.parentElement.parentElement.submit();
}