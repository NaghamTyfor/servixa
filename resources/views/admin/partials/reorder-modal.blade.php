{{--
    resources/views/admin/partials/reorder-modal.blade.php
    ─────────────────────────────────────────────────────
    Props (passed via @include or component):
      $reorderUrl    – POST endpoint
      $reorderItems  – Collection of items to sort (must have: id, sort_order, + name translations)
      $reorderType   – 'category' | 'sub_category' | 'dynamic_field'
      $reorderTitle  – Modal heading string
--}}

{{-- ─── Modal ─────────────────────────────────────────── --}}
<div class="reorder-modal-backdrop" id="reorderModalBackdrop" aria-hidden="true">
    <div class="reorder-modal" role="dialog" aria-modal="true" aria-labelledby="reorderModalTitle">

        {{-- Header --}}
        <div class="rm-header">
            <div class="rm-header-left">
                <div class="rm-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <div>
                    <h3 class="rm-title" id="reorderModalTitle">{{ $reorderTitle ?? __('admin.reorder_items') }}</h3>
                    <p class="rm-subtitle">{{ __('admin.drag_to_reorder_hint') }}</p>
                </div>
            </div>
            <button class="rm-close" id="reorderModalClose" aria-label="{{ __('admin.close') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="rm-body">
            <ul class="rm-list" id="reorderList">
                @foreach($reorderItems->sortBy('sort_order') as $item)
                <li class="rm-item" data-id="{{ $item->id }}">
                    <div class="rm-drag-handle" title="{{ __('admin.drag_to_reorder') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9"  cy="5"  r="1.2" fill="currentColor" stroke="none"/>
                            <circle cx="15" cy="5"  r="1.2" fill="currentColor" stroke="none"/>
                            <circle cx="9"  cy="12" r="1.2" fill="currentColor" stroke="none"/>
                            <circle cx="15" cy="12" r="1.2" fill="currentColor" stroke="none"/>
                            <circle cx="9"  cy="19" r="1.2" fill="currentColor" stroke="none"/>
                            <circle cx="15" cy="19" r="1.2" fill="currentColor" stroke="none"/>
                        </svg>
                    </div>

                    <div class="rm-pos-badge">
                        <span class="rm-pos-num">{{ $item->sort_order }}</span>
                    </div>

                    <div class="rm-item-icon">
                        @if(($reorderType ?? 'category') === 'dynamic_field')
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        @elseif(($reorderType ?? 'category') === 'sub_category')
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        @endif
                    </div>

                    <div class="rm-item-names">
                        <span class="rm-name-ar" dir="rtl">{{ $item->getTranslation('name', 'ar', false) }}</span>
                        <span class="rm-name-sep">·</span>
                        <span class="rm-name-en">{{ $item->getTranslation('name', 'en', false) }}</span>
                    </div>

                    @if(isset($item->type))
                    <span class="rm-type-badge">{{ $item->type }}</span>
                    @endif

                    @if(isset($item->is_active))
                    <span class="rm-status {{ $item->is_active ? 'rm-status-active' : 'rm-status-inactive' }}"></span>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Footer --}}
        <div class="rm-footer">
            <div class="rm-save-status" id="rmSaveStatus">
                <span class="rm-status-idle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h6v6M14 10l6.1-6.1M9 21H3v-6M10 14l-6.1 6.1"/></svg>
                    {{ __('admin.drag_to_reorder') }}
                </span>
                <span class="rm-status-saving" style="display:none">
                    <span class="rm-spinner"></span>
                    {{ __('admin.saving') }}...
                </span>
                <span class="rm-status-saved" style="display:none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ __('admin.saved') }}
                </span>
                <span class="rm-status-error" style="display:none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ __('admin.error_saving') }}
                </span>
            </div>
            <button class="rm-done-btn" id="reorderModalDone">
                {{ __('admin.done') }}
            </button>
        </div>
    </div>
</div>

