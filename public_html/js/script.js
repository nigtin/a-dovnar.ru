// Пре-лоадер

const anim = anime.timeline({
    loop: true,
    direction: 'alternate',
});

anim
    .add({
        targets: '#hexagon path',
        strokeDashoffset: [anime.setDashoffset, 0],
        easing: 'easeInOutQuart',
        duration: 2000,
        delay: function(el, i) { return i * 250 },
    })
    .add({
        targets: '#hexagon #D',
        duration: 1000,
        opacity: 1,
        easing: 'easeInOutQuart'
    });

setTimeout(() => {
    // скрываем прелоадер
    document.getElementById('pre-loader').classList.add('collapsed');

    // показываем main
    const main = document.querySelector('.main');
    if (main) {
        main.classList.add('show');
    }
}, 2900);

setTimeout(() => {
    const leftbar = document.querySelector('.left');
    const rightbar = document.querySelector('.right');

    leftbar.classList.add('is-visible');
    rightbar.classList.add('is-visible');
}, 4000);

// Появление меню
function initMenuObserver() {

    const mediaQuery = window.matchMedia('(min-width: 780px)');
    // Если экран меньше 780px - выходим
    if (!mediaQuery.matches) {
        return;
    }


    const menu = document.querySelector('.menu');
    if (!menu) return;

    const items = [
        ...menu.querySelectorAll('ol li'),
        menu.querySelector('.resume')
    ];
    // Сбрасываем классы, чтобы анимация могла отыграть заново
    items.forEach(el => el.classList.remove('show'));

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                items.forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.add('show');
                    }, index * 200);
                });

                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.2
    });

    observer.observe(menu);
}

document.addEventListener('DOMContentLoaded', () => {
    initMenuObserver();

    window.addEventListener('resize', () => {
        initMenuObserver();
    });


    //mobile menu
    let mobile_menu_button = document.querySelector('.menu_mobile_button');
    let mobile_menu = document.querySelector('.menu');
    let menu_mobile_icon = document.querySelector('.menu_mobile_icon')

    mobile_menu_button.addEventListener('click', () => {
        menu_mobile_icon.classList.toggle('active');
        mobile_menu.classList.toggle('open');
    });
});





//Слайдер опыта работы
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.experience__tabs .tab');
    const slides = document.querySelectorAll('.experience__content .slide');
    const indicator = document.querySelector('.tabs-indicator');

    if (!tabs.length || !indicator) return;

    function moveIndicator(index) {
        const targetTab = tabs[index];

        if (window.innerWidth <= 600){
            const offset = targetTab.offsetLeft;
            indicator.style.transform = `translateX(${offset}px)`;
        }else {
            const offset = targetTab.offsetTop;
            indicator.style.transform = `translateY(${offset}px)`;
        }
    }

    function activateSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
        tabs.forEach((tab, i) => {
            tab.classList.toggle('active', i === index);
        });
        moveIndicator(index);
    }

    tabs.forEach((tab, i) => {
        tab.addEventListener('click', () => {
            activateSlide(i);
        });
    });

    activateSlide(0);
});


document.addEventListener('DOMContentLoaded', () => {
    // hero, как раньше
    const heroSection = document.querySelector('.main_0');
    const heroItems = heroSection?.querySelectorAll('.hero-item') || [];

    const isMobile = window.matchMedia('(max-width: 768px)').matches;
    const thresholdValue = isMobile ? 0.3 : 0.7;

    if (heroSection && heroItems.length) {
        const heroObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        heroItems.forEach((item, index) => {
                            const delay = index * 200;
                            setTimeout(() => {
                                item.classList.add('is-visible');
                            }, delay);
                        });
                        heroObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: thresholdValue }
        );

        heroObserver.observe(heroSection);
    }

    // секции main_1..main_4
    const sections = document.querySelectorAll('.main_1, .main_2, .main_4');

    const sectionObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                // 70% блока внутри viewport
                if (entry.isIntersecting && entry.intersectionRatio >= thresholdValue) {
                    setTimeout(() => {
                        entry.target.classList.add('is-visible');
                        // если анимация нужна один раз
                        sectionObserver.unobserve(entry.target);
                    }, 200);
                }
            });
        },
        {
            threshold: thresholdValue, // колбэк дернётся, когда пересечёт 70% границу
        }
    );

    sections.forEach((sec) => sectionObserver.observe(sec));
});
document.addEventListener('DOMContentLoaded', () => {
    // находим заголовок внутри main_3
    const heading = document.querySelector('.main_3 .numbered-heading');
    // и все li проектов внутри main_3
    const projectItems = document.querySelectorAll('.main_3 .project li');

    const targets = [];
    if (heading) targets.push(heading);
    projectItems.forEach((li) => targets.push(li));

    if (!targets.length) return;

    const options = {
        threshold: 0.7, // 70% элемента внутри viewport
    };

    const callback = (entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && entry.intersectionRatio >= 0.7) {
                entry.target.classList.add('is-visible');
                // чтобы анимация была один раз
                observer.unobserve(entry.target);
            }
        });
    };

    const observer = new IntersectionObserver(callback, options);

    targets.forEach((el) => observer.observe(el));
});


// header
const header = document.querySelector('header');
let lastScroll = 0;
const delta = 5;                 // минимальное изменение, чтобы реагировать
const hideAfter = 50;            // не прятать хедер совсем вверху

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    if (currentScroll > 0) {
        header.classList.add('header-shadow');
    } else {
        header.classList.remove('header-shadow');
    }

    // игнорировать мелкие "дрожания"
    if (Math.abs(currentScroll - lastScroll) <= delta) return;

    if (currentScroll > lastScroll && currentScroll > hideAfter) {
        // скролл вниз — прячем
        header.classList.add('header-hidden');
    } else {
        // скролл вверх — показываем
        header.classList.remove('header-hidden');
    }

    lastScroll = currentScroll <= 0 ? 0 : currentScroll;
});