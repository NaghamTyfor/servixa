{{-- resources/views/admin/sub-categories/index.blade.php --}}
@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/src/sweetalerts2/sweetalerts2.css')}}">
    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
    @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
    @vite(['resources/scss/light/assets/elements/custom-pagination.scss','resources/scss/dark/assets/elements/custom-pagination.scss'])
    <style>
        :root{--pp:#7c3aed;--pl:#a78bfa;--pd:#5b21b6;--ps:#ede9fe;--pg:rgba(124,58,237,.22);--r:24px;--t:.3s cubic-bezier(.4,0,.2,1)}
        @keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        @keyframes scaleIn{from{opacity:0;transform:scale(.95)}to{opacity:1;transform:scale(1)}}
        @keyframes shimmer{0%{background-position:-200% center}100%{background-position:200% center}}
        @keyframes countUp{from{opacity:0;transform:translateY(60%)}to{opacity:1;transform:translateY(0)}}
        @keyframes spin{to{transform:rotate(360deg)}}

        .page-header-modern{position:relative;background:linear-gradient(135deg,#2e1065 0%,#5b21b6 40%,#7c3aed 80%,#a78bfa 100%);border-radius:32px;padding:2rem 2.5rem;margin-bottom:2rem;overflow:hidden;box-shadow:0 20px 40px -15px rgba(124,58,237,.3);animation:slideUp .6s cubic-bezier(.22,1,.36,1)}
        .hbg{position:absolute;inset:0;pointer-events:none;background-image:radial-gradient(circle at 30% 40%,rgba(255,255,255,.08) 0%,transparent 30%),radial-gradient(circle at 80% 70%,rgba(255,255,255,.05) 0%,transparent 40%),repeating-linear-gradient(45deg,rgba(255,255,255,.02) 0px,rgba(255,255,255,.02) 2px,transparent 2px,transparent 8px)}
        .hc{position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem}
        .hta{display:flex;align-items:center;gap:1.2rem}
        .hicon{width:64px;height:64px;background:rgba(255,255,255,.15);backdrop-filter:blur(8px);border-radius:18px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,.25);box-shadow:0 8px 20px rgba(0,0,0,.15)}
        .hicon svg{width:32px;height:32px;stroke:white;stroke-width:1.8}
        .ht h1{font-size:2.2rem;font-weight:800;color:white;margin:0;letter-spacing:-.02em;line-height:1.2;text-shadow:0 2px 10px rgba(0,0,0,.2)}
        .ht p{color:rgba(255,255,255,.7);margin:.3rem 0 0;font-size:.95rem}
        .hsc{display:flex;gap:.75rem}
        .hstat{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.16);backdrop-filter:blur(8px);border-radius:14px;padding:.65rem 1rem;min-width:95px;text-align:center}
        .hstat-n{font-size:1.5rem;font-weight:800;color:#fff;line-height:1;display:block;overflow:hidden}
        .hstat-n span{display:block;animation:countUp .6s cubic-bezier(.22,1,.36,1) .5s both}
        .hstat-l{font-size:.63rem;font-weight:500;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.05em;margin-top:2px}
        .back-link{display:inline-flex;align-items:center;gap:.4rem;color:var(--pp);font-weight:600;text-decoration:none;margin-bottom:1rem;transition:gap .2s}
        .back-link:hover{gap:.7rem}

        .toolbar{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap}
        .tl{display:flex;align-items:center;gap:.75rem;flex:1;flex-wrap:wrap}
        .tr{display:flex;align-items:center;gap:.75rem}
        .tsearch{position:relative;min-width:260px;flex:1;max-width:360px}
        .tsearch input{width:100%;border-radius:12px;padding:.7rem 2.8rem .7rem 2.8rem;border:2px solid #e0d4fd;background:#fff;font-size:.9rem;color:#1e293b;transition:all var(--t);outline:none}
        body.dark .tsearch input{background:#1e1b2e;border-color:rgba(124,58,237,.3);color:#e2e8f0}
        .tsearch input:focus{border-color:var(--pp);box-shadow:0 0 0 4px var(--pg)}
        .sico{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:var(--pl);pointer-events:none}
        .sspinner{position:absolute;right:1rem;top:50%;transform:translateY(-50%);width:16px;height:16px;border:2px solid rgba(124,58,237,.2);border-top-color:var(--pp);border-radius:50%;animation:spin .6s linear infinite;display:none}
        .btn-sel-all{display:flex;align-items:center;gap:.5rem;background:var(--ps);border:2px solid #ddd6fe;border-radius:60px;padding:.5rem 1.2rem;cursor:pointer;transition:all var(--t);font-size:.85rem;font-weight:600;color:var(--pd)}
        body.dark .btn-sel-all{background:rgba(124,58,237,.15);border-color:rgba(124,58,237,.3);color:var(--pl)}
        .btn-sel-all:hover{background:var(--pp);color:#fff;border-color:var(--pp)}
        .btn-sel-all input{width:16px;height:16px;accent-color:var(--pp)}
        .btn-bulk{display:none;align-items:center;gap:.5rem;padding:.5rem 1.2rem;border-radius:60px;background:#fef2f2;border:2px solid #fecaca;color:#dc2626;font-size:.85rem;font-weight:600;cursor:pointer;transition:all var(--t)}
        body.dark .btn-bulk{background:rgba(220,38,38,.1);border-color:rgba(220,38,38,.3);color:#f87171}
        .btn-bulk.visible{display:inline-flex;animation:scaleIn .2s ease}
        .btn-bulk:hover{background:#dc2626;color:#fff;border-color:#dc2626}
        .btn-add{display:inline-flex;align-items:center;gap:.6rem;padding:.7rem 1.8rem;border-radius:60px;background:linear-gradient(135deg,var(--pp),var(--pd));color:#fff;font-size:.9rem;font-weight:700;text-decoration:none;box-shadow:0 8px 18px -6px var(--pp);transition:all var(--t);position:relative;overflow:hidden}
        .btn-add::after{content:'';position:absolute;inset:0;background:linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent);background-size:200% auto;animation:shimmer 3s linear infinite;pointer-events:none}
        .btn-add:hover{transform:translateY(-2px);box-shadow:0 12px 24px -8px var(--pp);color:#fff}

        .cat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem}
        .cat-card{background:#fff;border:1.5px solid #f0eeff;border-radius:var(--r);overflow:hidden;position:relative;transition:transform .3s,box-shadow .3s,border-color .2s;animation:scaleIn .5s ease both;box-shadow:0 6px 14px rgba(0,0,0,.02);cursor:pointer}
        body.dark .cat-card{background:#1e1b2e;border-color:rgba(124,58,237,.2)}
        .cat-card:hover{transform:translateY(-5px);box-shadow:0 18px 30px -10px var(--pg);border-color:var(--pl)}
        .cat-card.selected{border-color:var(--pp);box-shadow:0 0 0 3px var(--pg)}
        .accent-bar{height:4px;background:linear-gradient(90deg,var(--pd),var(--pp),var(--pl));background-size:200% auto;animation:shimmer 3s linear infinite;transform:scaleX(0);transform-origin:left;transition:transform .4s}
        .cat-card:hover .accent-bar{transform:scaleX(1)}
        .card-head{padding:1.2rem 1.2rem .5rem;display:flex;align-items:flex-start;justify-content:space-between}
        .card-icon{width:50px;height:50px;border-radius:16px;background:var(--ps);display:flex;align-items:center;justify-content:center;transition:all .3s;position:relative;overflow:hidden}
        body.dark .card-icon{background:rgba(124,58,237,.2)}
        .card-icon::before{content:'';position:absolute;inset:0;border-radius:16px;background:linear-gradient(135deg,var(--pd),var(--pp));transform:scale(0);transition:transform .3s}
        .cat-card:hover .card-icon::before{transform:scale(1)}
        .card-icon svg{color:var(--pp);transition:color .3s;position:relative;z-index:1;width:24px;height:24px}
        .cat-card:hover .card-icon svg{color:#fff}
        .card-top-right{display:flex;align-items:center;gap:.5rem}
        .status-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .75rem;border-radius:30px;font-size:.72rem;font-weight:700}
        .s-active{background:#dcfce7;color:#166534}
        .s-inactive{background:#fee2e2;color:#991b1b}
        body.dark .s-active{background:rgba(22,163,74,.15);color:#4ade80}
        body.dark .s-inactive{background:rgba(220,38,38,.15);color:#f87171}
        .sdot{width:6px;height:6px;border-radius:50%;background:currentColor}
        .cb{width:18px;height:18px;accent-color:var(--pp);cursor:pointer}
        .card-names{padding:.3rem 1.2rem .8rem}
        .bilingual{display:grid;grid-template-columns:1fr 1fr;border:1px solid #f0eeff;border-radius:14px;overflow:hidden}
        body.dark .bilingual{border-color:rgba(124,58,237,.2)}
        .nc{padding:.6rem .8rem}
        .nc-ar{border-inline-end:1px solid #f0eeff;background:#fafafe}
        body.dark .nc-ar{border-inline-end-color:rgba(124,58,237,.2);background:rgba(255,255,255,.02)}
        .nc-en{background:#fff}
        body.dark .nc-en{background:rgba(255,255,255,.03)}
        .lang-tag{font-size:.6rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--pl);display:block;margin-bottom:.2rem}
        .name-text{font-size:1rem;font-weight:700;line-height:1.4;color:#1e1b4b;margin:0}
        body.dark .name-text{color:#e2e8f0}
        .nc-ar .name-text{direction:rtl;text-align:right}
        .card-stats{padding:.7rem 1.2rem;border-top:1px solid #f5f3ff}
        body.dark .card-stats{border-color:rgba(124,58,237,.15)}
        .sc{background:#fafafe;border:1px solid #f0eeff;border-radius:12px;padding:.6rem .5rem;text-align:center;transition:all .2s}
        body.dark .sc{background:rgba(255,255,255,.03);border-color:rgba(124,58,237,.15)}
        .cat-card:hover .sc{background:var(--ps);border-color:#ddd6fe}
        .sc-val{font-size:1.2rem;font-weight:800;color:var(--pp);display:block;line-height:1.2}
        .sc-lbl{font-size:.65rem;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.05em}
        .card-foot{padding:.8rem 1.2rem;display:flex;align-items:center;justify-content:space-between;border-top:1px solid #f5f3ff;background:#fafafe}
        body.dark .card-foot{border-color:rgba(124,58,237,.15);background:rgba(255,255,255,.02)}
        .id-badge{font-size:.7rem;font-weight:700;color:var(--pl);background:#f5f3ff;padding:.2rem .8rem;border-radius:40px}
        body.dark .id-badge{background:rgba(124,58,237,.2);color:var(--pl)}
        .actions{display:flex;gap:.5rem;align-items:center}
        .abtn{width:40px;height:40px;border-radius:14px;border:none;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;text-decoration:none}
        .abtn svg{width:20px;height:20px;transition:transform .2s}
        .abtn:hover svg{transform:scale(1.2)}
        .a-view{background:#eff6ff;color:#3b82f6}.a-view:hover{background:#3b82f6;color:white;box-shadow:0 6px 14px rgba(59,130,246,.4)}
        .a-fields{background:#e0e7ff;color:#4338ca}.a-fields:hover{background:#4338ca;color:white;box-shadow:0 6px 14px rgba(67,56,202,.4)}
        .a-edit{background:#fefce8;color:#ca8a04}.a-edit:hover{background:#ca8a04;color:white;box-shadow:0 6px 14px rgba(202,138,4,.4)}
        .a-del{background:#fef2f2;color:#dc2626}.a-del:hover{background:#dc2626;color:white;box-shadow:0 6px 14px rgba(220,38,38,.4)}
        .empty{grid-column:1/-1;text-align:center;padding:4rem 2rem}
        .empty-ico{width:90px;height:90px;background:var(--ps);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem}
        .empty h3{font-size:1.4rem;font-weight:700;color:#374151;margin-bottom:.5rem}
        body.dark .empty h3{color:#e2e8f0}
        .empty p{color:#9ca3af;font-size:.9rem}
        mark{background:rgba(250,204,21,.3);color:#854d0e;border-radius:3px;padding:0 2px}
        .pag{margin-top:2.5rem}
        .pag-wrap{display:flex;align-items:center;gap:8px}
        .pag-wrap .prev,.pag-wrap .next{display:inline-flex;align-items:center;justify-content:center;width:40px!important;height:40px!important;border-radius:50%!important;background:var(--ps)!important;color:var(--pp)!important;border:1px solid #ddd6fe!important;text-decoration:none!important}
        .pag-wrap .prev.dis,.pag-wrap .next.dis{opacity:.5;pointer-events:none;background:#f1f5f9!important;color:#9ca3af!important}
        .pag-wrap .prev:hover:not(.dis),.pag-wrap .next:hover:not(.dis){background:var(--pp)!important;color:#fff!important;border-color:var(--pp)!important}
        .pag-wrap ul{display:flex;gap:6px;margin:0;padding:0;list-style:none}
        .pag-wrap ul li a{display:flex;align-items:center;justify-content:center;width:40px!important;height:40px!important;border-radius:50%!important;background:#fff!important;color:#1e293b!important;border:1px solid transparent!important;transition:all var(--t)!important;text-decoration:none!important;font-weight:600}
        body.dark .pag-wrap ul li a{background:#1e1b2e!important;color:#e2e8f0!important;border-color:rgba(124,58,237,.2)!important}
        .pag-wrap ul li a:hover{background:var(--ps)!important;color:var(--pp)!important;border-color:var(--pp)!important}
        .pag-wrap ul li a.active{background:linear-gradient(135deg,var(--pp),var(--pd))!important;color:#fff!important;border-color:transparent!important;box-shadow:0 4px 10px var(--pg)!important;font-weight:700!important}
    </style>
@endsection

@section('content')
<div class="layout-top-spacing">
    <a href="{{ route('admin.categories.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        {{ __('admin.back_to_categories') }}
    </a>

    <div class="page-header-modern">
        <div class="hbg"></div>
        <div class="hc">
            <div class="hta">
                <div class="hicon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                </div>
                <div class="ht">
                    <h1>{{ __('admin.sub_categories') }}</h1>
                    <p>{{ $category->getTranslation('name', app()->getLocale()) }} · {{ __('admin.sub_categories_of') }}</p>
                </div>
            </div>

        </div>
    </div>

    <div class="toolbar">
        <div class="tl">
            <div class="tsearch">
                <div class="sico"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
                <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="{{ __('admin.search') }}..." autocomplete="off">
                <div class="sspinner" id="searchSpinner"></div>
            </div>
            <label class="btn-sel-all" id="selAllWrap">
                <input type="checkbox" id="selAllCb">
                <span>{{ __('admin.select_all') }}</span>
            </label>
            <button class="btn-bulk" id="btnBulk">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                {{ __('admin.bulk_delete') }} <span id="bulkCnt"></span>
            </button>
        </div>
        <div class="tr">
            @can('sub_categories.create')
            <a href="{{ route('admin.categories.sub-categories.create', $category) }}" class="btn-add">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                {{ __('admin.add_sub_category') }}
            </a>
            @endcan
        </div>
    </div>

    <div id="gridWrap">
        @include('admin.sub-categories.partials.grid')
    </div>
</div>

<form id="bulkForm" method="POST" action="{{ route('admin.categories.sub-categories.bulk-destroy', $category) }}" style="display:none">
    @csrf<input type="hidden" name="ids" id="bulkIds">
</form>
<form id="delForm" method="POST" style="display:none">@csrf @method('DELETE')</form>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script src="{{asset('plugins/src/sweetalerts2/custom-sweetalert.js')}}"></script>
<script>
const searchInput  = document.getElementById('searchInput');
const searchSpinner= document.getElementById('searchSpinner');
const gridWrap     = document.getElementById('gridWrap');
const btnBulk      = document.getElementById('btnBulk');
const bulkCnt      = document.getElementById('bulkCnt');
const bulkIds      = document.getElementById('bulkIds');
const bulkForm     = document.getElementById('bulkForm');
const delForm      = document.getElementById('delForm');
let selectedIds=[], searchTO;
const INDEX_URL = '{{ route('admin.categories.sub-categories.index', $category) }}';

function isDark(){ return document.body.classList.contains('dark'); }

function syncBulk(){
    const cbs=document.querySelectorAll('.row-cb');
    selectedIds=[...document.querySelectorAll('.row-cb:checked')].map(c=>c.value);
    btnBulk.classList.toggle('visible',selectedIds.length>0);
    bulkCnt.textContent=selectedIds.length>0?'('+selectedIds.length+')':'';
    document.querySelectorAll('.cat-card').forEach(c=>c.classList.toggle('selected',!!c.querySelector('.row-cb')?.checked));
    const sa=document.getElementById('selAllCb');
    if(sa){sa.checked=selectedIds.length===cbs.length&&cbs.length>0;sa.indeterminate=selectedIds.length>0&&selectedIds.length<cbs.length;}
}

btnBulk.addEventListener('click',()=>{
    if(!selectedIds.length) return;
    Swal.fire({title:'{{ __('admin.confirm_bulk_delete') }}',text:'{{ __('admin.selected_count') }}: '+selectedIds.length,icon:'warning',
        showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#7c3aed',
        confirmButtonText:'{{ __('admin.delete') }}',cancelButtonText:'{{ __('admin.cancel') }}',reverseButtons:true,
        background:isDark()?'#1e1b2e':'#fff',color:isDark()?'#e2e8f0':'#1e293b'
    }).then(r=>{if(r.isConfirmed){bulkIds.value=JSON.stringify(selectedIds);bulkForm.submit();}});
});

document.getElementById('selAllWrap')?.addEventListener('click',function(e){
    if(e.target.tagName==='INPUT') return;
    const cb=document.getElementById('selAllCb');if(cb){cb.checked=!cb.checked;cb.dispatchEvent(new Event('change'));}
});

function deleteHandler(e){e.preventDefault();e.stopPropagation();
    Swal.fire({title:'{{ __('admin.confirm_delete') }}',text:'{{ __('admin.delete_confirm_msg') }}: '+this.dataset.name,icon:'warning',
        showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#7c3aed',
        confirmButtonText:'{{ __('admin.delete') }}',cancelButtonText:'{{ __('admin.cancel') }}',reverseButtons:true,
        background:isDark()?'#1e1b2e':'#fff',color:isDark()?'#e2e8f0':'#1e293b'
    }).then(r=>{if(r.isConfirmed){delForm.action=this.dataset.url;delForm.submit();}});
}
function cardClick(e){if(e.target.closest('a,button,input,.abtn,.cb')) return;const url=this.dataset.url;if(url)window.location.href=url;}

function bind(){
    document.querySelectorAll('.row-cb').forEach(cb=>{cb.removeEventListener('change',syncBulk);cb.addEventListener('change',syncBulk);});
    document.querySelectorAll('.cat-card').forEach(c=>{c.removeEventListener('click',cardClick);c.addEventListener('click',cardClick);});
    document.querySelectorAll('.a-del').forEach(b=>{b.removeEventListener('click',deleteHandler);b.addEventListener('click',deleteHandler);});
    const sa=document.getElementById('selAllCb');
    if(sa){sa.removeEventListener('change',saChange);sa.addEventListener('change',saChange);}
    syncBulk();
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el=>new bootstrap.Tooltip(el));
}
function saChange(){document.querySelectorAll('.row-cb').forEach(c=>c.checked=this.checked);syncBulk();}

if(searchInput){
    searchInput.addEventListener('input',function(){
        searchSpinner.style.display='block';
        clearTimeout(searchTO);
        searchTO=setTimeout(()=>doSearch(this.value.trim()),300);
    });
}
function doSearch(val){
    const url=new URL(INDEX_URL);
    if(val)url.searchParams.set('search',val);else url.searchParams.delete('search');
    url.searchParams.set('page','1');
    window.history.pushState({},'',url.toString());
    fetch(url.toString(),{headers:{'X-Requested-With':'XMLHttpRequest'}})
        .then(r=>r.text()).then(html=>{
            const doc=new DOMParser().parseFromString(html,'text/html');
            const nc=doc.getElementById('gridWrap');
            if(nc)gridWrap.innerHTML=nc.innerHTML;
            bind();highlight();
            searchSpinner.style.display='none';
        }).catch(()=>{searchSpinner.style.display='none';});
}
function highlight(){
    const term=new URLSearchParams(window.location.search).get('search');
    if(!term) return;
    const rx=new RegExp(`(${term.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`,'gi');
    document.querySelectorAll('.name-text').forEach(el=>{el.innerHTML=el.innerText.replace(rx,'<mark>$1</mark>');});
}
window.addEventListener('popstate',()=>{const v=new URLSearchParams(window.location.search).get('search')||'';if(searchInput)searchInput.value=v;doSearch(v);});

document.addEventListener('DOMContentLoaded',()=>{
    bind();highlight();
    @if(session('success'))
    Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:3500,timerProgressBar:true,
        didOpen:t=>{t.addEventListener('mouseenter',Swal.stopTimer);t.addEventListener('mouseleave',Swal.resumeTimer);}
    }).fire({icon:'success',title:'{{ session('success') }}'});
    @endif
});
</script>
@endsection
