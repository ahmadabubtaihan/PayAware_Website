// هذا الملف يحتوي على وظائف جافا سكريبت لإدارة التنقل في لوحة المدين

document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    const notifBtn = document.querySelector('[onclick="toggleNotifications(event)"]');
    const dropdown = document.getElementById('notifications-dropdown');
    const wrapper = document.getElementById('notifications-wrapper');
    if (notifBtn) {
        notifBtn.onclick = function(event) {
            event.stopPropagation();
            dropdown.classList.toggle('hidden');
        };
    }
    document.addEventListener('click', function(event) {
        if (dropdown && !dropdown.classList.contains('hidden')) {
            if (wrapper && !wrapper.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });
});