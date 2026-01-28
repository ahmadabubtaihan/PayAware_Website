
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

function openCalculator() { 
    const modal = document.getElementById('calculatorModal');
    if(!modal) return;
    modal.classList.remove('hidden');
    const content = modal.querySelector('div');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeCalculator() { 
    const modal = document.getElementById('calculatorModal');
    if(!modal) return;
    const content = modal.querySelector('div');
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => { modal.classList.add('hidden'); }, 300);
}

function calculateInstallment() {
    const total = parseFloat(document.getElementById('totalAmount').value) || 0;
    const down = parseFloat(document.getElementById('downPayment').value) || 0;
    const months = parseFloat(document.getElementById('months').value) || 1;

    if (total > 0 && months > 0) {
        const monthly = (total - down) / months;
        const resultDiv = document.getElementById('calcResult');
        document.getElementById('monthlyResult').innerText = '$' + monthly.toFixed(2);
        if(resultDiv) resultDiv.classList.remove('hidden');
    }
}

function showSection(sectionId) {
    const sections = ['profile', 'security', 'notifications'];
    sections.forEach(s => {
        const el = document.getElementById(s + '-section');
        const btn = document.getElementById('btn-' + s);
        if (el) el.classList.add('hidden');
        if (btn) {
            btn.classList.remove('text-teal-600', 'font-bold');
            btn.classList.add('text-slate-600', 'font-medium');
        }
    });

    document.getElementById(sectionId + '-section').classList.remove('hidden');
    const activeBtn = document.getElementById('btn-' + sectionId);
    activeBtn.classList.add('text-teal-600', 'font-bold');
}

function toggleComments(id) {
    const section = document.getElementById('comments-section-' + id);
    if(section) section.classList.toggle('hidden');
}

function openEditProfileModal() {
    const modal = document.getElementById('editProfileModal');
    if(modal) modal.classList.remove('hidden');
}