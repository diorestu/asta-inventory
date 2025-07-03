<div class="form-floating mb-3">
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="form-control" value="{{ old($name, $data) }}"
        required>
    <label for="{{ $name }}">{{ $label }}</label>
</div>