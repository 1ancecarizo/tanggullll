<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TANGGOL</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <div class="logo">TAN<span>GGOL</span></div>
                <ul class="nav-links">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="#">Download App</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="rescue.php" class="sign-up-btn">Sign up</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>We have Bagyong Tino — Supertyphoon</h1>
            <p>Bagyong Tino (Supertyphoon) is impacting Legazpi City. Please follow evacuation instructions and stay alert.</p>
        </div>
    </section>

    <!-- Main Content -->
        <main class="flood-dashboard">
            <div class="flood-row">
                <!-- Left Sidebar -->
                <aside class="flood-sidebar">
                    <div class="flood-sidebar-section flood-sidebar-header">
                        <div class="flood-sidebar-title">Bagyong Tino — Supertyphoon Alert: Legazpi City</div>
                        <div class="flood-sidebar-info">
                            <div>Waterbody: <b>Yawa River</b></div>
                            <div>Gauge: <b>LGZP1</b></div>
                            <div>Status: <b style='color:#e53935;'>Supertyphoon (Bagyong Tino) — Major Flooding</b></div>
                            <div>Location: Legazpi City, Albay</div>
                            <div>Observed Time: 2025-11-22 10:00:00</div>
                            <div style="margin-top:8px;"><a href="#" class="flood-link">Typhoon Details</a></div>
                            <div><a href="#" class="flood-link">Evacuation Centers</a></div>
                            
                        </div>
                        <div class="flood-sidebar-update" style="color:#e53935;">Last update: Typhoon signal active</div>
                    </div>
                    <div class="flood-sidebar-section flood-sidebar-map">
                        <a href="rescue.php">
                            <img src="photos/maps.png" alt="Legazpi Map" style="width:100%;">
                        </a>
                            <div style="margin-top:8px;display:flex;flex-direction:column;gap:8px;align-items:stretch;">
                                <button id="homeMarkSafe" style="background:#1976d2;border:none;padding:16px 28px;;cursor:pointer;color:#fff;font-size:18px;font-weight:700;box-shadow:0 4px 10px rgba(0,0,0,0.3);width:100%;">I'm Safe</button>
                                <span id="homeSafeMsg" style="color:#ddd;font-size:0.95rem"></span>
                            </div>
                        
                    </div>
                </aside>
                <!-- Main Map and Bottom Bar -->
                <section class="flood-main">
                    <div class="flood-main-map">
                        <div id="leafletMap" 
                        style="width:100%;
                        height:100%;
                        
                       "></div>
                       
                    </div>
                    <div class="flood-main-bottom">
                        <div class="flood-bar-chart-card">
                            <canvas id="floodBarChart" width="340" height="160"></canvas>
                        </div>
                        <div class="flood-bottom-card flood-bottom-major">
                            <div class="flood-bottom-title">NWS Major Status Gauges in Map View</div>
                            <div class="flood-bottom-value">22</div>
                            <div class="flood-bottom-update">Last update: a few seconds ago</div>
                        </div>
                        <div class="flood-bottom-card flood-bottom-pie">
                            <div class="flood-bottom-title">NWS Obs River Stages in Map View</div>
                            <canvas id="floodPieChart" width="120" height="120"></canvas>
                            <div class="flood-bottom-update">Last update: a few seconds ago</div>
                        </div>
                    </div>
                </section>
                <!-- Right Sidebar -->
                <aside class="flood-rightbar">
                    <div class="flood-rightbar-section flood-rightbar-legend">
                        <div class="flood-rightbar-title">NWS Observed River Stages</div>
                        <ul class="flood-legend-list">
                            <li><span class="flood-legend-dot flood-dot-major"></span> Major Flooding</li>
                            <li><span class="flood-legend-dot flood-dot-moderate"></span> Moderate</li>
                            <li><span class="flood-legend-dot flood-dot-minor"></span> Minor Flooding</li>
                            <li><span class="flood-legend-dot flood-dot-near"></span> Near Flood</li>
                            <li><span class="flood-legend-dot flood-dot-none"></span> No Flooding</li>
                            <li><span class="flood-legend-dot flood-dot-category"></span> Flood Category</li>
                        </ul>
                    </div>
                    <div class="flood-rightbar-section flood-rightbar-list">
                        <div class="flood-rightbar-title">Legazpi City - Current Status</div>
                        <div class="flood-gauge-list">
                            <div class="flood-gauge-item"><b>Yawa River</b><br>Status: Supertyphoon (Bagyong Tino) — Major Flooding<br>Obs Time: 2025-11-22 10:00:00</div>
                            <div class="flood-gauge-item"><b>Evacuation Centers</b><br>Status: Open<br>Capacity: 2,000+</div>
                            <div class="flood-gauge-item"><b>Power Outage</b><br>Status: Reported in several barangays</div>
                        </div>
                    </div>
                </aside>
            </div>
        </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About Dark Weather</h3>
                    <p>Providing accurate weather forecasts worldwide since 2023. Our mission is to help people plan their activities with confidence.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul style="list-style: none;">
                        <li><a href="#" style="color: white; text-decoration: none;">Home</a></li>
                        <li><a href="#" style="color: white; text-decoration: none;">Download App</a></li>
                        <li><a href="#" style="color: white; text-decoration: none;">Contact Us</a></li>
                        <li><a href="#" style="color: white; text-decoration: none;">Sign Up</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>Email: info@darkweather.com</p>
                    <p>Phone: +1 (555) 123-4567</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 Dark Weather. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="js/home.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
        // Flood Dashboard Bar Chart
        new Chart(document.getElementById('floodBarChart'), {
            type: 'bar',
            data: {
                labels: ['action', 'major', 'minor', 'moderate'],
                datasets: [{
                    data: [243, 22, 146, 55],
                    backgroundColor: ['#ffe600', '#a259e6', '#ff6f00', '#e53935'],
                    borderRadius: 6,
                    barPercentage: 0.7
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                responsive: false,
                scales: {
                    x: { ticks: { color: '#fff' }, grid: { color: '#333' } },
                    y: { ticks: { color: '#fff' }, grid: { color: '#333' } }
                }
            }
        });
        // Flood Dashboard Pie Chart
        new Chart(document.getElementById('floodPieChart'), {
            type: 'pie',
            data: {
                labels: ['action', 'major', 'minor', 'moderate'],
                datasets: [{
                    data: [243, 22, 146, 55],
                    backgroundColor: ['#ffe600', '#a259e6', '#ff6f00', '#e53935']
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                responsive: false
            }
        });
        </script>


        
    <script>
    // Initialize Leaflet map for Legazpi City, Albay
    var map = L.map('leafletMap', { zoomControl: true }).setView([13.1391, 123.7438], 12);

    var base = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles © Esri, Earthstar Geographics, © OpenStreetMap contributors',
        maxZoom: 16
    }).addTo(map);

    base.on('load', function(){ var m = document.getElementById('mapMsg'); if(m) m.style.display='none'; });
    base.on('tileerror', function(e){ var m = document.getElementById('mapMsg'); if(m){ m.style.display='flex'; m.innerHTML = 'Map tiles failed to load.'; console.error('Tile load error:', e); } });

    L.control.scale({position:'bottomleft'}).addTo(map);

    L.marker([13.1391, 123.7438]).addTo(map)
        .bindPopup('Legazpi City, Albay')
        .openPopup();

    // Flood / danger zone indicators (copied from rescue.php)
   var nodes = [
    {lat:13.1391, lng:123.7438, cases:100}, // Major Flooding center
    {lat:13.1420, lng:123.7480, cases:9},
    {lat:13.1365, lng:123.7380, cases:50},
    {lat:13.1450, lng:123.7530, cases:5},
    {lat:13.1330, lng:123.7460, cases:4},
    {lat:13.1385, lng:123.7590, cases:21},
    {lat:13.1405, lng:123.7550, cases:8},
    {lat:13.1355, lng:123.7405, cases:10},
    {lat:13.1375, lng:123.7470, cases:12},
    {lat:13.1410, lng:123.7425, cases:15},
    {lat:13.1440, lng:123.7350, cases:8},
    {lat:13.1305, lng:123.7500, cases:5},
    {lat:13.1320, lng:123.7380, cases:31},

    // Upper side (north) danger zones
    {lat:13.1470, lng:123.7430, cases:4},
    {lat:13.1485, lng:123.7485, cases:8},
    {lat:13.1495, lng:123.7400, cases:10},
    {lat:13.1465, lng:123.7355, cases:25},
    {lat:13.1500, lng:123.7450, cases:17}
];




    var markers = [];
    // Create circles and keep references for live updates
    nodes.forEach(function(n){
        var color = (n.cases >= 20) ? 'rgba(46, 199, 213, 1)' : (n.cases >=6 ? '#e53935' : '#ff6f00');
        var radius = Math.max(6, Math.sqrt(n.cases) * 20);
        var circle = L.circle([n.lat,n.lng], { radius: radius, color: color, fillColor: color, fillOpacity: 0.6, weight: 1 }).addTo(map);
        // show cases on hover (non-intrusive)
        circle.bindTooltip(function(){ return 'Cases: ' + n.cases; }, {permanent:false, direction:'center'});
        // attach data reference for live updates
        n._circle = circle;
        markers.push(circle);
    });

    var group = new L.featureGroup(markers);
    try{ map.fitBounds(group.getBounds().pad(0.3)); } catch(e){ console.warn('fitBounds failed', e); }
    setTimeout(()=>map.invalidateSize(), 250);
    map.whenReady(()=>map.invalidateSize());

    // Live-update routine: simulate incoming case updates and refresh circles to match `rescue.php` logic
    function refreshCircles(){
        nodes.forEach(function(n){
            // compute new style from n.cases
            var color = (n.cases >= 20) ? 'rgba(32, 227, 230, 1)' : (n.cases >=6 ? '#e53935' : '#ff6f00');
            var radius = Math.max(6, Math.sqrt(n.cases) * 20);
            if(n._circle){
                n._circle.setStyle({ color: color, fillColor: color, fillOpacity: 0.6, weight: 1 });
                n._circle.setRadius(radius);
                // update tooltip content
                n._circle.unbindTooltip();
                n._circle.bindTooltip('Cases: ' + n.cases, {permanent:false, direction:'center'});
            }
        });
    }

    // Example updater: simulate small random case changes every 5s (replace with real data fetch later)
    setInterval(function(){
        nodes.forEach(function(n){
            // random walk +/- up to 3 cases, but keep at least 1
            var delta = Math.floor((Math.random()*7) - 3);
            n.cases = Math.max(1, (n.cases || 1) + delta);
        });
        refreshCircles();
    }, 5000);
    </script>
    <script>
    // "I'm Safe" sender for evacuation page
    (function(){
        var btn = document.getElementById('evacMarkSafe');
        var msg = document.getElementById('evacSafeMsg');
        if(!btn) return;
        btn.addEventListener('click', function(){
            btn.disabled = true;
            msg.textContent = ' Sending...';
            var payload = { page: 'evacuation', location: 'sidebar map', lat:13.1391, lng:123.7438, user: 'anonymous' };
            fetch('safe_report.php', { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify(payload) })
            .then(function(r){ return r.json(); })
            .then(function(j){
                if(j && j.status === 'ok'){
                    msg.textContent = ' Marked safe ✓';
                    btn.style.opacity = '0.7';
                } else {
                    msg.textContent = ' Error';
                    btn.disabled = false;
                }
            }).catch(function(err){
                console.error(err);
                msg.textContent = ' Failed to send';
                btn.disabled = false;
            });
        });
    })();
    </script>
    


    
   
  
   

    
</body>
</html>