{{-- ─── Trigger Button (injected wherever needed) ─── --}}
{{-- Call: @include('admin.partials.reorder-modal-trigger') --}}

{{-- ─── Styles ─────────────────────────────────────── --}}
<style>
/* Backdrop */
.reorder-modal-backdrop {
    position:fixed;inset:0;z-index:9999;
    background:rgba(15,10,40,0.55);
    backdrop-filter:blur(6px);
    display:flex;align-items:center;justify-content:center;padding:1rem;
    opacity:0;pointer-events:none;
    transition:opacity 0.25s ease;
}
.reorder-modal-backdrop.open {
    opacity:1;pointer-events:all;
}

/* Modal */
.reorder-modal {
    background:#fff;border-radius:28px;width:100%;max-width:540px;
    box-shadow:0 40px 80px -20px rgba(124,58,237,0.35),0 0 0 1px rgba(124,58,237,0.1);
    display:flex;flex-direction:column;max-height:85vh;
    transform:scale(0.94) translateY(16px);
    transition:transform 0.3s cubic-bezier(0.22,1,0.36,1);
    overflow:hidden;
}
body.dark .reorder-modal { background:#1c192e;box-shadow:0 40px 80px -20px rgba(0,0,0,0.6),0 0 0 1px rgba(124,58,237,0.2); }
.reorder-modal-backdrop.open .reorder-modal { transform:scale(1) translateY(0); }

/* Header */
.rm-header {
    display:flex;align-items:center;justify-content:space-between;
    padding:1.5rem 1.8rem 1.2rem;
    border-bottom:1px solid #f0eeff;flex-shrink:0;
}
body.dark .rm-header { border-bottom-color:rgba(124,58,237,0.18); }
.rm-header-left { display:flex;align-items:center;gap:1rem; }
.rm-header-icon {
    width:44px;height:44px;border-radius:14px;flex-shrink:0;
    background:linear-gradient(135deg,#7c3aed,#5b21b6);
    display:flex;align-items:center;justify-content:center;color:white;
    box-shadow:0 6px 14px rgba(124,58,237,0.35);
}
.rm-title { font-size:1.05rem;font-weight:800;color:#1e1b4b;margin:0;line-height:1.2; }
body.dark .rm-title { color:#e2e8f0; }
.rm-subtitle { font-size:0.78rem;color:#9ca3af;margin:0.15rem 0 0; }
.rm-close {
    width:36px;height:36px;border-radius:12px;border:none;
    background:#f5f3ff;color:#7c3aed;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    transition:all 0.2s;flex-shrink:0;
}
body.dark .rm-close { background:rgba(124,58,237,0.15);color:#a78bfa; }
.rm-close:hover { background:#7c3aed;color:white;transform:scale(1.1); }

/* Body */
.rm-body { flex:1;overflow-y:auto;padding:1rem 1.2rem; scrollbar-width:thin;scrollbar-color:rgba(124,58,237,0.3) transparent; }
.rm-body::-webkit-scrollbar { width:4px; }
.rm-body::-webkit-scrollbar-track { background:transparent; }
.rm-body::-webkit-scrollbar-thumb { background:rgba(124,58,237,0.3);border-radius:4px; }

/* List */
.rm-list { list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:0.5rem; }

/* Item */
.rm-item {
    display:flex;align-items:center;gap:0.75rem;
    background:#fafafe;border:1.5px solid #ede9fe;border-radius:16px;
    padding:0.75rem 0.9rem;
    cursor:default;
    transition:border-color 0.2s,box-shadow 0.2s,background 0.2s;
    user-select:none;
}
body.dark .rm-item { background:#252040;border-color:rgba(124,58,237,0.2); }
.rm-item:hover { border-color:#a78bfa;box-shadow:0 4px 14px rgba(124,58,237,0.12); }

/* Sortable states */
.rm-item.sortable-chosen {
    background:#f5f3ff !important;
    border-color:#7c3aed !important;
    box-shadow:0 12px 32px -8px rgba(124,58,237,0.35) !important;
    transform:scale(1.02) !important;
    z-index:10;cursor:grabbing !important;
}
body.dark .rm-item.sortable-chosen { background:#2e2650 !important; }

.rm-item.sortable-ghost {
    opacity:0.35;
    border:2px dashed #a78bfa !important;
    background:#ede9fe !important;
    transform:none !important;
    box-shadow:none !important;
}
body.dark .rm-item.sortable-ghost { background:rgba(124,58,237,0.1) !important; }

/* Drag handle */
.rm-drag-handle {
    color:#c4b5fd;cursor:grab;flex-shrink:0;
    display:flex;align-items:center;
    padding:0.2rem;border-radius:8px;
    transition:color 0.2s,background 0.2s;
}
.rm-item:hover .rm-drag-handle { color:#7c3aed; }
.rm-drag-handle:active { cursor:grabbing; }
.rm-drag-handle:hover { background:rgba(124,58,237,0.1); }

/* Position badge */
.rm-pos-badge {
    width:28px;height:28px;border-radius:10px;flex-shrink:0;
    background:#ede9fe;border:1.5px solid #ddd6fe;
    display:flex;align-items:center;justify-content:center;
    transition:all 0.3s ease;
}
body.dark .rm-pos-badge { background:rgba(124,58,237,0.15);border-color:rgba(124,58,237,0.3); }
.rm-pos-num { font-size:0.72rem;font-weight:800;color:#7c3aed;line-height:1; }
body.dark .rm-pos-num { color:#c4b5fd; }

@keyframes posBump { 0%{transform:scale(1)} 40%{transform:scale(1.4);background:#7c3aed;} 70%{transform:scale(0.9)} 100%{transform:scale(1)} }
.rm-pos-badge.bumping {
    animation:posBump 0.4s ease;
    background:#7c3aed;
    border-color:#7c3aed;
}
.rm-pos-badge.bumping .rm-pos-num { color:#fff; }

/* Item icon */
.rm-item-icon {
    width:34px;height:34px;border-radius:12px;flex-shrink:0;
    background:rgba(124,58,237,0.08);
    display:flex;align-items:center;justify-content:center;
    color:#7c3aed;
    transition:all 0.2s;
}
body.dark .rm-item-icon { background:rgba(124,58,237,0.15);color:#a78bfa; }
.rm-item:hover .rm-item-icon { background:#7c3aed;color:#fff; }

/* Names */
.rm-item-names { flex:1;display:flex;align-items:center;gap:0.4rem;min-width:0;overflow:hidden; }
.rm-name-ar { font-size:0.88rem;font-weight:700;color:#1e1b4b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:120px; }
body.dark .rm-name-ar { color:#e2e8f0; }
.rm-name-sep { color:#c4b5fd;font-weight:300;flex-shrink:0; }
.rm-name-en { font-size:0.88rem;font-weight:600;color:#475569;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:120px; }
body.dark .rm-name-en { color:#94a3b8; }

/* Type badge */
.rm-type-badge {
    font-size:0.65rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:20px;
    background:#ede9fe;color:#5b21b6;white-space:nowrap;flex-shrink:0;
}
body.dark .rm-type-badge { background:rgba(124,58,237,0.15);color:#c4b5fd; }

/* Status dot */
.rm-status { width:8px;height:8px;border-radius:50%;flex-shrink:0; }
.rm-status-active  { background:#22c55e; }
.rm-status-inactive { background:#ef4444; }

/* Footer */
.rm-footer {
    display:flex;align-items:center;justify-content:space-between;
    padding:1rem 1.8rem 1.5rem;
    border-top:1px solid #f0eeff;flex-shrink:0;
}
body.dark .rm-footer { border-top-color:rgba(124,58,237,0.18); }
.rm-save-status { display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;font-weight:600; }
.rm-status-idle { display:flex;align-items:center;gap:0.4rem;color:#a78bfa; }
.rm-status-saving { display:flex;align-items:center;gap:0.5rem;color:#64748b; }
body.dark .rm-status-saving { color:#94a3b8; }
.rm-status-saved  { display:flex;align-items:center;gap:0.4rem;color:#059669; }
.rm-status-error  { display:flex;align-items:center;gap:0.4rem;color:#dc2626; }

@keyframes rmSpin { to{transform:rotate(360deg)} }
.rm-spinner { width:13px;height:13px;border:2px solid rgba(124,58,237,0.2);border-top-color:#7c3aed;border-radius:50%;animation:rmSpin 0.6s linear infinite;flex-shrink:0; }

.rm-done-btn {
    display:inline-flex;align-items:center;gap:0.5rem;
    padding:0.65rem 1.8rem;border-radius:50px;border:none;
    background:linear-gradient(135deg,#7c3aed,#5b21b6);
    color:white;font-weight:700;font-size:0.9rem;cursor:pointer;
    box-shadow:0 6px 16px -6px #7c3aed;
    transition:all 0.2s;
}
.rm-done-btn:hover { transform:translateY(-2px);box-shadow:0 12px 24px -8px #7c3aed; }
</style>

{{-- ─── Script ──────────────────────────────────────── --}}
<script>
(function() {
    const REORDER_URL = @json($reorderUrl ?? '');
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    const backdrop  = document.getElementById('reorderModalBackdrop');
    const closeBtn  = document.getElementById('reorderModalClose');
    const doneBtn   = document.getElementById('reorderModalDone');
    const list      = document.getElementById('reorderList');
    const statusEl  = document.getElementById('rmSaveStatus');

    if (!backdrop || !list) return;

    /* ── Open / Close ── */
    window.openReorderModal = function() {
        backdrop.classList.add('open');
        document.body.style.overflow = 'hidden';
    };
    function close() {
        backdrop.classList.remove('open');
        document.body.style.overflow = '';
    }

    closeBtn?.addEventListener('click', close);
    doneBtn?.addEventListener('click', close);
    backdrop.addEventListener('click', e => { if (e.target === backdrop) close(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });

    /* ── Status helpers ── */
    function setStatus(state) {
        statusEl.querySelectorAll('[class^="rm-status-"]').forEach(el => el.style.display = 'none');
        const el = statusEl.querySelector('.rm-status-' + state);
        if (el) el.style.display = 'flex';
    }
    setStatus('idle');

    /* ── Update position numbers ── */
    function refreshPositions() {
        list.querySelectorAll('.rm-item').forEach((item, i) => {
            const badge = item.querySelector('.rm-pos-badge');
            const num   = item.querySelector('.rm-pos-num');
            if (!num) return;
            const newPos = i + 1;
            if (parseInt(num.textContent) !== newPos) {
                num.textContent = newPos;
                badge.classList.remove('bumping');
                void badge.offsetWidth; // reflow
                badge.classList.add('bumping');
                setTimeout(() => badge.classList.remove('bumping'), 400);
            }
        });
    }

    /* ── Save ── */
    let saveTimer;
    function save() {
        clearTimeout(saveTimer);
        setStatus('saving');
        const ids = [...list.querySelectorAll('.rm-item')].map(el => parseInt(el.dataset.id));
        saveTimer = setTimeout(() => {
            fetch(REORDER_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ ids })
            })
            .then(r => {
                if (r.ok) {
                    setStatus('saved');
                    setTimeout(() => setStatus('idle'), 2500);
                } else {
                    setStatus('error');
                }
            })
            .catch(() => setStatus('error'));
        }, 350);
    }

    /* ── SortableJS ── */
    if (typeof Sortable !== 'undefined') {
        Sortable.create(list, {
            animation: 200,
            handle: '.rm-drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
            onEnd() {
                refreshPositions();
                save();
            }
        });
    }
})();
</script>
