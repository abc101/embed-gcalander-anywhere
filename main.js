function addCalendarIdField() {
    const container = document.getElementById('calendar-ids-container');
    const index = container.children.length;
    const inputContainer = document.createElement('div');
    inputContainer.style.marginBottom = '10px';
    inputContainer.style.display = 'flex';
    inputContainer.style.gap = '5px';
    inputContainer.style.alignItems = 'center';

    const idInput = document.createElement('input');
    idInput.type = 'text';
    idInput.name = 'multiple_calendar_ids[' + index + '][id]';
    idInput.placeholder = 'Enter Calendar ID';
    idInput.style.width = '200px';

    const colorInput = document.createElement('input');
    colorInput.type = 'color';
    colorInput.name = 'multiple_calendar_ids[' + index + '][color]';
    colorInput.value = '#000000';

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'remove-id';
    removeButton.textContent = 'Remove';
    removeButton.onclick = function() {
        inputContainer.remove();
    };

    inputContainer.appendChild(idInput);
    inputContainer.appendChild(colorInput);
    inputContainer.appendChild(removeButton);
    container.appendChild(inputContainer);
}
