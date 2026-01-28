
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') { lucide.createIcons(); }
    
    const savedTab = localStorage.getItem('activeSettingsTab');
    if(savedTab && document.getElementById(savedTab + '-section')) {
        showSection(savedTab);
    }
});

function toggleModal(modalID) {
    const modal = document.getElementById(modalID);
    if(modal) modal.classList.toggle("hidden");
}

window.onclick = function(event) {
    if (!event.target.closest('.relative')) {
        document.querySelectorAll('[id^="post-menu-"]').forEach(el => el.classList.add('hidden'));
    }
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
}

function openReminderModal(name, id) {
    const nameDisplay = document.getElementById('modalDebtorNameDisplay');
    if(nameDisplay) nameDisplay.innerText = name;
    const idInput = document.getElementById('warningDebtorId');
    if(idInput) idInput.value = id;
    toggleModal('warningModal');
}

function openPaymentModal(id) {
    const idInput = document.getElementById('paymentDebtorId');
    if(idInput) idInput.value = id;
    toggleModal('addPaymentModal');
}

function showSection(sectionId) {
    const sections = ['general', 'billing', 'team', 'security'];
    sections.forEach(id => {
        const section = document.getElementById(id + '-section');
        if(section) section.classList.add('hidden');
        const btn = document.getElementById('btn-' + id);
        if(btn) {
            btn.classList.remove('text-teal-600', 'font-bold', 'bg-teal-50');
            btn.classList.add('text-slate-600', 'font-medium', 'bg-white');
        }
    });
    const activeSection = document.getElementById(sectionId + '-section');
    if(activeSection) activeSection.classList.remove('hidden');
    const activeBtn = document.getElementById('btn-' + sectionId);
    if(activeBtn) {
        activeBtn.classList.remove('text-slate-600', 'font-medium', 'bg-white');
        activeBtn.classList.add('text-teal-600', 'font-bold', 'bg-teal-50');
    }
    localStorage.setItem('activeSettingsTab', sectionId);
}

function clearImage() {
    const input = document.getElementById('post-image-input');
    if(input) input.value = '';
    document.getElementById('file-preview')?.classList.add('hidden');
}

function toggleOffer() {
    const checkbox = document.getElementById('post-offer-input');
    const btn = document.getElementById('offer-btn');
    if(!checkbox || !btn) return;
    checkbox.checked = !checkbox.checked;
    if (checkbox.checked) {
        btn.classList.remove('text-slate-500');
        btn.classList.add('text-red-500', 'bg-red-50', 'px-3', 'py-1', 'rounded-lg');
    } else {
        btn.classList.add('text-slate-500');
        btn.classList.remove('text-red-500', 'bg-red-50', 'px-3', 'py-1', 'rounded-lg');
    }
}