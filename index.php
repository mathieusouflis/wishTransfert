<?php
global $errors;
$errors = [];
require_once './controllers/AuthController.php';
AuthController::needLog();

require_once "./controllers/FileController.php";

require_once "0 FRONT/base/header.php";
require_once "0 FRONT/composents/buttons.php";
require_once "0 FRONT/composents/input.php";
require_once "./0 FRONT/composents/errorModal.php";
errorModal($errors);
?>

<div class="absolute bg-white w-332 top-200 left-10 radius-20 p-10 ">
    <form method="post" class="flex flex-col gap-16" enctype="multipart/form-data">
        <label for="file-to-upload" class="pointer">
            <?php  bigButton("plus", "Add File", "button", style: "pointer-events-none", other: "multiple required"); ?>
        </label>
        <input type="file" name="file-to-upload[]" id="file-to-upload" multiple="multiple" class="opacity-0 absolute w-px h-px">
        <div class="flex flex-col w-full gap-10 max-h-300">
            <div  class="w-full py-4 gap-10 border-bottom-1"><span class="text-black text-20">Files</span></div>
            <div id="fileList" class="overflow-y-scroll flex flex-col gap-20">
                <p class="no-files-message text-black">No files yet...</p>
            </div>
        </div>
        <?php input("email", "Saisissez un email", "email", required: true); ?>
        <?php mediumButtonWithIcon("link", "Get a link", "submit", other: 'name="upload-file"'); ?>
    </form>
</div>

<script>
    function formatSize(bytes) {
        if (bytes === 0) return '0 B';
        
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    const fileSpace = document.querySelector("#fileList");
    const fileInput = document.querySelector("form input[type='file']");
    
    let allFiles = new DataTransfer();
    
    fileInput.addEventListener("change", (e) => {
        let newFiles = e.target.files;
        
        for (let i = 0; i < newFiles.length; i++) {
            allFiles.items.add(newFiles[i]);
        }
        
        fileInput.files = allFiles.files;
        
        const fileMessage = document.querySelector(".no-files-message");
        if (fileMessage && allFiles.files.length > 0) {
            fileMessage.remove();
        }
        
        updateFileList();
    });
    
    function updateFileList() {
        const files = allFiles.files;
        const fileMessage = document.querySelector(".no-files-message");
        const existingFiles = fileSpace.querySelectorAll("div");

        existingFiles.forEach(file => file.remove());
        
        if (files.length === 0) {
            if (!fileMessage) {
                const newMessage = document.createElement("p");
                newMessage.className = "no-files-message text-black";
                newMessage.innerHTML = "No files yet...";
                fileSpace.appendChild(newMessage);
            }
            return;
        } else {
            if (fileMessage) {
                fileMessage.remove();
            }
        }
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const newFile = document.createElement("div");

            newFile.className = "flex flex-row justify-between bg-white";
            
            newFile.innerHTML = `
                <span class="text-15 text-black w-1-2">${file.name}</span>
                <div class="flex flex-row gap-10">
                    <span class="text-15 text-black">${formatSize(file.size)}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="delete-${i}" width="13px" height="13px" viewBox="0 0 13 13" fill="none" style="cursor: pointer;">
                        <path d="M2.70831 10.2917L10.2916 2.70831" stroke="black" stroke-width="1.15104" stroke-linecap="round"/>
                        <path d="M10.2917 10.2917L2.70831 2.70831" stroke="black" stroke-width="1.15104" stroke-linecap="round"/>
                    </svg>
                </div>
            `;
            
            newFile.querySelector(`.delete-${i}`).addEventListener('click', () => {
                const newDataTransfer = new DataTransfer();
                const filesArray = Array.from(files);
                
                filesArray.splice(i, 1);
                filesArray.forEach(file => newDataTransfer.items.add(file));
                allFiles = newDataTransfer;
                fileInput.files = allFiles.files;
                
                updateFileList();
            });
            
            fileSpace.appendChild(newFile);
        }
    }
</script>


<?php
require_once "0 FRONT/base/footer.php";