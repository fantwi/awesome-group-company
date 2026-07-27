document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('.site-nav');
    menuButton?.addEventListener('click', () => {
        const isOpen = navigation.classList.toggle('open');
        menuButton.setAttribute('aria-expanded', String(isOpen));
    });

    const slideImage = document.querySelector('#slider-image');
    if (slideImage) {
        const slides = [
            ['assets/images/slide-1.svg', 'Ideas into impact'],
            ['assets/images/slide-2.svg', 'Teams in sync'],
            ['assets/images/slide-3.svg', 'Smarter decisions'],
            ['assets/images/slide-4.svg', 'Secure by design'],
            ['assets/images/slide-5.svg', 'Growth that lasts']
        ];
        let current = 0;
        const showSlide = (index) => {
            current = (index + slides.length) % slides.length;
            slideImage.classList.add('changing');
            window.setTimeout(() => {
                slideImage.src = slides[current][0];
                slideImage.alt = slides[current][1] + ' illustration';
                document.querySelector('#slide-title').textContent = slides[current][1];
                document.querySelector('#slide-number').textContent = `${String(current + 1).padStart(2, '0')} / 05`;
                slideImage.classList.remove('changing');
            }, 220);
        };
        document.querySelector('.slider-arrow.next')?.addEventListener('click', () => showSlide(current + 1));
        document.querySelector('.slider-arrow.previous')?.addEventListener('click', () => showSlide(current - 1));
        window.setInterval(() => showSlide(current + 1), 5000);
    }

    const result = document.querySelector('#popup-result');
    document.querySelectorAll('[data-popup]').forEach((button) => {
        button.addEventListener('click', () => {
            if (button.dataset.popup === 'alert') {
                alert('Welcome to Awesome Group Company!');
                result.textContent = 'Alert acknowledged successfully.';
            }
            if (button.dataset.popup === 'confirm') {
                const accepted = confirm('Would you like Awesome Group to contact you?');
                result.textContent = accepted ? 'You selected OK.' : 'You selected Cancel.';
            }
            if (button.dataset.popup === 'prompt') {
                const name = prompt('What is your name?', '');
                result.textContent = name ? `Hello, ${name}! It is awesome to meet you.` : 'The prompt was cancelled or left empty.';
            }
        });
    });
});

