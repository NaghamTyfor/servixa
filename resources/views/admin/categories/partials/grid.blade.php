{{-- resources/views/admin/categories/partials/grid.blade.php --}}
@php
    $paginator   = $categories->appends(request()->query());
    $currentPage = $paginator->currentPage();
    $lastPage    = $paginator->lastPage();
@endphp

<div class="cat-grid">
    @forelse($categories as $category)
    <div class="cat-card" data-url="{{ route('admin.categories.show', $category) }}">
        <div class="accent-bar"></div>
        <div class="card-head">
            <div class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            <div class="card-top-right">
                <input type="checkbox" class="cb row-cb" value="{{ $category->id }}">
            </div>
        </div>

        <div class="card-names">
            <div class="bilingual">
                <div class="nc nc-ar">
                    <span class="lang-tag">AR</span>
                    <p class="name-text">{{ $category->getTranslation('name','ar',false) ?? 'غير محدد' }}</p>
                </div>
                <div class="nc nc-en">
                    <span class="lang-tag">EN</span>
                    <p class="name-text">{{ $category->getTranslation('name','en',false) ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="card-stats">
            <div class="sc">
                <span class="sc-val">{{ $category->sub_categories_count ?? 0 }}</span>
                <span class="sc-lbl">{{ __('admin.sub_categories') }}</span>
            </div>
            <div class="sc">
                <span class="sc-val">{{ $category->dynamic_fields_count ?? 0 }}</span>
                <span class="sc-lbl">{{ __('admin.dynamic_fields') }}</span>
            </div>
        </div>

        <div class="card-foot">
            <div class="actions">
                {{-- زر العرض --}}
                <a href="{{ route('admin.categories.show', $category) }}" class="abtn a-view" title="{{ __('admin.details') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
                {{-- زر التصنيفات الفرعية --}}
                <a href="{{ route('admin.categories.sub-categories.index', $category) }}" class="abtn a-sub" title="{{ __('admin.sub_categories') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                </a>
                {{-- زر الحقول الديناميكية (المضاف) --}}
                <a href="{{ route('admin.categories.dynamic-fields.index', $category) }}" class="abtn a-fields" title="{{ __('admin.dynamic_fields') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </a>
                {{-- زر التعديل --}}
                @can('categories.edit')
                <a href="{{ route('admin.categories.edit', $category) }}" class="abtn a-edit" title="{{ __('admin.edit') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                @endcan
                {{-- زر الحذف --}}
                @can('categories.delete')
                <button class="abtn a-del"
                    data-name="{{ $category->getTranslation('name',app()->getLocale(),false) }}"
                    data-url="{{ route('admin.categories.destroy', $category) }}"
                    title="{{ __('admin.delete') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                </button>
                @endcan
            </div>
        </div>
    </div>
    @empty
    <div class="empty">
        <div class="empty-ico">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        </div>
        <h3>{{ __('admin.no_data') }}</h3>
        <p>{{ request('search') ? __('admin.no_search_results') : __('admin.start_adding_categories') }}</p>
    </div>
    @endforelse
</div>

@if($paginator->hasPages())
<div class="pag d-flex justify-content-center">
    <div class="pag-wrap">
        @if($paginator->onFirstPage())
            <span class="prev dis"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="prev"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg></a>
        @endif
        <ul>
            @if($currentPage > 3)
                <li><a href="{{ $paginator->url(1) }}">1</a></li>
                @if($currentPage > 4)
                    <li class="disabled"><span>…</span></li>
                @endif
            @endif
            @for($p = max(1, $currentPage - 2); $p <= min($lastPage, $currentPage + 2); $p++)
                @if($p == $currentPage)
                    <li><a class="active" href="#">{{ $p }}</a></li>
                @else
                    <li><a href="{{ $paginator->url($p) }}">{{ $p }}</a></li>
                @endif
            @endfor
            @if($currentPage < $lastPage - 2)
                @if($currentPage < $lastPage - 3)
                    <li class="disabled"><span>…</span></li>
                @endif
                <li><a href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a></li>
            @endif
        </ul>
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="next"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg></a>
        @else
            <span class="next dis"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg></span>
        @endif
    </div>
</div>
@endif
