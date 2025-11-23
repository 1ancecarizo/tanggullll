<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rescue Dashboard - TANGGOL</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>
html, body { height:100%; margin:0; font-family:Arial, Helvetica, sans-serif; background:#0f1113; color:#ddd; }
.topbar { height:56px; background:#0b0c0e; border-bottom:1px solid #222; display:flex; align-items:center; padding:0 18px; font-weight:700; }
.layout { display:flex; height:calc(100% - 56px); }
.leftcol, .rightcol { background:#0e1114; padding:18px; box-sizing:border-box; }
.leftcol { width:300px; border-right:1px solid #1e1f22; display:flex; flex-direction:column; }
.rightcol { width:360px; border-left:1px solid #1e1f22; }
.center { flex:1; background:#0b0c0e; display:flex; flex-direction:column; }
.map-wrap { flex:1; padding:12px; height:calc(100vh - 160px); box-sizing:border-box; }
#rescueMap { width:100%; height:100%; border-radius:4px; border:1px solid #111; position:relative; }
h3 { margin:6px 0 12px; color:#fff; }
.big-number { font-size:48px; color:#ff2b2b; font-weight:800; line-height:1; }
.filter-buttons { display:flex; gap:6px; margin-bottom:8px; }
.filter-buttons button { flex:1; padding:6px; color:#fff; background:#1e1f22; border:none; border-radius:4px; cursor:pointer; transition:0.2s; }
.filter-buttons button.active { background:#e53935; }
.zone-list { flex:1; overflow:auto; margin-top:8px; }
.zone-list li { padding:8px 6px; border-bottom:1px solid #141517; color:#cfcfcf; display:flex; justify-content:space-between; align-items:center; cursor:pointer; }
.zone-badge { width:12px; height:12px; border-radius:50%; display:inline-block; margin-right:8px; }
.sidebar-footer { font-size:12px; color:#888; margin-top:12px; }
.stat-card { background:#0b0c0e; border-radius:4px; padding:12px; margin-bottom:12px; border:1px solid #202225; }
.stat-card h2 { margin:0; font-size:36px; color:#fff; }
.stat-card .meta { color:#999; font-size:12px; margin-top:6px; }
.mini-chart { height:160px; margin-top:8px; background:#0b0c0e; border-radius:4px; padding:8px; }
.legend { position:absolute; left:320px; top:70px; background:#0b0c0e; color:#fff; padding:8px; border-radius:4px; border:1px solid #222; z-index:500; }
.zone-list::-webkit-scrollbar { width:8px; }
.zone-list::-webkit-scrollbar-thumb { background:#202225; border-radius:4px; }
.leaflet-container { width:100%; height:100%; background:#111; }
.leaflet-control { background:rgba(255,255,255,0.9); color:#111; }
#showAllTeamsBtn { margin-bottom:6px; padding:4px 6px; border:none; border-radius:4px; background:#1e1f22; color:#fff; cursor:pointer; }
</style>
</head>
<body>

<div class="topbar">Rescue Dashboard - TANGGOL</div>

<div class="layout">
  <!-- Left Sidebar -->
  <aside class="leftcol">
    <h3>Total Safe Population</h3>
    <div class="big-number" id="totalCases">210,616</div>
    <div class="sidebar-footer">Last Updated: <span id="lastUpdated">--</span></div>

    <h3>Filter Zones</h3>
    <div class="filter-buttons">
      <button data-filter="all" class="active">All</button>
      <button data-filter="high">High</button>
      <button data-filter="medium">Medium</button>
      <button data-filter="low">Low</button>
    </div>

    <h3>Zones in Legazpi City</h3>
    <ul class="zone-list" id="zoneList"></ul>
  </aside>

  <!-- Map -->
  <main class="center">
    <div class="map-wrap">
      <div id="rescueMap">
        <div id="mapMsg" style="position:absolute;left:0;top:0;right:0;bottom:0;display:flex;align-items:center;justify-content:center;color:#bbb;z-index:600;pointer-events:none;">Loading map...</div>
      </div>
      <div class="legend">Visualization: Circle size = cases</div>
    </div>
  </main>

  <!-- Right Sidebar -->
  <aside class="rightcol">
    <div class="stat-card">
      <div style="font-size:12px;color:#999">Active Alerts</div>
      <h2 id="activeAlerts">12</h2>
      <div class="meta">High-risk zones being monitored</div>
    </div>

    <div class="stat-card">
      <div style="font-size:12px;color:#999">Evacuations Ready</div>
      <h2 style="color:#8ed36b" id="evacReady">7</h2>
      <div class="meta">Evacuation centers prepared</div>
    </div>

    <div class="stat-card">
      <div style="font-weight:600;margin-bottom:8px">Secure Communities</div>
      <div class="mini-chart"><canvas id="tsChart" height="120"></canvas></div>
    </div>

    <div class="stat-card">
      <div style="font-weight:600;margin-bottom:8px">Rescue Teams</div>
      <button id="showAllTeamsBtn">Show All Teams</button>
      <ul id="teamList" style="list-style:none;padding:0;margin:0;max-height:200px;overflow-y:auto;font-size:14px;color:#ccc"></ul>
    </div>

    <div class="stat-card">
      <div style="font-weight:600;margin-bottom:8px">Notes & Data Sources</div>
      <div style="font-size:12px;color:#999">Data sources: Local Rescue Records. Dashboard simulates rescuer monitoring of Legazpi City safety for early warning.</div>
    </div>
  </aside>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// --------------- MAP SETUP -----------------
var map = L.map('rescueMap').setView([13.1292,123.7417], 12);
var base = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Tiles &copy; Esri, Earthstar Geographics, &copy; OpenStreetMap contributors', maxZoom:16
}).addTo(map);

base.on('load', ()=>document.getElementById('mapMsg').style.display='none');
base.on('tileerror', e=>{ 
    let m=document.getElementById('mapMsg'); 
    m.style.display='flex'; 
    m.innerHTML='Map tiles failed to load.'; 
    console.error(e); 
});
L.control.scale({position:'bottomleft'}).addTo(map);

// --------------- DATA -----------------
var dangerZones=[
  {lat:13.1391,lng:123.7438,cases:100,name:"Rawis"},
  {lat:13.1420,lng:123.7480,cases:9,name:"Bagumbayan"},
  {lat:13.1365,lng:123.7380,cases:50,name:"San Roque"},
  {lat:13.1450,lng:123.7530,cases:5,name:"Central Bgy 1"},
  {lat:13.1330,lng:123.7460,cases:0,name:"Busay Bgy 2"},
  {lat:13.1385,lng:123.7590,cases:21,name:"Capantawan Bgy 3"},
  {lat:13.1405,lng:123.7550,cases:8,name:"Camatang Bgy 4"},
  {lat:13.1355,lng:123.7405,cases:10,name:"Santo Domingo Bgy 5"},
  {lat:13.1375,lng:123.7470,cases:12,name:"Cogon Bgy 6"},
  {lat:13.1410,lng:123.7425,cases:15,name:"Daraga Norte Bgy 7"},
  {lat:13.1440,lng:123.7350,cases:8,name:"Panganiban Bgy 8"},
  {lat:13.1305,lng:123.7500,cases:0,name:"Sawangan Bgy 9"},
  {lat:13.1320,lng:123.7380,cases:31,name:"Victory Village Bgy 10"},
  {lat:13.1470,lng:123.7430,cases:89,name:"Pantao Bgy 11"},
  {lat:13.1485,lng:123.7485,cases:75,name:"Barangka Bgy 12"},
  {lat:13.1495,lng:123.7400,cases:10,name:"Biasong Bgy 13"},
  {lat:13.1465,lng:123.7355,cases:25,name:"San Isidro Bgy 14"},
  {lat:13.1500,lng:123.7450,cases:17,name:"San Jose Bgy 15"},
  {lat:13.1435,lng:123.7490,cases:7,name:"Busay Norte Bgy 16"},
  {lat:13.1415,lng:123.7375,cases:60,name:"Rawis Proper Bgy 17"}
];

var rescueTeams=[
  {name:"Team Alpha", vehicle:"Rescue Truck", lat:13.140, lng:123.745, status:"Available"},
  {name:"Team Bravo", vehicle:"Ambulance", lat:13.145, lng:123.748, status:"On Mission"},
  {name:"Team Charlie", vehicle:"Rescue Boat", lat:13.136, lng:123.739, status:"Returning"}
];

var teamMarkers=[], teamRouteLine=null;
var statusColors={"Available":"#4caf50","On Mission":"#ff3b3b","Returning":"#ff9800"};
var currentFilter='all', avgSpeed=40, activeTeamIndex=null, showAllActive=false;

// --------------- FUNCTIONS -----------------
function getZoneLevel(cases){ return cases>=50?'high':cases>=20?'medium':'low'; }
function getDistanceKm(lat1,lng1,lat2,lng2){ 
  const R=6371, dLat=(lat2-lat1)*Math.PI/180, dLng=(lng2-lng1)*Math.PI/180;
  const a=Math.sin(dLat/2)**2+Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*Math.sin(dLng/2)**2;
  return R*2*Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

function renderZones(){
  map.eachLayer(l=>{ if(l instanceof L.Circle || l instanceof L.CircleMarker) map.removeLayer(l); });
  if(teamRouteLine) map.removeLayer(teamRouteLine);

  let listEl=document.getElementById('zoneList'); listEl.innerHTML='';
  let activeHighCount=0;

  dangerZones.forEach(z=>{
    let level=getZoneLevel(z.cases);
    if(currentFilter!=='all' && currentFilter!==level) return;
    let color = level==='high'?'#d22':level==='medium'?'#e53935':'#ff6f00';
    let radius=Math.max(6, Math.sqrt(Math.max(z.cases,1))*20);

    L.circle([z.lat,z.lng],{ radius, color, fillColor: color, fillOpacity:0.6, weight:1 })
     .addTo(map).bindPopup(`<b>${z.name}</b><br>Cases: ${z.cases}`);

    listEl.innerHTML+=`<li>
      <span class="zone-badge" style="background:${color}"></span>
      ${z.name} <b>${z.cases}</b>
    </li>`;
    if(level==='high') activeHighCount++;
  });

  document.getElementById('lastUpdated').innerText=new Date().toLocaleString();
  document.getElementById('activeAlerts').innerText=activeHighCount;
}

function renderTeams(){
  let list=document.getElementById('teamList'); list.innerHTML='';
  rescueTeams.forEach((t,i)=>{
    list.innerHTML+=`<li data-index="${i}">
      <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:${statusColors[t.status]};margin-right:6px"></span>
      <b>${t.name}</b> – ${t.vehicle}<br>
      <span style="font-size:12px;color:#aaa">${t.status}</span>
    </li>`;
  });

  document.querySelectorAll('#teamList li').forEach(li=>{
    li.addEventListener('click', ()=>{
      activeTeamIndex=parseInt(li.getAttribute('data-index'));
      showAllActive=false;
      updateTeamMarkers();
    });
  });
}

function updateTeamMarkers(){
  teamMarkers.forEach(m=>map.removeLayer(m));
  if(teamRouteLine) map.removeLayer(teamRouteLine);
  teamMarkers=[];

  if(activeTeamIndex!==null){
    let t=rescueTeams[activeTeamIndex];
    map.flyTo([t.lat,t.lng],14,{duration:1.5});
    let marker=L.marker([t.lat,t.lng]).addTo(map)
      .bindPopup(`<b>${t.name}</b><br>${t.vehicle}<br>Status: ${t.status}`);
    teamMarkers.push(marker);

    // Route to high-risk zones
    let highZones=dangerZones.filter(z=>getZoneLevel(z.cases)==='high').sort((a,b)=>b.cases-a.cases).slice(0,3);
    if(highZones.length>0){
      let path=[[t.lat,t.lng],...highZones.map(z=>[z.lat,z.lng])];
      teamRouteLine=L.polyline(path,{color:'cyan',dashArray:'5,5'}).addTo(map);

      let popupContent=`<b>${t.name}</b><br>${t.vehicle}<br>Status: ${t.status}<br><br><b>Route:</b><br>`;
      let prevLat=t.lat, prevLng=t.lng;
      highZones.forEach((z,i)=>{
        let d=getDistanceKm(prevLat,prevLng,z.lat,z.lng);
        let eta=Math.round(d/avgSpeed*60);
        popupContent+=`${i+1}. ${z.name} - ${d.toFixed(2)} km (~${eta} mins)<br>`;
        prevLat=z.lat; prevLng=z.lng;
      });
      marker.bindPopup(popupContent).openPopup();
    }

  } else if(showAllActive){
    rescueTeams.forEach(t=>{
      let marker=L.marker([t.lat,t.lng]).addTo(map).bindPopup(`<b>${t.name}</b><br>${t.vehicle}<br>Status: ${t.status}`);
      teamMarkers.push(marker);
    });
  }
}

// --------------- EVENTS -----------------
document.querySelectorAll('.filter-buttons button').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    document.querySelectorAll('.filter-buttons button').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    currentFilter=btn.getAttribute('data-filter');
    renderZones();
  });
});

document.getElementById('showAllTeamsBtn').addEventListener('click', ()=>{
  activeTeamIndex=null; showAllActive=true; updateTeamMarkers();
});

// --------------- SIMULATION -----------------
setInterval(()=>{
  dangerZones.forEach(z=>{ z.cases=Math.max(0,z.cases + Math.floor(Math.random()*11)-5); });
  renderZones();
},5000);

setInterval(()=>{
  rescueTeams.forEach(t=>{
    t.lat+=(Math.random()-0.5)*0.002;
    t.lng+=(Math.random()-0.5)*0.002;
    if(Math.random()<0.3){ let s=["Available","On Mission","Returning"]; t.status=s[Math.floor(Math.random()*s.length)]; }
  });
  renderTeams(); updateTeamMarkers();
},5000);

// --------------- INITIALIZE -----------------
renderZones();
renderTeams();

// --------------- CHART -----------------
new Chart(document.getElementById('tsChart').getContext('2d'), {
  type:'line',
  data:{ labels:['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], datasets:[{
    label:'High-risk Active Alerts',
    data:[12,14,13,15,14,16,12],
    borderColor:'#ff4d4d', backgroundColor:'rgba(255,77,77,0.15)', fill:true, tension:0.4, pointRadius:4, pointBackgroundColor:'#ff4d4d'
  }]},
  options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{x:{grid:{display:false},ticks:{color:'#aaa'}},y:{beginAtZero:true,ticks:{color:'#aaa',stepSize:2}}} }
});
</script>
</body>
</html>
