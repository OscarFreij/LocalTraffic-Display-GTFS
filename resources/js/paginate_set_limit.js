//const selectElement = document.querySelector(".paginatorLimitSelector");
const selectedElements = document.querySelectorAll(".paginatorLimitSelector");
selectedElements.forEach(element => {
    element.addEventListener("change", (event) => {
        updateLimit(event);
    });
});


function updateLimit(event)
{
    var url = new URL(location.href);
    url.searchParams.set('limit', event.target.value);
    window.location.replace(url);
}


document.addEventListener('submit', (event) => {
    event.preventDefault();
    var url = new URL(location.href);
    var cLimit = url.searchParams.get('limit');
    if (cLimit != null)
    {
        var limitElement = document.createElement('input');
        limitElement.setAttribute('type', 'hidden');
        limitElement.setAttribute('name', 'limit');
        limitElement.setAttribute('value', cLimit);
        event.target.appendChild(limitElement);
    }
    event.target.submit();
});