<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Lista linków z tooltipem</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: ;
    }

    .row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .col-3 {
      flex: 0 0 25%;
      min-width: 200px;
    }

    .link-list {
      list-style: none;
      padding: 0;
    }

    .link-list li {
      margin-bottom: 10px;
    }

    .link-list a {
      text-decoration: none;
      color: #007BFF;
    }

    .link-list a:hover {
      text-decoration: underline;
    }

    /* Global tooltip */
#tooltip {
  position: absolute;
  background: #222;
  color: #fff;
  padding: 10px 14px;
  border-radius: 8px;
  font-size: 0.9rem;
  pointer-events: auto;
  z-index: 1000;
  opacity: 0;
  transform: translateY(-10px);
  transition: opacity 0.2s ease, transform 0.2s ease;
  max-width: 220px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
}

#tooltip.show {
  opacity: 1;
  transform: translateY(0);
}

#tooltip .tooltip-text {
  margin-bottom: 8px;
  line-height: 1.4;
}

#tooltip a {
  color: #00d8ff;
  text-decoration: underline;
  font-weight: bold;
  display: block;
  text-align: right;
}



  </style>
</head>
<body>

<div class="row">
<div class="col-3">
  <ul class="link-list">
    <li><span data-tooltip="Portal z recenzjami sprzętu komputerowego i nowinkami technologicznymi" data-href="https://techlynx.dev">TechLynx</span></li>
    <li><span data-tooltip="Społeczność pasjonatów hardware'u i customowych PC" data-href="https://rigforge.com">RigForge</span></li>
    <li><span data-tooltip="Symulator budowy komputera w przeglądarce" data-href="https://buildscope.net">BuildScope</span></li>
    <li><span data-tooltip="Baza wiedzy o podzespołach komputerowych i ich kompatybilności" data-href="https://chipnest.io">ChipNest</span></li>
  </ul>
</div>
<div class="col-3">
  <ul class="link-list last-child">
    <li><span data-tooltip="Aktualności, analizy i komentarze ze świata sportu" data-href="https://sportglobe.org">SportGlobe</span></li>
    <li><span data-tooltip="Treningi wideo i plany treningowe do pobrania" data-href="https://motiongrid.app">MotionGrid</span></li>
    <li><span data-tooltip="Forum sportowe i wymiana doświadczeń między amatorami i zawodowcami" data-href="https://athlinker.com">AthLinker</span></li>
    <li><span data-tooltip="Kalendarz wydarzeń sportowych i narzędzia do zarządzania drużyną" data-href="https://teamevo.io">TeamEvo</span></li>
  </ul>
</div>

</div>

<!-- Globalny tooltip podzielony na tekst i link -->
<div id="tooltip">
  <div class="tooltip-content">
    <span class="tooltip-text" id="tooltip-text">Opis</span>
    <a href="#" target="_blank" id="tooltip-link">Otwórz</a>
  </div>
</div>



<script>
const tooltip = document.getElementById('tooltip');
const tooltipText = document.getElementById('tooltip-text');
const tooltipLink = document.getElementById('tooltip-link');
let hideTimeout;

const marginSafe = 10;

document.querySelectorAll('[data-tooltip]').forEach(link => {
  link.addEventListener('mouseenter', () => {
    clearTimeout(hideTimeout);

    const text = link.getAttribute('data-tooltip');
    const href = link.getAttribute('href');

    tooltipText.textContent = text;
    tooltipLink.setAttribute('href', href);

    // Najpierw wyświetl tooltip niewidocznie, by DOM go wyrenderował
    tooltip.style.visibility = 'hidden';
    tooltip.style.opacity = '0';
    tooltip.classList.add('show');

    // Teraz obliczamy pozycję, bo już znamy rozmiar
    const rect = link.getBoundingClientRect();
    const tooltipRect = tooltip.getBoundingClientRect();

    const scrollTop = window.scrollY;
    const scrollLeft = window.scrollX;

    let top = scrollTop + rect.top - tooltipRect.height - 8;
    let placeAbove = true;

    if (top < scrollTop + marginSafe) {
      top = scrollTop + rect.bottom + 8;
      placeAbove = false;
    }

    let left = scrollLeft + rect.left + (rect.width - tooltipRect.width) / 2;
    const maxLeft = scrollLeft + document.documentElement.clientWidth - tooltipRect.width - marginSafe;
    const minLeft = scrollLeft + marginSafe;

    if (left < minLeft) left = minLeft;
    if (left > maxLeft) left = maxLeft;

    const bottomLimit = scrollTop + document.documentElement.clientHeight - tooltipRect.height - marginSafe;
    if (!placeAbove && top > bottomLimit) {
      top = bottomLimit;
    }

    tooltip.style.top = `${top}px`;
    tooltip.style.left = `${left}px`;

    // Po ustawieniu pozycji — włącz widoczność
    tooltip.style.visibility = 'visible';
    tooltip.style.opacity = '';
  });

  link.addEventListener('mouseleave', () => {
    hideTimeout = setTimeout(() => {
      tooltip.classList.remove('show');
      tooltip.style.visibility = 'hidden';
    }, 200);
  });

  tooltip.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
  tooltip.addEventListener('mouseleave', () => {
    tooltip.classList.remove('show');
    tooltip.style.visibility = 'hidden';
  });
});

window.addEventListener('scroll', () => tooltip.classList.remove('show'));
window.addEventListener('resize', () => tooltip.classList.remove('show'));


</script>


</body>
</html>
