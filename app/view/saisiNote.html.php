<?php
$classes = $classes ?? [];
$matieres = $matieres ?? [];
$periodes = $periodes ?? [];
$moyenne = $moyenne ?? 0;
$user = $_SESSION['userConnect'];
// dd($moyenne);


?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Saisie des notes — Groupe Scolaire Al Amal</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root{
    --bg:#F7F7F4;
    --card:#FFFFFF;
    --border:#E6E6E1;
    --border-soft:#EDEDE9;
    --ink:#151915;
    --ink-soft:#5B6560;
    --grey:#8A8F8A;
    --green:#2E6B4E;
    --green-dark:#20503A;
    --green-bg:#E7F3EB;
    --green-bg-strong:#DCEEE3;
    --amber:#B8860B;
    --shadow: 0 1px 2px rgba(20,25,20,0.04), 0 8px 24px -12px rgba(20,25,20,0.10);
  }
  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}
  body{
    background:var(--bg);
    color:var(--ink);
    font-family:'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    -webkit-font-smoothing:antialiased;
    min-height:100vh;
  }
  .page{max-width:1360px;margin:0 auto;padding:0 40px 64px;}

  /* ---------- Header ---------- */
  header.topbar{
    display:flex;align-items:center;justify-content:space-between;
    padding:22px 40px;
    border-bottom:1px solid var(--border);
    background:var(--bg);
  }
  .brand{
    font-size:13px;font-weight:800;letter-spacing:.09em;color:var(--ink-soft);
  }
  .top-right{display:flex;align-items:center;gap:18px;}
  .year-pill{
    display:flex;align-items:center;gap:7px;
    padding:7px 14px;border-radius:999px;background:var(--card);
    border:1px solid var(--border);font-size:13px;font-weight:600;color:var(--ink);
  }
  .dot{width:7px;height:7px;border-radius:50%;background:var(--green);display:inline-block;}
  .icon-btn{
    width:38px;height:38px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:var(--card);border:1px solid var(--border);
    color:var(--ink-soft);cursor:pointer;position:relative;
  }
  .icon-btn svg{width:17px;height:17px;}
  .icon-btn .badge-dot{
    position:absolute;top:6px;right:7px;width:6px;height:6px;border-radius:50%;background:var(--green);
  }
  .user{display:flex;align-items:center;gap:10px;cursor:pointer;}
  .avatar-user{
    width:38px;height:38px;border-radius:50%;background:var(--green-bg);
    color:var(--green-dark);font-weight:800;font-size:13px;
    display:flex;align-items:center;justify-content:center;
  }
  .user-meta{line-height:1.25;}
  .user-name{font-size:13.5px;font-weight:700;color:var(--ink);}
  .user-role{font-size:12px;color:var(--grey);}
  .chev{color:var(--grey);margin-left:2px;}

  /* ---------- Hero ---------- */
  .hero{display:flex;align-items:flex-start;justify-content:space-between;padding:44px 0 30px;flex-wrap:wrap;gap:20px;}
  .eyebrow{
    font-size:12.5px;font-weight:800;letter-spacing:.14em;color:var(--green);
    margin-bottom:10px;
  }
  h1.title{
    font-family:'Baloo 2', 'Plus Jakarta Sans', sans-serif;
    font-size:46px;line-height:1;font-weight:800;margin:0 0 12px;color:var(--ink);
    letter-spacing:-0.01em;
  }
  .subtitle{font-size:15.5px;color:var(--ink-soft);max-width:520px;line-height:1.5;}
  .hero-actions{display:flex;gap:12px;flex-shrink:0;padding-top:6px;}
  .btn{
    display:flex;align-items:center;gap:8px;
    font-family:inherit;font-size:14px;font-weight:700;
    padding:13px 20px;border-radius:12px;cursor:pointer;
    border:1px solid transparent;transition:transform .12s ease, box-shadow .12s ease, background .15s ease;
    white-space:nowrap;
  }
  .btn:active{transform:translateY(1px) scale(.99);}
  .btn svg{width:16px;height:16px;flex-shrink:0;}
  .btn-ghost{background:var(--card);border-color:var(--border);color:var(--ink);}
  .btn-ghost:hover{border-color:#D3D3CC;}
  .btn-primary{background:var(--green-dark);color:#fff;box-shadow:var(--shadow);}
  .btn-primary:hover{background:#173D2B;}
  .btn-primary:disabled{opacity:.55;cursor:default;}
  .btn-validate{
    background:var(--green);color:#fff;
  }
  .btn-validate:hover{background:var(--green-dark);}
  .btn-validate.is-valid{background:var(--green-bg);color:var(--green-dark);border:1px solid #BFE0CC;}

  /* ---------- Filter card ---------- */
  .filters-card{
    background:var(--card);border:1px solid var(--border);border-radius:18px;
    box-shadow:var(--shadow);
    padding:26px 28px;
    display:flex;align-items:flex-end;gap:22px;flex-wrap:wrap;
    transition:box-shadow .3s ease, border-color .3s ease;
  }
  .filters-card.flash{
    border-color:#BFE0CC;
    box-shadow:0 0 0 4px rgba(46,107,78,0.10), var(--shadow);
  }
  .field{display:flex;flex-direction:column;gap:9px;min-width:180px;flex:1 1 180px;}
  .field label{font-size:13.5px;font-weight:700;color:var(--ink);}
  .select-wrap{position:relative;}
  .select-wrap svg{
    position:absolute;right:14px;top:50%;transform:translateY(-50%);
    width:15px;height:15px;color:var(--grey);pointer-events:none;
  }
  select{
    appearance:none;-webkit-appearance:none;
    width:100%;font-family:inherit;font-size:15px;font-weight:600;color:var(--ink);
    background:var(--card);border:1px solid var(--border);border-radius:12px;
    padding:13px 38px 13px 15px;cursor:pointer;
  }
  select:focus-visible, .btn:focus-visible, .icon-btn:focus-visible, input:focus-visible{
    outline:2px solid var(--green);outline-offset:2px;
  }

  .validate-field{flex:0 0 auto;min-width:150px;}
  .validate-field label{visibility:hidden;}
  .btn-validate{
    width:100%;justify-content:center;padding:13px 18px;border-radius:12px;font-size:14px;
  }

  .divider{width:1px;align-self:stretch;background:var(--border);margin:0 2px;}
  .stat{display:flex;flex-direction:column;gap:6px;padding-bottom:2px;}
  .stat-label{font-size:13px;color:var(--ink-soft);font-weight:600;}
  .stat-value{font-size:30px;font-weight:800;color:var(--green);}
  .stat-value span{font-size:15px;font-weight:700;color:var(--grey);}

  /* ---------- Table ---------- */
  .table-card{
    margin-top:26px;background:var(--card);border:1px solid var(--border);
    border-radius:18px;box-shadow:var(--shadow);overflow:hidden;
  }
  table{width:100%;border-collapse:collapse;}
  thead th{
    text-align:left;font-size:11.5px;font-weight:800;letter-spacing:.08em;
    color:var(--grey);text-transform:uppercase;
    padding:18px 22px;border-bottom:1px solid var(--border);background:#FCFCFB;
  }
  thead th.num{text-align:left;}
  tbody td{padding:14px 22px;border-bottom:1px solid var(--border-soft);vertical-align:middle;}
  tbody tr:last-child td{border-bottom:none;}
  tbody tr{transition:background .15s ease;}
  tbody tr:hover{background:#FBFCFA;}

  .idx{color:var(--grey);font-weight:600;font-size:14px;width:26px;}
  .eleve-cell{display:flex;align-items:center;gap:12px;}
  .avatar{
    width:38px;height:38px;border-radius:50%;background:var(--green-bg);
    color:var(--green-dark);font-weight:800;font-size:12.5px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
  }
  .eleve-name{font-weight:700;font-size:14.5px;color:var(--ink);}
  .eleve-id{font-size:12.5px;color:var(--grey);margin-top:1px;}

  .grade-input{
    width:70px;text-align:center;font-family:inherit;font-weight:700;font-size:14.5px;color:var(--ink);
    background:var(--card);border:1px solid var(--border);border-radius:9px;padding:9px 6px;
  }
  .grade-input.comp{background:var(--green-bg);border-color:#CFE7DA;}
  .grade-input:focus-visible{outline:2px solid var(--green);outline-offset:1px;}
  .grade-input.invalid{border-color:#D14343;background:#FDEDED;}

  .moyenne-val{font-weight:800;font-size:16px;color:var(--green);}

  .pill{
    display:inline-flex;align-items:center;gap:7px;
    background:var(--green-bg);color:var(--green-dark);
    font-size:13px;font-weight:700;padding:7px 13px;border-radius:999px;
  }
  .pill .pdot{width:6px;height:6px;border-radius:50%;background:var(--green);}
  .pill.low{background:#FBECEC;color:#A83232;}
  .pill.low .pdot{background:#C24444;}
  .pill.mid{background:#FBF3E4;color:#946A0E;}
  .pill.mid .pdot{background:#C7940E;}

  tfoot td{
    padding:16px 22px;font-size:13px;color:var(--grey);
  }

  /* ---------- Toast ---------- */
  .toast{
    position:fixed;left:50%;bottom:32px;transform:translate(-50%,20px);
    background:var(--green-dark);color:#fff;
    padding:14px 22px;border-radius:12px;font-size:14px;font-weight:600;
    display:flex;align-items:center;gap:10px;
    box-shadow:0 12px 28px -8px rgba(0,0,0,0.35);
    opacity:0;pointer-events:none;transition:opacity .25s ease, transform .25s ease;
    z-index:50;
  }
  .toast.show{opacity:1;transform:translate(-50%,0);}
  .toast svg{width:16px;height:16px;flex-shrink:0;}

  @media (max-width:900px){
    .page{padding:0 18px 48px;}
    header.topbar{padding:18px;}
    h1.title{font-size:34px;}
    .hero{padding:30px 0 22px;}
    .filters-card{padding:20px;}
    .divider{display:none;}
    .stat{flex:1 1 100%;}
    thead{display:none;}
    table, tbody, tr, td{display:block;width:100%;}
    tbody tr{padding:16px 20px;border-bottom:1px solid var(--border);}
    tbody td{padding:6px 0;border:none;}
    .eleve-cell{margin-bottom:8px;}
    .grade-input{width:72px;}
  }
  @media (prefers-reduced-motion: reduce){
    *{transition:none !important;}
  }
</style>
</head>
<body>

<header class="topbar">
  <div class="brand">GROUPE SCOLAIRE AL AMAL</div>
  <div class="top-right">
    <div class="year-pill"><span class="dot"></span>2025–2026</div>
    <button class="icon-btn" aria-label="Notifications">
      <span class="badge-dot"></span>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    </button>
    <div class="user">
      <div class="avatar-user">FS</div>
      <div class="user-meta">
        <div class="user-name"><?=$user['prenom'].' '.$user['nom']?></div>
        <div class="user-role"><?=$user['nom_role']?></div>
      </div>
      <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
    </div>
  </div>
</header>

<div class="page">

  <div class="hero">
    <div>
      <div class="eyebrow">PÉDAGOGIE</div>
      <h1 class="title">Saisie des notes</h1>
      <p class="subtitle">Une grille simple, rapide et contrôlée. Les moyennes sont recalculées instantanément.</p>
    </div>
    <div class="hero-actions">
      <button class="btn btn-ghost" id="importBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Importer
      </button>
      <button class="btn btn-primary" id="saveBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        Enregistrer
      </button>
    </div>
  </div>

  <form action="http://localhost:8000/saisi/note" method="POST" class="filters-card" id="filtersCard">
    <div class="field">
      <label for="classe">Classe</label>
      <div class="select-wrap">
        <select name="classe" id="classe">
             <option value=""></option>
            <?php foreach ($classes as  $classe): ?>
          <option value="<?= $classe['id']?>"><?= $classe['nom_niveau']?></option>
          <?php endforeach?>
        </select>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
      </div>
    </div>

    <div class="field">
      <label for="matiere">Matière</label>
      <div class="select-wrap">
        <select name="matiere" id="classe">
            <option value=""></option>
            <?php foreach ($matieres as  $matiere): ?>
          <option value="<?= $matiere['id']?>"><?= $matiere['nom_matiere']?></option>
          <?php endforeach?>
        </select>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
      </div>
    </div>

    <div class="field">
      <label for="periode">Période</label>
      <div class="select-wrap">
       <select name="periode" id="classe">
           <option value=""></option>
           <?php foreach ($periodes as  $periode): ?>
            <option value="<?=$periode['id']?>"><?=$periode['nom_periode']?></option>
            <?php endforeach?>
        </select>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
      </div>
    </div>

    <!-- Bouton de validation demandé, placé juste après le champ Période -->
    <div class="field validate-field">
      <label for="validateBtn">Valider</label>
      <button class="btn btn-validate" id="validateBtn" type="submit">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        Valider
      </button>
    </div>

    <div class="divider"></div>

    <div class="stat">
      <div class="stat-label">Moyenne de classe</div>
      <div class="stat-value" id="classAvg"><?=$moyenne?><span>/20</span></div>
    </div>
    </form>

  <div class="table-card">
    <?php if (!empty($notes) && $notes[0]['statut'] === 'NOT_ENSEIGNEE'): ?>

    <div>
        Cette matière n'est pas enseignée dans cette classe.
    </div>

<?php else: ?>
    <table>
      <thead>
        <tr>
          <th class="num">Élève</th>
          <th class="num">Devoir 1 /20</th>
          <th class="num">Devoir 2 /20</th>
          <th class="num">Composition /20</th>
          <th class="num">Moyenne</th>
          <th class="num">Appréciation</th>
        </tr>
      </thead>
      <tbody id="tbody">
        <!-- lignes générées par JS -->
          <?php foreach ($notes as $note): ?>
            <tr>
           <td>
              <div class="eleve-name"><?=$note['nomcomplet']?></div>
              <div class="eleve-id"><?=$note['matricule']?></div>
            </div>
          </div>
        </td>
        <td><input class="grade-input" type="number" value="<?=$note['devoir1']?>" ></td>
        <td><input class="grade-input" type="number" value="<?=$note['devoir2']?>" ></td>
        <td><input class="grade-input comp" type="number" value="<?=$note['composition']?>" ></td>
        <td><span class="moyenne-val" ><?=$note['moyenne']?></span></td>
        <td><span class="pill"><?=$note['appreciation']?></span></td>
     
          </tr>
        <?php endforeach; ?>

      </tbody>
      <tfoot>
        <tr><td colspan="6">Navigation clavier disponible · valeurs limitées de 0 à 20</td></tr>
      </tfoot>
    </table>
    <?php endif; ?>
  </div>

</div>

<div class="toast" id="toast">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
  <span id="toastText">Enregistré</span>
</div>

<script>
(function(){
  const students = [
    { id: "JE-26002", name: "Moussa Fall",   d1: 15, d2: 14, comp: 16 },
    { id: "JE-26003", name: "Fatou Ndiaye",  d1: 12, d2: 13, comp: 12 },
    { id: "JE-26004", name: "Ibrahima Diallo", d1: 17, d2: 16, comp: 18 },
    { id: "JE-26005", name: "Khadija Sow",   d1: 10, d2: 11, comp: 12 },
    { id: "JE-26006", name: "Ousmane Faye",  d1: 14, d2: 15, comp: 15 },
  ];

  const tbody = document.getElementById('tbody');
  const classAvgEl = document.getElementById('classAvg');
  const filtersCard = document.getElementById('filtersCard');
  const validateBtn = document.getElementById('validateBtn');
  const toast = document.getElementById('toast');
  const toastText = document.getElementById('toastText');

  function initials(name){
    return name.split(' ').map(w => w[0]).slice(0,2).join('').toUpperCase();
  }

  function appreciationFor(avg){
    if (avg >= 16) return { label: 'Très bien', cls: '' };
    if (avg >= 14) return { label: 'Bien', cls: '' };
    if (avg >= 12) return { label: 'Assez bien', cls: '' };
    if (avg >= 10) return { label: 'Passable', cls: 'mid' };
    return { label: 'Insuffisant', cls: 'low' };
  }

  function computeAvg(d1, d2, comp){
    const vals = [d1, d2, comp].filter(v => !isNaN(v));
    if (!vals.length) return 0;
    return vals.reduce((a,b) => a+b, 0) / vals.length;
  }

  function render(){
    tbody.innerHTML = '';
    students.forEach((s, i) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
         `;
      tbody.appendChild(tr);
    });
    updateAll();
  }

  function updateAll(){
    let total = 0;
    students.forEach((s, i) => {
      const avg = computeAvg(s.d1, s.d2, s.comp);
      const moyEl = tbody.querySelector(`[data-moy="${i}"]`);
      moyEl.textContent = avg.toFixed(2);
      const app = appreciationFor(avg);
      const pill = tbody.querySelector(`[data-app="${i}"]`);
      pill.classList.remove('low','mid');
      if (app.cls) pill.classList.add(app.cls);
      pill.querySelector('.app-label').textContent = app.label;
      total += avg;
    });
    const classAvg = total / students.length;
    classAvgEl.innerHTML = classAvg.toFixed(2) + '<span>/20</span>';
  }

  tbody.addEventListener('input', (e) => {
    const t = e.target;
    if (!t.classList.contains('grade-input')) return;
    const idx = Number(t.dataset.idx);
    const field = t.dataset.field;
    let val = parseFloat(t.value);
    if (isNaN(val)) val = 0;
    if (val < 0) val = 0;
    if (val > 20) val = 20;
    t.classList.toggle('invalid', t.value !== '' && (parseFloat(t.value) < 0 || parseFloat(t.value) > 20));
    students[idx][field] = val;
    updateAll();
  });

  // Navigation clavier simple (flèches gauche/droite/haut/bas) entre champs de notes
  tbody.addEventListener('keydown', (e) => {
    if (!e.target.classList.contains('grade-input')) return;
    const inputs = Array.from(tbody.querySelectorAll('.grade-input'));
    const pos = inputs.indexOf(e.target);
    let next = -1;
    if (e.key === 'ArrowRight') next = pos + 1;
    if (e.key === 'ArrowLeft') next = pos - 1;
    if (e.key === 'ArrowDown') next = pos + 3;
    if (e.key === 'ArrowUp') next = pos - 3;
    if (next >= 0 && next < inputs.length){
      e.preventDefault();
      inputs[next].focus();
      inputs[next].select();
    }
  });

  function showToast(text){
    toastText.textContent = text;
    toast.classList.add('show');
    clearTimeout(showToast._t);
    showToast._t = setTimeout(() => toast.classList.remove('show'), 2400);
  }

  // ---- Bouton Valider (après le champ Période) ----
  validateBtn.addEventListener('click', () => {
    const classe = document.getElementById('classe').value;
    const matiere = document.getElementById('matiere').value;
    const periode = document.getElementById('periode').value;

    filtersCard.classList.add('flash');
    setTimeout(() => filtersCard.classList.remove('flash'), 600);

    validateBtn.classList.add('is-valid');
    validateBtn.innerHTML = `
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      Sélection validée`;
    setTimeout(() => {
      validateBtn.classList.remove('is-valid');
      validateBtn.innerHTML = `
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        Valider`;
    }, 1800);

    showToast(`Sélection validée · ${classe} · ${matiere} · ${periode}`);
  });

  // ---- Enregistrer ----
  document.getElementById('saveBtn').addEventListener('click', () => {
    showToast('Notes enregistrées · moyennes recalculées');
  });

  // ---- Importer (placeholder) ----
  document.getElementById('importBtn').addEventListener('click', () => {
    showToast('Import de notes — sélectionnez un fichier CSV');
  });

  ['classe','matiere','periode'].forEach(id => {
    document.getElementById(id).addEventListener('change', () => {
      validateBtn.classList.remove('is-valid');
    });
  });

  render();
})();
</script>

</body>
</html>