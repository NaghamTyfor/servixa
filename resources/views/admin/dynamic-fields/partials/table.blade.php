{{-- resources/views/admin/dynamic-fields/partials/table.blade.php --}}
<table class="df-table">
    <thead>
        <tr>
            <th>{{ __('admin.name_ar') }}</th>
            <th>{{ __('admin.name_en') }}</th>
            <th>{{ __('admin.field_type') }}</th>
            <th>{{ __('admin.required') }}</th>
            <th>{{ __('admin.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($fields as $field)
        <tr>
            <td class="lang-text" dir="rtl">{{ $field->getTranslation('name', 'ar') ?: '—' }}</td>
            <td class="lang-text">{{ $field->getTranslation('name', 'en') ?: '—' }}</td>
            <td>
                <span class="badge badge-type">{{ $field->type }}</span>
            </td>
            <td>
                <span class="badge {{ $field->is_required ? 'badge-req' : 'badge-opt' }}">
                    {{ $field->is_required ? __('admin.required') : __('admin.optional') }}
                </span>
            </td>
            <td>
                <div class="row-actions">
                    {{-- عرض --}}
                    <a href="{{ $ownerType === 'category'
                        ? route('admin.categories.dynamic-fields.show', [$owner, $field])
                        : route('admin.categories.sub-categories.dynamic-fields.show', [$parentCategory, $owner, $field]) }}"
                       class="act-btn act-view" title="{{ __('admin.show') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </a>

                    {{-- تعديل --}}
                    @can('dynamic_fields.edit')
                    <a href="{{ $ownerType === 'category'
                        ? route('admin.categories.dynamic-fields.edit', [$owner, $field])
                        : route('admin.categories.sub-categories.dynamic-fields.edit', [$parentCategory, $owner, $field]) }}"
                       class="act-btn act-edit" title="{{ __('admin.edit') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </a>
                    @endcan

                    {{-- حذف --}}
                    @can('dynamic_fields.delete')
                    <button class="act-btn act-del"
                        data-name="{{ $field->getTranslation('name', app()->getLocale()) ?: $field->id }}"
                        data-url="{{ $ownerType === 'category'
                            ? route('admin.categories.dynamic-fields.destroy', [$owner, $field])
                            : route('admin.categories.sub-categories.dynamic-fields.destroy', [$parentCategory, $owner, $field]) }}"
                        title="{{ __('admin.delete') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                        </svg>
                    </button>
                    @endcan
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">
                <div class="empty-state">
                    <div class="empty-ring">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <p>{{ request('search') ? __('admin.no_search_results') : __('admin.no_dynamic_fields') }}</p>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- روابط التصفح (pagination) --}}
@if($fields->hasPages())
<div class="pag">
    <div class="pag-wrap">
        {{ $fields->appends(request()->query())->links() }}
    </div>
</div>
@endif
