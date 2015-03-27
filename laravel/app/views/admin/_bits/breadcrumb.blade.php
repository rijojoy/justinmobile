<div class="breadcrumb-button blue">
    <a class="breadcrumb-label" href= "{{ url() }}/admin/dashboard">
        <i class="icon-home"></i> Dashboard
    </a>
    <span class="breadcrumb-arrow"><span></span></span>
</div>
@foreach ($breadcrumbs as $breadcrumb)
<div class="breadcrumb-button">
    <a class="breadcrumb-label" href= "{{ url() }}/admin/{{ $breadcrumb['url'] }}">
        <i class="icon-{{ $breadcrumb['icon'] }}"></i> {{ $breadcrumb['label'] }}
    </a>
    <span class="breadcrumb-arrow"><span></span></span>
</div>
@endforeach