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

        .controls {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            font-size: 14px;
        }

        .controls label {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .loader-wrapper {
            width: 150px;
            height: 150px;
        }

        svg {
            width: 100%;
            height: 100%;
        }

        .shape {
            fill: none;
            stroke: #00c3ff;
            stroke-width: 3;
            stroke-linejoin: round;
            stroke-linecap: round;

            /* длину ставим через переменную */
            stroke-dasharray: var(--dash, 400);
            stroke-dashoffset: var(--dash, 400);

            animation-name: draw-shape;
            animation-timing-function: linear;
            animation-fill-mode: forwards; /* чтобы линия оставалась дорисованной */
            animation-duration: var(--duration, 2s);
            animation-iteration-count: var(--loop, infinite);
        }

        @keyframes draw-shape {
            from {
                stroke-dashoffset: var(--dash, 400);
            }
            to {
                stroke-dashoffset: 0;
            }
        }

        button {
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        .shape {
            animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
        }

    </style>
</head>
<body>

<div class="pre-loader">
    <label>
        Углы:
        <input id="sides" type="number" min="3" max="120" value="4">
    </label>
    <label>
        Скорость (сек):
        <input id="speed" type="number" min="0.1" step="0.1" value="2">
    </label>
    <label>
        <input id="loop" type="checkbox" checked>
        Зациклить
    </label>
    <button id="restart">Перерисовать</button>
</div>

<div class="loader-wrapper">
    <svg viewBox="0 0 100 100">
        <path id="shapePath" class="shape" />
    </svg>
</div>

<script>
    const sidesInput = document.getElementById('sides');
    const speedInput = document.getElementById('speed');
    const loopInput  = document.getElementById('loop');
    const restartBtn = document.getElementById('restart');

    const pathEl     = document.getElementById('shapePath');

    // Строим правильный многоугольник с N углами
    function makePolygonPath(sides) {
        const cx = 50; // центр
        const cy = 50;
        const r  = 40; // радиус
        const points = [];

        // старт сверху (−90 градусов)
        const startAngle = -Math.PI / 2;
        const step = (Math.PI * 2) / sides;

        for (let i = 0; i < sides; i++) {
            const angle = startAngle + step * i;
            const x = cx + r * Math.cos(angle);
            const y = cy + r * Math.sin(angle);
            points.push({x, y});
        }

        let d = `M ${points[0].x} ${points[0].y}`;
        for (let i = 1; i < points.length; i++) {
            d += ` L ${points[i].x} ${points[i].y}`;
        }
        d += ' Z'; // замыкаем

        return d;
    }

    function updateShape() {
        const sides = Math.max(3, Math.min(120, Number(sidesInput.value) || 4));
        const speed = Math.max(0.1, Number(speedInput.value) || 2);
        const loop  = loopInput.checked;

        // 1. Строим путь
        const d = makePolygonPath(sides);
        pathEl.setAttribute('d', d);

        // 2. Считаем длину контура
        const len = pathEl.getTotalLength();

        // 3. Проставляем CSS-переменные
        pathEl.style.setProperty('--dash', len);
        pathEl.style.setProperty('--duration', speed + 's');
        pathEl.style.setProperty('--loop', loop ? 'infinite' : '1');

        // 4. Сбрасываем и перезапускаем анимацию
        pathEl.style.animation = 'none';
        // принудительный reflow
        // (да, это оно самое грязное, но рабочее решение :)
        void pathEl.offsetWidth;
        pathEl.style.animation = '';
    }

    restartBtn.addEventListener('click', updateShape);
    sidesInput.addEventListener('change', updateShape);
    speedInput.addEventListener('change', updateShape);
    loopInput.addEventListener('change', updateShape);

    // первый запуск
    updateShape();
</script>

</body>
</html>
