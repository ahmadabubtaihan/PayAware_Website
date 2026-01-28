
document.addEventListener('DOMContentLoaded', function () {
    
    const triggerBtn = document.getElementById('trigger-upload-btn');
    const fileInput = document.getElementById('attachment_input');
    const clearBtn = document.getElementById('clear-file-btn');
    const previewDiv = document.getElementById('file-preview');
    const fileNameSpan = document.getElementById('file-name');

    if (triggerBtn && fileInput) {
        triggerBtn.addEventListener('click', function (e) {
            e.preventDefault();
            fileInput.click();
        });
    }

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                fileNameSpan.textContent = this.files[0].name;
                previewDiv.classList.remove('hidden');
                previewDiv.classList.add('flex');
            }
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function (e) {
            e.preventDefault();
            fileInput.value = '';
            previewDiv.classList.add('hidden');
            previewDiv.classList.remove('flex');
        });
    }

    const messagesContainer = document.getElementById('messages-container');
    if(messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    const chatInput = document.querySelector('textarea[name="message"]');
    if (chatInput) {
        chatInput.addEventListener('input', function() {
            this.style.height = '';
            this.style.height = this.scrollHeight + 'px';
        });
    }
});