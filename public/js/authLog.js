/* public/js/authLog.js */

document.addEventListener('DOMContentLoaded', function() {
    // تفعيل أيقونات Lucide في جميع صفحات المصادقة
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

/**
 * وظيفة تبديل الأدوار في صفحة التسجيل (Register)
 * @param {string} role - 'debtor' أو 'creditor'
 */
function setRole(role) {
    const creditorBtn = document.getElementById('btn-creditor');
    const debitBtn = document.getElementById('btn-debit');
    const creditorFields = document.getElementById('creditor-fields');
    const roleInput = document.getElementById('role_input');
    
    if (!roleInput || !creditorBtn || !debitBtn) return;

    roleInput.value = role;

    const activeClasses = ['bg-white', 'text-teal-700', 'shadow-sm', 'ring-1', 'ring-black/5'];
    const inactiveClasses = ['text-slate-500', 'hover:text-slate-700', 'hover:bg-white/50'];

    if (role === 'creditor') {
        creditorBtn.classList.add(...activeClasses);
        creditorBtn.classList.remove(...inactiveClasses);
        
        debitBtn.classList.remove(...activeClasses);
        debitBtn.classList.add(...inactiveClasses);
        
        if (creditorFields) {
            creditorFields.classList.remove('hidden');
            creditorFields.classList.add('grid');
        }
    } else {
        debitBtn.classList.add(...activeClasses);
        debitBtn.classList.remove(...inactiveClasses);
        
        creditorBtn.classList.remove(...activeClasses);
        creditorBtn.classList.add(...inactiveClasses);
        
        if (creditorFields) {
            creditorFields.classList.add('hidden');
            creditorFields.classList.remove('grid');
        }
    }
}