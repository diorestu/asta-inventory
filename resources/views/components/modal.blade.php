@props([
'title' => 'Anonim',
'href' => Illuminate\Support\Str::slug($title),
'size' => 'lg',
])

<a class="modal-effect btn btn-secondary d-flex align-items-center gap-2" data-bs-effect="effect-scale"
    data-bs-toggle="modal" href="#{{ $href }}"><i class="ti ti-plus"></i>{{ $title }}</a>


<div class="modal fade" id="{{ $href }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-{{ $size }} modal-dialog-centered text-center" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                {{ $title }}
            </div>
            <div class="modal-body text-start">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>