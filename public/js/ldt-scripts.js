(function() {
    const DAYS  = 365;
    const supportedLangs = { // TODO
        'Español': 'es',
        'English (UK)': 'en', 
    };
    const url = window.location;
    const currentLang = getCurrentLang();
    const userLang = getPreferredLanguage();
    const savedLang = getCookie('lang');

    if (savedLang) {
        if (savedLang != currentLang) {
            redirectToLanguage(savedLang);
        }
    } else {
        if (currentLang != userLang) {
            docReady(displayLanguageSwitcher);
        }
    }

    docReady(attachEvents);

    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setTimeout(fn, 1); // call on next available tick
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }
    
    function attachEvents() {
        const switchLang = document.getElementById('switch-language');
        switchLang.addEventListener('click', () => {
            setCookie('lang', userLang, DAYS);
            redirectToLanguage(userLang);
        });
        
        const closeLangSwitcher = document.getElementById('close-language-switcher');
        closeLangSwitcher.addEventListener('click', () => {
            document.body.classList.remove('show-language-switcher');
            setCookie('lang', currentLang, DAYS);
        })

        const langList = document.querySelectorAll("#trp-floater-ls-language-list a");
        for (lang of langList) {
            lang.addEventListener('click', function(event) {
                event.preventDefault();
                setCookie('lang', supportedLangs[this.innerText], DAYS);
                window.location.href = this.href;
            })
        }
    }

    function getCurrentLang() {
        let currentLang = url.pathname.split('/')[1];
        
        if (!Object.values(supportedLangs).includes(currentLang)) {
            currentLang = getDefaultLang();
        }

        return currentLang;
    }

    function getPreferredLanguage() {
        let acceptedLang = (navigator.language || navigator.userLanguage).substring(0, 2);

        if (!Object.values(supportedLangs).includes(acceptedLang)) {
            if (acceptedLang === 'ca') {
                acceptedLang = 'es'; // Catalan will be treated as spanish
            } else {
                acceptedLang = 'en'; // Default language
            }
        }
       
        return acceptedLang;
    }

    function getDefaultLang() {
        return Object.values(supportedLangs)[0];
    }

    function redirectToLanguage(lang) {
        if (lang === getDefaultLang()) {
            const newPathname = url.pathname.split('/').slice(2).join('/');
            url.href = `${url.protocol}//${url.hostname}/${newPathname}${url.hash}`;
        } else {
            url.href = `${url.protocol}//${url.hostname}/${lang}${url.pathname}${url.hash}`;
        }
    }

    function displayLanguageSwitcher() {
        document.body.classList.add('show-language-switcher');
        document.getElementById('switch-icon').innerHTML = getSwitchIcon();
        document.getElementById('switch-msg').innerText = getSwitchMsg();
    }

    function getSwitchIcon() { // TODO
        switch( userLang ) {
            case 'es': return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="25"><g fill="#c8414b"><path d="M0 385c0 22 17 39 38 39h436c21 0 38-17 38-39v-32H0v32zM474 88H38c-21 0-38 17-38 39v32h512v-32c0-22-17-39-38-39z"/></g><path fill="#ffd250" d="M0 159h512v194H0z"/><path d="M216 256l8-34c0-3-2-6-5-6h-5c-4 0-6 3-5 6l7 34z" fill="#c8414b"/><path fill="#f5f5f5" d="M207 238h18v75h-18z"/><path fill="#fab446" d="M203 230h27v8h-27z"/><g fill="#c8414b"><path d="M185 256h45v9h-45zM230 291l-27-9v-8l27 8zM84 256l7-34c1-3-1-6-5-6h-5c-3 0-5 3-5 6l8 34z"/></g><path d="M115 230c-5 0-9 3-9 8v58c0 10 10 31 44 31s44-21 44-31v-58c0-5-4-8-9-8h-70z" fill="#f5f5f5"/><g fill="#c8414b"><path d="M150 274h-44v-36c0-5 4-8 9-8h35v44zM150 274h44v22a22 22 0 01-44 0v-22z"/></g><path d="M106 274h44v22a22 22 0 01-44 0v-22z" fill="#fab446"/><g fill="#c8414b"><path d="M141 313v-39h-9v43c4 0 7-2 9-4zM124 317v-43h-9v39c2 2 5 4 9 4z"/></g><path fill="#ffb441" d="M115 256h26v9h-26z"/><g fill="#fab446"><path d="M115 238h26v9h-26z"/><path d="M119 244h18v16h-18z"/></g><path fill="#f5f5f5" d="M75 238h18v75H75z"/><g fill="#fab446"><path d="M71 309h26v9H71zM71 230h26v8H71z"/></g><path fill="#5064aa" d="M66 318h36v9H66z"/><path fill="#fab446" d="M207 309h27v9h-27z"/><path fill="#5064aa" d="M199 318h35v9h-35z"/><path fill="#fab446" d="M124 221h53v9h-53z"/><path fill="#ffb441" d="M146 194h9v27h-9z"/><g fill="#f5f5f5"><path d="M141 207a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 9 4 4 0 000-9z"/><path d="M159 207a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 9 4 4 0 000-9z"/><path d="M177 216a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 8 4 4 0 000-8zM124 216a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 8 4 4 0 000-8z"/></g><path d="M177 291v5a4 4 0 01-9 0v-5h9m8-9h-26v14a13 13 0 0026 0v-14z" fill="#fab446"/><path d="M172 265c-5 0-9-4-9-9v-9c0-5 4-9 9-9s9 4 9 9v9c0 5-4 9-9 9z" fill="#ffa0d2"/><circle cx="150.1" cy="273.6" r="13.2" fill="#5064aa"/><path fill="#fab446" d="M146 177h9v26h-9z"/><path d="M124 221l-9-9 5-5c8-8 19-13 30-13s22 5 30 13l5 5-8 9h-53z" fill="#c8414b"/><g fill="#ffd250"><circle cx="150.1" cy="211.9" r="4.4"/><circle cx="132.4" cy="211.9" r="4.4"/><circle cx="167.7" cy="211.9" r="4.4"/></g><g fill="#c8414b"><path d="M71 256h44v9H71zM71 291l26-9v-8l-26 8z"/></g></svg>';
            case 'en': return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" width="30" height="15"><clipPath id="a"><path d="M0 0v30h60V0z"/></clipPath><clipPath id="b"><path d="M30 15h30v15zv15H0zH0V0zV0h30z"/></clipPath><g clip-path="url(#a)"><path d="M0 0v30h60V0z" fill="#012169"/><path d="M0 0l60 30m0-30L0 30" stroke="#fff" stroke-width="6"/><path d="M0 0l60 30m0-30L0 30" clip-path="url(#b)" stroke="#C8102E" stroke-width="4"/><path d="M30 0v30M0 15h60" stroke="#fff" stroke-width="10"/><path d="M30 0v30M0 15h60" stroke="#C8102E" stroke-width="6"/></g></svg>';
        }
    }

    function getSwitchMsg() { // TODO
        switch( userLang ) {
            case 'es': return 'Quieres ir a la página web en español?';
            case 'en': return 'Do you want to switch to the English website?';
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

    function getCookie(name) {
        name += '=';
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (c of ca) {
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return '';
    }

})();
