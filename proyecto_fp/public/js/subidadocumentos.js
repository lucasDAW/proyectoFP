document.addEventListener('DOMContentLoaded', function() {
    function setupDragAndDropArea(areaClass) {
        const areaLabel = document.querySelector('.' + areaClass + ' label');
        const container = document.querySelector('.' + areaClass + ' > div');
        let fileInput = container.querySelector('input[type="file"]');
        const fileList = container.querySelector('ul');
        const dragDropText = container.querySelector('span');
        const selectButton = container.querySelector('button');

        function updateFileListDisplay() {
            fileList.innerHTML = '';
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const listItem = document.createElement('li');
                listItem.textContent = `${file.name.substr(0,15)}... .${file.name.split('.')[file.name.split('.').length-1]} (${(file.size / (1024*1024)).toFixed(2)} MB)`;
                const removeButton = document.createElement('span');
                removeButton.textContent = ' X';
                removeButton.classList.add('remove-file');
                removeButton.style.cursor = 'pointer';
                removeButton.style.marginLeft = '5px';
                removeButton.addEventListener('click', () => {
                    const newInput = document.createElement('input');
                    newInput.type = 'file';
                    newInput.id = fileInput.id;
                    newInput.name = fileInput.name;
                    newInput.hidden = true;
                    container.replaceChild(newInput, fileInput);
                    fileInput = newInput; // Update the fileInput reference
                    attachListeners(container, fileInput, fileList, dragDropText); // Re-attach listeners
                    fileList.innerHTML = '';
                    container.classList.remove('archivo_subido', 'mostrar_archivos');
                    dragDropText.textContent = 'Arrastra archivos';
                    areaLabel.querySelector('span').style.display = 'inline';
                });
                listItem.appendChild(removeButton);
                fileList.appendChild(listItem);
                container.classList.add('archivo_subido');
            } else {
                container.classList.remove('archivo_subido');
            }
        }

        function attachListeners(dropZone, inputElement, listElement, textElement) {
            dropZone.addEventListener('dragover', (event) => {
                event.preventDefault();
                dropZone.classList.add('dragover');
                textElement.textContent = 'Libere el archivo para cargar';
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('dragover');
                textElement.textContent = 'Arrastra archivos';
            });

            dropZone.addEventListener('drop', (event) => {
                event.preventDefault();
                dropZone.classList.remove('dragover');
                if (event.dataTransfer.files.length > 0) {
                    inputElement.files = event.dataTransfer.files;
                    updateFileListDisplay();
                    dropZone.classList.add('mostrar_archivos');
                    areaLabel.querySelector('span').style.display = 'none';
                }
            });

            inputElement.addEventListener('change', updateFileListDisplay);
        }

        if (areaLabel && container && fileInput && fileList && dragDropText && selectButton) {
            areaLabel.addEventListener('click', (event) => {
                event.preventDefault();
                container.classList.toggle('mostrar_archivos');
                areaLabel.querySelector('span').style.display = container.classList.contains('mostrar_archivos') ? 'none' : 'inline';
            });

            selectButton.addEventListener('click', (e) => {
                e.preventDefault();
                fileInput.click();
            });

            attachListeners(container, fileInput, fileList, dragDropText);
        }
    }

    if (document.querySelector('.archivos_portada')) {
        setupDragAndDropArea('archivos_portada');
        setupDragAndDropArea('archivos_archivo');
    }
});

// Basic CSS for remove button
const style = document.createElement('style');
style.textContent = `
    .remove-file {
        color: red;
        font-weight: bold;
        margin-left: 5px;
        cursor: pointer;
    }
    .mostrar_archivos {
        display: block !important; /* Ensure the div is visible when class is added */
    }
    .archivo_drag {
        border: 2px dashed blue !important;
        background-color: #f0f7ff;
    }
    .archivo_subido {
        /* Add styles to indicate a file is uploaded if needed */
    }
`;
document.head.appendChild(style);