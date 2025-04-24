/*==================== SHOW MENU ====================*/
const showMenu = (toggleId, navId) =>{
    const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId)
    
    // Validate that variables exist
    if(toggle && nav){
        toggle.addEventListener('click', ()=>{
            // We add the show-menu class to the div tag with the nav__menu class
            nav.classList.toggle('show-menu')
        })
    }
}
showMenu('nav-toggle','nav-menu')

/*==================== REMOVE MENU MOBILE ====================*/
const navLink = document.querySelectorAll('.nav__link')

function linkAction(){
    const navMenu = document.getElementById('nav-menu')
    // When we click on each nav__link, we remove the show-menu class
    navMenu.classList.remove('show-menu')
}
navLink.forEach(n => n.addEventListener('click', linkAction))

/*==================== SCROLL SECTIONS ACTIVE LINK ====================*/
const sections = document.querySelectorAll('section[id]')

function scrollActive(){
    const scrollY = window.pageYOffset

    sections.forEach(current =>{
        const sectionHeight = current.offsetHeight
        const sectionTop = current.offsetTop - 50;
        sectionId = current.getAttribute('id')

        if(scrollY > sectionTop && scrollY <= sectionTop + sectionHeight){
            document.querySelector('.nav__menu a[href*=' + sectionId + ']').classList.add('active-link')
        }else{
            document.querySelector('.nav__menu a[href*=' + sectionId + ']').classList.remove('active-link')
        }
    })
}
window.addEventListener('scroll', scrollActive)

/*==================== CHANGE BACKGROUND HEADER ====================*/ 
function scrollHeader(){
    const nav = document.getElementById('header')
    // When the scroll is greater than 200 viewport height, add the scroll-header class to the header tag
    if(this.scrollY >= 200) nav.classList.add('scroll-header'); else nav.classList.remove('scroll-header')
}
window.addEventListener('scroll', scrollHeader)

/*==================== SHOW SCROLL TOP ====================*/ 
function scrollTop(){
    const scrollTop = document.getElementById('scroll-top');
    // When the scroll is higher than 560 viewport height, add the show-scroll class to the a tag with the scroll-top class
    if(this.scrollY >= 560) scrollTop.classList.add('show-scroll'); else scrollTop.classList.remove('show-scroll')
}
window.addEventListener('scroll', scrollTop)

/*==================== DARK LIGHT THEME ====================*/ 
const themeButton = document.getElementById('theme-button')
const darkTheme = 'dark-theme'
const iconTheme = 'bx-sun'

// Previously selected topic (if user selected)
const selectedTheme = localStorage.getItem('selected-theme')
const selectedIcon = localStorage.getItem('selected-icon')

// We obtain the current theme that the interface has by validating the dark-theme class
const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light'
const getCurrentIcon = () => themeButton.classList.contains(iconTheme) ? 'bx-moon' : 'bx-sun'

// We validate if the user previously chose a topic
if (selectedTheme) {
  // If the validation is fulfilled, we ask what the issue was to know if we activated or deactivated the dark
  document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme)
  themeButton.classList[selectedIcon === 'bx-moon' ? 'add' : 'remove'](iconTheme)
}

// Activate / deactivate the theme manually with the button
themeButton.addEventListener('click', () => {
    // Add or remove the dark / icon theme
    document.body.classList.toggle(darkTheme)
    themeButton.classList.toggle(iconTheme)
    // We save the theme and the current icon that the user chose
    localStorage.setItem('selected-theme', getCurrentTheme())
    localStorage.setItem('selected-icon', getCurrentIcon())
})

/*==================== SCROLL REVEAL ANIMATION ====================*/
const sr = ScrollReveal({
    origin: 'top',
    distance: '30px',
    duration: 2000,
    reset: true
});

sr.reveal(`.home__data, .home__img,
            .about__data, .about__img,
            .services__content, .menu__content,
            .app__data, .app__img,
            .contact__data, .contact__button,
            .footer__content`, {
    interval: 200
})

/*==================== FORM VALIDATION ====================*/
const menuForm = document.querySelector('.form__container form');
if (menuForm) {
    menuForm.addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('form__input--error');
            } else {
                field.classList.remove('form__input--error');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields');
        }
    });
}

/*==================== AUTO HIDE MESSAGES ====================*/
const messages = document.querySelectorAll('.message__success, .message__error');
if (messages.length > 0) {
    messages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 500);
        }, 3000);
    });
}

/*==================== FORM HANDLING ====================*/
document.addEventListener('DOMContentLoaded', function() {
    const menuForm = document.querySelector('.form__container form');
    if (menuForm) {
        // Form validation
        menuForm.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('form__input--error');
                    
                    // Remove existing error message if any
                    const existingError = field.parentNode.querySelector('.form__error-message');
                    if (existingError) {
                        existingError.remove();
                    }
                    
                    // Add error message
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'form__error-message';
                    errorMessage.textContent = 'This field is required';
                    field.parentNode.appendChild(errorMessage);
                } else {
                    field.classList.remove('form__input--error');
                    const existingError = field.parentNode.querySelector('.form__error-message');
                    if (existingError) {
                        existingError.remove();
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Clear validation styling on input
        menuForm.querySelectorAll('.form__input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('form__input--error');
                const existingError = this.parentNode.querySelector('.form__error-message');
                if (existingError) {
                    existingError.remove();
                }
            });
        });
    }
});

/*==================== MENU CARDS ANIMATION ====================*/
document.addEventListener('DOMContentLoaded', function() {
    const menuCards = document.querySelectorAll('.menu__card');
    
    menuCards.forEach(card => {
        // Add loading animation for images
        const img = card.querySelector('img');
        if (img) {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
        }
        
        // Add cart button interaction
        const cartButton = card.querySelector('.menu__card-button');
        if (cartButton) {
            cartButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Add a quick animation to the button
                this.classList.add('button--animate');
                setTimeout(() => {
                    this.classList.remove('button--animate');
                }, 300);
                
                // You can add cart functionality here
                const itemName = card.querySelector('.menu__card-title').textContent;
                alert(`${itemName} added to cart!`);
            });
        }
    });
});

// Add these styles for the button animation
const style = document.createElement('style');
style.textContent = `
    .button--animate {
        animation: buttonPop 0.3s ease;
    }
    
    @keyframes buttonPop {
        0% { transform: scale(1); }
        50% { transform: scale(0.9); }
        100% { transform: scale(1); }
    }
`;
document.head.appendChild(style);