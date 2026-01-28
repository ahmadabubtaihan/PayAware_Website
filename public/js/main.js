        lucide.createIcons();
        
        // زر القائمة على الهاتف 
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        if(menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('open');
            });
        }

        // لمربع البحث 
        function toggleSearch() {
            const searchBox = document.getElementById('search-box');
            if(searchBox) {
                searchBox.classList.toggle('expanded');
                if (searchBox.classList.contains('expanded')) {
                    searchBox.querySelector('input').focus();
                }
            }
        }

        // خاصة بصفحة ال F&Q
     // لاظهار الاجابة او لا 
        function toggleFaq(element) {
            const allFaqs = document.querySelectorAll('.faq-item');
            allFaqs.forEach(faq => {
                if (faq !== element) {
                    faq.classList.remove('active');
                }
            });
            element.classList.toggle('active');
        }
