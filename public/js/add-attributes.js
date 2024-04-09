document.getElementById("add-attribute").addEventListener("click", function () {
    var paramsDiv = document.getElementById("attribute");
    var paramInput = document.createElement("div");
    paramInput.classList.add("mt-1", "flex", "items-center");
    paramInput.innerHTML = `
        <input type="text" name="attribute_name[]" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 sm:text-sm border-gray-300 rounded-md" placeholder="Parameter name" required">
        <input type="text" name="attribute_value[]" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 sm:text-sm border-gray-300 rounded-md ml-2" placeholder="Parameter value" required">
        <button type="button" class="px-2 py-1 bg-red-500 text-white rounded-md ml-2" onclick="this.parentNode.remove()">Remove</button>
    `;
    paramsDiv.appendChild(paramInput);
});
