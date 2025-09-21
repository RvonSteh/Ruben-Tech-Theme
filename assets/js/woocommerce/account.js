document.addEventListener('DOMContentLoaded', () => {
    const tabs = ['downloads', 'orders', 'edit-address', 'edit-account'];
    const currentUrl = window.location.pathname;

    console.log(currentUrl);

    const isTabInUrl = tabs.some(tab => currentUrl.includes(tab));
    const section = document.querySelector('#my-account-content');

    if (isTabInUrl) {
        section.scrollIntoView({ behavior: 'smooth' });
    }

    const navTabs = document.querySelectorAll('.woocommerce-MyAccount-navigation li');
    const firstTab = document.querySelector('.woocommerce-MyAccount-navigation li:first-of-type');

    let activeTabFound = false;

    navTabs.forEach(tab => {
        if (currentUrl.includes(tab.classList)) {
            tab.classList.add('active');
            activeTabFound = true; 
        }
    });
    
    if (!activeTabFound && firstTab) {
        firstTab.classList.add('active');
    }

});
