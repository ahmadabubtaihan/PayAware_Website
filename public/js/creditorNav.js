// هذا الملف يحتوي على وظائف جافا سكريبت لإدارة التنقل في لوحة الدائن

document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

function toggleChatWidget() {
    const widget = document.getElementById('chat-widget');
    if (widget) {
        widget.classList.toggle('open');
    }
}

