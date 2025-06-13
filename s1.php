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
  padding: 0;
  border-radius: 8px;
  pointer-events: auto;
  z-index: 1000;
  opacity: 0;
  transform: translateY(-10px);
  transition: opacity 0.2s ease, transform 0.2s ease;
  display: inline-block;
}

#tooltip.show {
  opacity: 1;
  transform: translateY(0);
}

.tooltip-content {
  display: flex;
  align-items: center;
  font-size: 0.9rem;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
}

.tooltip-text {
  background: #222;
  color: #fff;
  padding: 8px 12px;
  white-space: nowrap;
}

#tooltip-link {
  background: #00d8ff;
  color: #000;
  text-decoration: none;
  font-weight: bold;
  padding: 8px 12px;
  white-space: nowrap;
  display: inline-block;
  transition: background 0.2s;
}

#tooltip-link:hover {
  background: #00bcd4;
}



  </style>
</head>
<body>

<div class="row">
  <div class="col-3">
    <ul class="link-list">
  <li><span data-tooltip="Internetowe radio z playlistami tematycznymi" data-href="https://soundlounge.fm">SoundLounge</span></li>
  <li><span data-tooltip="Platforma do dzielenia się beatami i remiksami" data-href="https://beattrail.com">BeatTrail</span></li>
  <li><span data-tooltip="Twórz miksy online i udostępniaj znajomym" data-href="https://mixboard.net">MixBoard</span></li>
  <li><span data-tooltip="Wirtualna kolekcja muzyki i podcastów" data-href="https://audiopark.io">AudioPark</span></li>

    </ul>
  </div>
  <div class="col-3">
    <ul class="link-list last-child">
  <li><span data-tooltip="Relacje na żywo, statystyki i terminarze meczów" data-href="https://goalpulse.com">GoalPulse</span></li>
  <li><span data-tooltip="Wideo-treningi i wyzwania fitness online" data-href="https://fitarena.dev">FitArena</span></li>
  <li><span data-tooltip="Społeczność sportowa i ligowe rankingi" data-href="https://sportverse.io">SportVerse</span></li>
  <li><span data-tooltip="Rezerwacje kortów tenisowych i hal sportowych" data-href="https://courtwatch.app">CourtWatch</span></li>

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
