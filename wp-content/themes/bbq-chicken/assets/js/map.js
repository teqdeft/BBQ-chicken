/* bb.q Chicken Europe — live delivery map (home "Find bb.q near you").
   The static map picture stays in place; once a live map has loaded it fades in on top.
   - With a Google Maps key: Google Maps in a dark monotone style.
   - Without one: Leaflet with Esri's dark grey canvas tiles.
   Settings come from data attributes on .map-card (all optional):
     data-lat="40.4319" data-lng="-3.6831" data-zoom="12" data-radius="4600" data-gmaps-key=""
     data-pins="40.4409,-3.6753;40.3971,-3.6660" (one pin per kitchen; none = a pin in the middle)
   The map script and tiles only load when the card is about to scroll into view. */
(function () {
  'use strict';
  var card = document.querySelector('.map-card');
  if (!card || !('IntersectionObserver' in window)) return;

  var LEAFLET = 'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/';
  var num = function (name, fallback) { var v = parseFloat(card.getAttribute('data-' + name)); return isFinite(v) ? v : fallback; };
  var lat = num('lat', 40.4319), lng = num('lng', -3.6831), radius = num('radius', 4600);
  var pins = (card.getAttribute('data-pins') || '').split(';').map(function (p) {
    var ll = p.split(',').map(parseFloat);
    return ll.length === 2 && isFinite(ll[0]) && isFinite(ll[1]) ? ll : null;
  }).filter(Boolean);
  if (!pins.length) pins = [[lat, lng]];
  var gmapsKey = card.getAttribute('data-gmaps-key') || '';
  var mob = function () { return window.innerWidth < 768; };
  var zoom = num('zoom', 12) - (mob() ? 1 : 0);

  var pinSvg = '<svg viewBox="0 0 56 70" aria-hidden="true"><path d="M28 1.5C13.9 1.5 3.5 12 3.5 25.5 3.5 43 28 68 28 68s24.5-25 24.5-42.5C52.5 12 42.1 1.5 28 1.5z" fill="#E31937" stroke="#fff" stroke-width="3"/><circle cx="28" cy="26" r="10" fill="#fff"/></svg>';

  // room the kitchen card takes at the bottom of the map, so every pin can be fitted above it
  function cardRoom() {
    var kc = card.querySelector('.kitchen-card');
    var room = kc ? card.getBoundingClientRect().bottom - kc.getBoundingClientRect().top + 16 : 30;
    return Math.max(30, Math.min(room, card.offsetHeight * 0.6));
  }

  var el = document.createElement('div');
  el.className = 'map-card__live';
  el.setAttribute('role', 'region');
  el.setAttribute('aria-label', card.getAttribute('aria-label') || 'Delivery map');
  var live = function () {
    card.classList.add('is-live');
    // the live map has its own controls, so the card is no longer a single picture
    card.removeAttribute('role');
    card.removeAttribute('aria-label');
  };

  function load(src, css) {
    return new Promise(function (resolve, reject) {
      var tag = document.createElement(css ? 'link' : 'script');
      if (css) { tag.rel = 'stylesheet'; tag.href = src; } else { tag.src = src; tag.async = true; }
      tag.crossOrigin = 'anonymous';
      tag.onload = resolve; tag.onerror = reject;
      document.head.appendChild(tag);
    });
  }

  function google() {
    window.__bbqGmaps = function () {
      var g = window.google.maps;
      var monotone = [
        { elementType: 'geometry', stylers: [{ color: '#2e2829' }] },
        { elementType: 'labels.icon', stylers: [{ visibility: 'off' }] },
        { elementType: 'labels.text.fill', stylers: [{ color: '#8c817c' }] },
        { elementType: 'labels.text.stroke', stylers: [{ color: '#221e1f' }] },
        { featureType: 'administrative', elementType: 'geometry', stylers: [{ visibility: 'off' }] },
        { featureType: 'poi', stylers: [{ visibility: 'off' }] },
        { featureType: 'transit', stylers: [{ visibility: 'off' }] },
        { featureType: 'road', elementType: 'geometry', stylers: [{ color: '#3b3334' }] },
        { featureType: 'road.arterial', elementType: 'geometry', stylers: [{ color: '#433a3b' }] },
        { featureType: 'road.highway', elementType: 'geometry', stylers: [{ color: '#4d4344' }] },
        { featureType: 'road', elementType: 'labels', stylers: [{ visibility: 'simplified' }] },
        { featureType: 'water', elementType: 'geometry', stylers: [{ color: '#1b1718' }] },
        { featureType: 'landscape.natural', elementType: 'geometry', stylers: [{ color: '#2a2425' }] }
      ];
      var m = new g.Map(el, { center: { lat: lat, lng: lng }, zoom: zoom, styles: monotone, disableDefaultUI: true, zoomControl: !mob(), gestureHandling: 'cooperative', backgroundColor: '#2e2829', keyboardShortcuts: false });
      new g.Circle({ map: m, center: { lat: lat, lng: lng }, radius: radius, strokeColor: '#E31937', strokeOpacity: 0.7, strokeWeight: 2, fillColor: '#E31937', fillOpacity: 0.18 });
      var s = mob() ? [40, 50] : [56, 70];
      pins.forEach(function (p) {
        new g.Marker({ map: m, position: { lat: p[0], lng: p[1] }, icon: { url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(pinSvg), scaledSize: new g.Size(s[0], s[1]), anchor: new g.Point(s[0] / 2, s[1]) } });
      });
      if (pins.length > 1) {
        var b = new g.LatLngBounds();
        pins.forEach(function (p) { b.extend({ lat: p[0], lng: p[1] }); });
        m.fitBounds(b, { top: s[1] + 16, bottom: cardRoom(), left: 40, right: 40 });
        g.event.addListenerOnce(m, 'bounds_changed', function () { if (m.getZoom() > zoom) m.setZoom(zoom); });
      }
      g.event.addListenerOnce(m, 'tilesloaded', live);
    };
    load('https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(gmapsKey) + '&callback=__bbqGmaps');
  }

  function leaflet() {
    Promise.all([load(LEAFLET + 'leaflet.css', true), load(LEAFLET + 'leaflet.js')]).then(function () {
      var L = window.L;
      var map = L.map(el, { center: [lat, lng], zoom: zoom, zoomSnap: 0.25, scrollWheelZoom: false, dragging: !L.Browser.mobile, tap: false, zoomControl: !mob(), keyboard: false, attributionControl: true });
      if (map.zoomControl) map.zoomControl.setPosition('bottomright');
      map.attributionControl.setPrefix(false); // only the map data's credit, without "Leaflet"
      var esri = 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/';
      var base = L.tileLayer(esri + 'World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}', { maxZoom: 16, attribution: 'Powered by <a href="https://www.esri.com/" target="_blank" rel="noopener">Esri</a> | HERE, Garmin, &copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a> contributors' }).addTo(map);
      L.tileLayer(esri + 'World_Dark_Gray_Reference/MapServer/tile/{z}/{y}/{x}', { maxZoom: 16, pane: 'overlayPane' }).addTo(map);
      var loaded = 0;
      base.on('tileload', function () { if (++loaded === 4) live(); });
      L.circle([lat, lng], { radius: radius, color: '#E31937', opacity: 0.7, weight: 2, dashArray: '6 6', fillColor: '#E31937', fillOpacity: 0.18 }).addTo(map);
      var s = mob() ? [40, 50] : [56, 70];
      pins.forEach(function (p) {
        L.marker(p, { icon: L.divIcon({ className: 'map-card__marker', html: pinSvg, iconSize: s, iconAnchor: [s[0] / 2, s[1]] }), keyboard: false, interactive: false }).addTo(map);
      });
      if (pins.length > 1) {
        // every kitchen in view, in the open part of the map above the kitchen card
        map.fitBounds(L.latLngBounds(pins), { paddingTopLeft: [40, s[1] + 16], paddingBottomRight: [40, cardRoom()], maxZoom: zoom, animate: false });
      } else {
        // keep the delivery circle in the open part of the card, above the kitchen card
        map.panBy([0, mob() ? 15 : 30], { animate: false });
      }
      window.addEventListener('resize', function () { map.invalidateSize(); });
    }).catch(function () { /* offline or blocked: the static map stays */ });
  }

  var io = new IntersectionObserver(function (entries) {
    if (!entries[0].isIntersecting) return;
    io.disconnect();
    var tiles = card.querySelector('.map-card__tiles');
    card.insertBefore(el, tiles ? tiles.nextSibling : card.firstChild);
    if (gmapsKey) google(); else leaflet();
  }, { rootMargin: '600px 0px' });
  io.observe(card);
})();
