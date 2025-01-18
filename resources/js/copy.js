'use strict';

(() => {

    // === DOM & VARS ===
    const DOM = {};
    // === INIT =========

    const init = () => {
        copyByClick()


    }

    // === EVENTS / XHR =======

    let createToastMessage = () => {
        let div = document.createElement('div');

        div.id = 'toast';
        div.style.backgroundColor = '#14b8a6';
        div.style.color = '#fff';
        div.style.textAlign = 'center';
        div.style.maxWidth = '400px';
        div.style.padding = '17px 34px';
        div.style.position = 'fixed';
        div.style.left = '50%';
        div.style.bottom = '50px';
        div.style.marginLeft = '-200px';
        div.style.borderRadius = '50px';
        div.style.boxShadow = "1px 1px 3px #333";
        div.style.zIndex = '1000';
        div.style.visibility = 'hidden';

        div.innerText = 'Snippet in die Zwischenablage kopiert.';
        document.querySelector('body').append(div);

        return div;
    }

    // === FUNCTIONS ====
    let copyByClick = () => {

        Array.from(document.querySelectorAll('code')).forEach((element) => {
            element.addEventListener('click', (event) => {
                event.preventDefault();
                navigator.clipboard.writeText(event.target.innerText).then(() => {
                    let element = createToastMessage();
                    element.style.visibility = 'visible';

                    setTimeout(() => {
                        element.style.visibility = 'hidden';
                    }, 3000);
                });
            });
        })
    }
    init();

})();
