<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Galeri Seni</title>
<style>
:root{
  --glass:rgba(255,255,255,.16);--glass-strong:rgba(60,52,46,.38);--edge:rgba(255,255,255,.45);
  --text:#fff;--muted:rgba(255,255,255,.72);--wall:#8d867d;--floor:#6e5a47;
}
*{box-sizing:border-box;margin:0}
html,body{height:100%}
body{font-family:"Avenir Next","Segoe UI",system-ui,sans-serif;color:var(--text);overflow:hidden;
  background:
    linear-gradient(180deg,#4a4038 0,#7d756c 12%,#a29b92 52%,transparent 52%),
    linear-gradient(180deg,transparent 52%,#8a7157 52%,#5e4a38 100%);}
body::before{content:"";position:fixed;inset:0;pointer-events:none;
  background:radial-gradient(ellipse at 50% 40%,transparent 30%,rgba(0,0,0,.35));}
.glass{background:var(--glass);border:1px solid var(--edge);backdrop-filter:blur(22px) saturate(1.4);
  -webkit-backdrop-filter:blur(22px) saturate(1.4);box-shadow:0 10px 40px rgba(0,0,0,.28)}
button{font:inherit;color:inherit;border:0;cursor:pointer;background:none}
button:focus-visible,input:focus-visible,textarea:focus-visible{outline:2px solid #fff;outline-offset:2px}
.round{width:36px;height:36px;border-radius:50%;display:grid;place-items:center;background:rgba(255,255,255,.2);transition:background .2s}
.round:hover{background:rgba(255,255,255,.38)}
.round.on{background:#fff;color:#3b332c}
svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

#bar{position:fixed;top:18px;left:50%;transform:translateX(-50%);width:min(760px,94vw);height:56px;border-radius:30px;
  display:flex;align-items:center;gap:8px;padding:0 10px;z-index:5}
#bar .addr{flex:1;height:36px;border-radius:18px;background:rgba(0,0,0,.2);display:flex;align-items:center;justify-content:center;font-size:14px;color:var(--muted);padding:0 14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}

#tools{position:fixed;left:max(10px,calc(50% - 560px));top:50%;transform:translateY(-50%);z-index:5;
  display:flex;flex-direction:column;gap:10px;padding:10px;border-radius:30px}

#stage{position:fixed;inset:0;perspective:1400px;display:grid;place-items:center;padding-bottom:40px}
.card{position:absolute;width:min(420px,78vw);height:min(470px,58vh);border-radius:34px;overflow:hidden;cursor:pointer;
  border:1px solid var(--edge);box-shadow:0 24px 60px rgba(0,0,0,.4);
  transition:transform .6s cubic-bezier(.2,.8,.2,1),opacity .5s,filter .5s;background:#2a2622}
.card .pic{position:absolute;inset:0;background-size:cover;background-position:center}
.card .cap{position:absolute;left:0;right:0;bottom:0;padding:18px 24px 20px;
  background:linear-gradient(180deg,rgba(40,34,30,0),rgba(40,34,30,.78) 28%);
  backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);
  -webkit-mask:linear-gradient(180deg,transparent,#000 24%);mask:linear-gradient(180deg,transparent,#000 24%);
  padding-top:44px;transition:opacity .4s}
.card:not(.active) .cap{opacity:0}
.cap .row{display:flex;justify-content:space-between;align-items:baseline;gap:10px}
.cap h2{font-size:19px;font-weight:500;letter-spacing:.01em}
.cap time{font-size:11px;font-weight:600;color:var(--muted)}
.cap blockquote{font-size:16.5px;line-height:1.38;margin:8px 0 10px;font-weight:500}
.cap small{display:block;font-size:11.5px;color:var(--muted);line-height:1.5}
.card .top{position:absolute;top:14px;left:14px;right:14px;display:flex;justify-content:space-between;align-items:center;transition:opacity .3s}
.card:not(.active) .top{opacity:0;pointer-events:none}
.pill{padding:8px 16px;border-radius:18px;font-size:14px;font-weight:600;display:flex;gap:6px;align-items:center;background:rgba(255,255,255,.26);backdrop-filter:blur(12px)}

#artist{position:fixed;bottom:62px;left:50%;transform:translateX(-50%);width:min(380px,92vw);height:78px;border-radius:30px;
  display:flex;align-items:center;justify-content:space-between;padding:0 14px;z-index:5}
#artist .who{display:flex;align-items:center;gap:12px;min-width:0;flex:1;justify-content:center}
#artist .av{width:54px;height:54px;border-radius:16px;flex:none;background:#c9a27a center/cover;display:grid;place-items:center;font-weight:700;font-size:22px;color:#3b332c}
#artist b{display:block;font-size:13.5px;font-weight:600}
#artist span{display:block;font-size:11px;color:var(--muted);line-height:1.45}
#dots{position:fixed;bottom:30px;left:50%;transform:translateX(-50%);display:flex;gap:6px;align-items:center;z-index:5}
#dots i{width:7px;height:7px;border-radius:4px;background:rgba(255,255,255,.55);transition:width .3s,background .3s;cursor:pointer}
#dots i.on{width:44px;background:#fff}
#empty{position:fixed;inset:0;display:none;place-items:center;text-align:center;color:var(--muted);z-index:2;padding:20px}

dialog{border:1px solid var(--edge);border-radius:28px;padding:0;margin:auto;color:#fff;width:min(460px,92vw);
  background:rgba(58,50,44,.72);backdrop-filter:blur(30px);-webkit-backdrop-filter:blur(30px)}
dialog::backdrop{background:rgba(0,0,0,.5)}
form{padding:24px;display:grid;gap:12px}
form h3{font-size:19px;font-weight:600}
label{font-size:12.5px;color:var(--muted);display:grid;gap:5px}
input,textarea{font:inherit;font-size:14px;color:#fff;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.25);border-radius:12px;padding:10px 12px;width:100%}
input::placeholder,textarea::placeholder{color:rgba(255,255,255,.4)}
.two{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.acts{display:flex;gap:10px;justify-content:flex-end;margin-top:4px}
.btn{padding:10px 20px;border-radius:20px;background:rgba(255,255,255,.2);font-weight:600;font-size:14px}
.btn.main{background:#fff;color:#3b332c}
#err{font-size:12.5px;color:#ffc9b8;min-height:16px}
#lb{border-radius:0;width:100vw;height:100vh;max-width:none;max-height:none;background:rgba(10,8,6,.92)}
#lb img{position:absolute;inset:0;margin:auto;max-width:94vw;max-height:90vh;border-radius:12px}
#lb .round{position:absolute;top:18px;right:18px}
@media (max-width:760px){#tools{top:auto;bottom:150px;left:10px;transform:none;flex-direction:row;border-radius:26px}
  .cap blockquote{font-size:14.5px}}
@media (prefers-reduced-motion:reduce){*{transition:none!important}}
</style>
</head>
<body>

<header id="bar" class="glass">
  <button class="round" id="prev2" aria-label="Sebelumnya"><svg viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6"/></svg></button>
  <button class="round" id="next2" aria-label="Berikutnya"><svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"/></svg></button>
  <div class="addr" id="addr">Galeri Seni</div>
  <button class="round" id="add" aria-label="Tambah karya dari URL"><svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg></button>
  <button class="round" id="share" aria-label="Salin tautan gambar"><svg viewBox="0 0 24 24"><path d="M12 15V4M8 8l4-4 4 4M5 13v6h14v-6"/></svg></button>
</header>

<nav id="tools" class="glass" aria-label="Filter">
  <button class="round on" id="fAll" aria-label="Semua karya"><svg viewBox="0 0 24 24"><path d="M4 20l9-9M13 11l3-6 4 4-6 3zM4 20l3-1 1-3"/></svg></button>
  <button class="round" id="fFav" aria-label="Favorit"><svg viewBox="0 0 24 24"><path d="M12 20s-7-4.4-7-10a4 4 0 017-2.6A4 4 0 0119 10c0 5.6-7 10-7 10z"/></svg></button>
  <button class="round" id="edit" aria-label="Ubah karya ini"><svg viewBox="0 0 24 24"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg></button>
  <button class="round" id="del" aria-label="Hapus karya ini"><svg viewBox="0 0 24 24"><path d="M5 7h14M10 7V4h4v3M7 7l1 13h8l1-13"/></svg></button>
</nav>

<main id="stage" aria-live="polite"></main>
<div id="empty">Belum ada karya di sini.<br>Tekan + untuk menambah gambar dari URL.</div>

<section id="artist" class="glass">
  <button class="round" id="prev" aria-label="Karya sebelumnya"><svg viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6"/></svg></button>
  <div class="who"><div class="av" id="av"></div><div><b id="aName"></b><span id="aInfo"></span></div></div>
  <button class="round" id="next" aria-label="Karya berikutnya"><svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"/></svg></button>
</section>
<div id="dots"></div>

<dialog id="dlg">
  <form id="form" method="dialog">
    <h3 id="dTitle">Tambah karya dari URL</h3>
    <label>URL gambar *<input id="fUrl" type="url" placeholder="https://contoh.com/lukisan.jpg" required></label>
    <label>Judul *<input id="fTitle" required></label>
    <div class="two">
      <label>Seniman<input id="fArtist"></label>
      <label>Tahun<input id="fYear" placeholder="1889"></label>
    </div>
    <label>Kutipan / deskripsi<textarea id="fQuote" rows="2"></textarea></label>
    <div class="two">
      <label>Medium<input id="fMed" placeholder="Cat minyak di kanvas"></label>
      <label>Ukuran<input id="fSize" placeholder="73 × 92 cm"></label>
    </div>
    <label>Info seniman<input id="fLife" placeholder="1853 – 1890 · Zundert, Belanda"></label>
    <label>URL foto seniman (opsional)<input id="fAv" type="url"></label>
    <div id="err" role="alert"></div>
    <div class="acts">
      <button type="button" class="btn" id="cancel">Batal</button>
      <button type="submit" class="btn main">Simpan karya</button>
    </div>
  </form>
</dialog>
<dialog id="lb"><button class="round" id="lbx" aria-label="Tutup"><svg viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></svg></button><img alt=""></dialog>

<script>
let works=[];
const API="api.php";
let KEY=sessionStorage.getItem("gk")||"";
async function api(action,data){
  const r=await fetch(API+"?action="+action,{method:"POST",headers:{"Content-Type":"application/json","X-Admin-Key":KEY},body:JSON.stringify(data||{})});
  if(r.status===401){
    KEY=prompt("Masukkan kata sandi admin:")||"";sessionStorage.setItem("gk",KEY);
    if(KEY)return api(action,data);
    throw new Error("Perlu kata sandi admin.");
  }
  const j=await r.json();
  if(!j.ok)throw new Error(j.error||"Gagal");
  return j;
}
async function load(){
  try{const r=await fetch(API+"?action=list");const j=await r.json();if(!j.ok)throw 0;works=j.data;build()}
  catch(e){$("empty").style.display="grid";$("empty").textContent="Tidak bisa terhubung ke database. Periksa config.php."}
}

const $=id=>document.getElementById(id);
let idx=0,mode="all",view=[];
const stage=$("stage");

function esc(s){const d=document.createElement("div");d.textContent=s||"";return d.innerHTML}
function build(){
  view=works.filter(w=>mode==="all"||w.fav);
  idx=Math.min(idx,Math.max(view.length-1,0));
  stage.innerHTML="";
  view.forEach((w,i)=>{
    const c=document.createElement("article");c.className="card";
    c.innerHTML=`<div class="pic"></div>
      <div class="top"><button class="round" data-a="fav" aria-label="Favorit"><svg viewBox="0 0 24 24" ${w.fav?'style="fill:#fff"':''}><path d="M12 20s-7-4.4-7-10a4 4 0 017-2.6A4 4 0 0119 10c0 5.6-7 10-7 10z"/></svg></button>
      <button class="pill" data-a="expand"><svg viewBox="0 0 24 24"><path d="M14 4h6v6M10 20H4v-6M20 4l-7 7M4 20l7-7"/></svg>Perbesar</button>
      <span style="width:36px"></span></div>
      <div class="cap"><div class="row"><h2>${esc(w.title)}</h2><time>${esc(w.year)}</time></div>
      <blockquote>${w.quote?"“"+esc(w.quote)+"”":""}</blockquote>
      <small>${w.medium?"Medium: "+esc(w.medium):""}<br>${w.size?"Ukuran: "+esc(w.size):""}</small></div>`;
    const pic=c.firstChild;pic.style.backgroundImage=`url("${w.url.replace(/"/g,"%22")}")`;
    const probe=new Image();probe.onerror=()=>{pic.style.background="linear-gradient(135deg,#6b5b4b,#2a2622)";
      pic.innerHTML='<p style="padding:30%25 10%25 0;text-align:center;color:#fff9">Gambar tidak bisa dimuat.<br>Periksa URL-nya.</p>'.replace(/%25/g,"%")};probe.src=w.url;
    c.addEventListener("click",e=>{
      const a=e.target.closest("[data-a]");
      if(a&&a.dataset.a==="fav"){w.fav=!w.fav;build();api("fav",{id:w.id,fav:w.fav}).catch(()=>{w.fav=!w.fav;build()});return}
      if(a&&a.dataset.a==="expand"){openLb(w);return}
      go(i);
    });
    stage.appendChild(c);
  });
  $("empty").style.display=view.length?"none":"grid";
  $("dots").innerHTML=view.map((_,i)=>`<i data-i="${i}"></i>`).join("");
  place();
}
function place(){
  const cs=stage.children,narrow=innerWidth<760,gap=narrow?70:230;
  [...cs].forEach((c,i)=>{
    const o=i-idx,a=Math.abs(o);
    c.classList.toggle("active",o===0);
    c.style.transform=`translateX(${o*gap*(narrow?1:1)}px) translateZ(${-a*140}px) rotateY(${-Math.sign(o)*Math.min(a,2)*32}deg) scale(${o===0?1:.82})`;
    c.style.zIndex=10-a;
    c.style.opacity=a>2?0:1-a*.12;
    c.style.pointerEvents=a>2?"none":"auto";
    c.style.filter=o===0?"none":"brightness(.85)";
  });
  [...$("dots").children].forEach((d,i)=>d.classList.toggle("on",i===idx));
  const w=view[idx];
  $("addr").textContent=w?w.title:"Galeri Seni";
  $("aName").textContent=w?w.artist||"Tanpa nama":"";
  $("aInfo").textContent=w?w.life||"":"";
  const av=$("av");
  if(w&&w.av){av.style.backgroundImage=`url("${w.av}")`;av.textContent=""}
  else{av.style.backgroundImage="";av.textContent=w&&w.artist?w.artist[0].toUpperCase():""}
}
function go(i){if(!view.length)return;idx=(i+view.length)%view.length;place()}
function openLb(w){const l=$("lb");l.querySelector("img").src=w.url;l.querySelector("img").alt=w.title;l.showModal()}

["prev","prev2"].forEach(k=>$(k).onclick=()=>go(idx-1));
["next","next2"].forEach(k=>$(k).onclick=()=>go(idx+1));
$("dots").onclick=e=>{if(e.target.dataset.i)go(+e.target.dataset.i)};
document.addEventListener("keydown",e=>{
  if(document.querySelector("dialog[open]"))return;
  if(e.key==="ArrowLeft")go(idx-1);if(e.key==="ArrowRight")go(idx+1)});
let sx=null;
stage.addEventListener("pointerdown",e=>sx=e.clientX);
stage.addEventListener("pointerup",e=>{if(sx!==null&&Math.abs(e.clientX-sx)>60)go(idx+(e.clientX<sx?1:-1));sx=null});
stage.addEventListener("wheel",e=>{e.preventDefault();go(idx+(e.deltaY+e.deltaX>0?1:-1))},{passive:false});
addEventListener("resize",place);

$("fAll").onclick=()=>{mode="all";$("fAll").classList.add("on");$("fFav").classList.remove("on");build()};
$("fFav").onclick=()=>{mode="fav";$("fFav").classList.add("on");$("fAll").classList.remove("on");build()};
$("del").onclick=async()=>{const w=view[idx];if(!w||!confirm(`Hapus "${w.title}"?`))return;try{await api("delete",{id:w.id});works=works.filter(x=>x!==w);build()}catch(e){alert(e.message)}};
$("share").onclick=()=>{const w=view[idx];if(w&&navigator.clipboard){navigator.clipboard.writeText(w.url);$("addr").textContent="URL gambar disalin";setTimeout(place,1400)}};

let editId=null;
$("add").onclick=()=>{editId=null;$("form").reset();$("err").textContent="";$("dTitle").textContent="Tambah karya dari URL";$("dlg").showModal()};
$("edit").onclick=()=>{
  const w=view[idx];if(!w)return;
  editId=w.id;$("form").reset();$("err").textContent="";$("dTitle").textContent="Ubah karya";
  $("fUrl").value=w.url;$("fTitle").value=w.title;$("fArtist").value=w.artist;$("fYear").value=w.year;
  $("fLife").value=w.life;$("fQuote").value=w.quote;$("fMed").value=w.medium;$("fSize").value=w.size;$("fAv").value=w.av;
  $("dlg").showModal();
};
$("cancel").onclick=()=>$("dlg").close();
$("lbx").onclick=()=>$("lb").close();
$("lb").onclick=e=>{if(e.target.id==="lb")$("lb").close()};
$("form").onsubmit=e=>{
  e.preventDefault();
  const url=$("fUrl").value.trim(),t=new Image();
  $("err").textContent="Memeriksa gambar…";
  t.onload=async()=>{
    try{
      const body={url,title:$("fTitle").value.trim(),year:$("fYear").value.trim(),artist:$("fArtist").value.trim(),life:$("fLife").value.trim(),
        quote:$("fQuote").value.trim(),medium:$("fMed").value.trim(),size:$("fSize").value.trim(),av:$("fAv").value.trim()};
      if(editId){
        const j=await api("update",{...body,id:editId});
        const k=works.findIndex(x=>x.id===editId);works[k]=j.item;
        $("dlg").close();build();
      }else{
        const j=await api("add",body);
        works.push(j.item);
        $("dlg").close();mode="all";$("fAll").classList.add("on");$("fFav").classList.remove("on");
        build();go(works.length-1);
      }
    }catch(e){$("err").textContent=e.message}
  };
  t.onerror=()=>$("err").textContent="Gambar tidak bisa dimuat. Pastikan URL langsung mengarah ke file gambar (.jpg, .png, .webp).";
  t.src=url;
};
load();
</script>
</body>
</html>
