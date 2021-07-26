(function() {
    const DAYS = 365;
    const supportedLangs = {
        'Español': 'es', // Default (without slug)
        'English (UK)': 'en', 
    };

    const switchLang = document.getElementById('switch-language');
    switchLang.addEventListener('click', () => {
        console.log('clicked switch-language');
        newLang = switchLang.dataset.lang;
        console.log('dataset.lang: ' + newLang);
        setCookie('lang', newLang, DAYS);
        redirectToLanguage(newLang);
    });
    
    const closeLangSwitcher = document.getElementById('close-language-switcher');
    closeLangSwitcher.addEventListener('click', () => {
        console.log('clicked close');
        document.body.classList.remove('show-language-switcher');
        console.log('dataset.lang: ' + closeLangSwitcher.dataset.lang);
        setCookie('lang', closeLangSwitcher.dataset.lang, DAYS);
    })

    const langList = document.querySelectorAll("#trp-floater-ls-language-list a");
    for (lang of langList) {
        lang.addEventListener('click', function(event) {
            event.preventDefault();
            setCookie('lang', supportedLangs[this.innerText], DAYS);
            window.location.href = this.href;
        })
    }
    
    function redirectToLanguage(lang) {
        const url = window.location;
        const defaultLang = supportedLangs[Object.keys(supportedLangs)[0]];
        if (lang === defaultLang) {
            const newPathname = url.pathname.split('/').slice(2).join('/');
            url.href = `${url.protocol}//${url.hostname}/${newPathname}${url.hash}`;
        } else {
            url.href = `${url.protocol}//${url.hostname}/${lang}${url.pathname}${url.hash}`;
        }
    }
    
    function setCookie(name, value, days) {         
        let expires = '';
        if (days) {
            let date = new Date(); 
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = `expires=${date.toUTCString()}`;
        }
        let domain = 'domain=.alisondarwin.com'; // Make cookie available in subdomains
        document.cookie = `${name}=${value};${expires};${domain};path=/`;
    }
})()
