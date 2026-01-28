

// هذا الملف يحتوي على وظائف جافا سكريبت لإدارة التنقل في لوحة الادمن

document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const menuBtn = event.target.closest('button');
        
        if (window.innerWidth < 768 && sidebar && !sidebar.contains(event.target) && (!menuBtn || !menuBtn.getAttribute('onclick')?.includes('toggleSidebar'))) {
            if (!sidebar.classList.contains('hidden')) {
                toggleSidebar();
            }
        }
    });
});


function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    sidebar.classList.toggle('hidden');
    sidebar.classList.toggle('absolute');
    sidebar.classList.toggle('h-full');
    sidebar.classList.toggle('w-64');
}