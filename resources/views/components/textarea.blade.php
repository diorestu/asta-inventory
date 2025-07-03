<div class="form-floating mb-3">
    <textarea class="form-control" name="{{ $name }}" id="{{ $name }}"
        style="height: {{ $height }}">{{ old($name, $data) }}</textarea>
    <label for="{{ $name }}">{{ $title }}</label>
</div>