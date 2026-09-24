<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Настраиваемая фигура</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif; /**/
            box-sizing: border-box;
        }

        .loader-wrapper {
            width: 300px;
            height: 300px;
        }

        .shape {
            fill: none;
            stroke: #00c3ff;
            stroke-width: 3;
            stroke-linejoin: round;/*round*/
            stroke-linecap: round;
            /*animation-timing-function: cubic-bezier(0.5, 0, 1, 1);*/
            /*animation-timing-function: ease-out;*/
            transform: scaleX(-1);
            transform-origin: center;
            stroke-dasharray: 600;
            /*stroke-dashoffset: var(--dash, 600);*//*разобраться что зачем*/
            /*stroke-dasharray: 600;*/
            /*stroke-dashoffset: 600;*/

            animation-name: draw-shape;
            animation-timing-function: cubic-bezier(1, 0.4, 0.9, 0.4);
            animation-fill-mode: forwards; /* чтобы линия оставалась дорисованной */
            animation-duration: 2s;
            /*animation-iteration-count: infinite;*/
        }

        @keyframes draw-shape {
            from {
                stroke-dashoffset: 600;

            }
            to {
                stroke-dashoffset: 0;
            }
        }

        .pre-loader{
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
        }
        .logo_d{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-44%) translateY(-50%);
            stroke: #00c3ff;
            fill: #00c3ff;
            opacity: 0;
            transition: 1s ease-in-out;

        }
        .logo-visible {
            opacity: 1;
        }
    </style>
</head>
<body>


<div class="pre-loader">
    <div class="loader-wrapper">
        <div class="circle-6">
            <svg viewBox="0 0 100 100">
                <path id="shapePath" class="shape"
                      d="M 50 30 L 67.32050807568876 40 L 67.32050807568878 60 L 50 70 L 32.67949192431123 60.00000000000001 L 32.67949192431122 40.000000000000014 Z"
                />
            </svg>
        </div>
        <div class="logo_d">
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                 width="50px"  viewBox="0 0 1045.000000 1280.000000"
                 preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)"
                >
                    <path d="M0 6401 l0 -6401 1818 0 c1705 0 2170 6 2572 30 1099 67 1904 236
2635 556 152 66 467 227 605 309 945 561 1688 1393 2175 2436 529 1132 739
2489 599 3874 -79 781 -270 1508 -574 2181 -525 1164 -1413 2112 -2485 2654
-719 364 -1631 596 -2750 700 -575 53 -585 53 -2657 57 l-1938 4 0 -6400z
m3800 3279 c779 -36 1264 -126 1717 -320 951 -408 1546 -1294 1689 -2515 25
-213 25 -713 1 -915 -82 -665 -283 -1200 -622 -1655 -413 -555 -947 -873
-1730 -1030 -403 -80 -814 -120 -1357 -132 l-298 -6 0 3291 0 3292 193 0 c105
0 289 -5 407 -10z"/>
                </g>
            </svg>
        </div>


    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const logo = document.querySelector('.logo_d');
        if (logo) {
            setTimeout(() => logo.classList.add('logo-visible'), 800);
        }
    });
</script>
</body>
</html>
