@foreach ($settings as $setting)
<div class="input-field col s12 @if (getSettingFieldType('TYPE_TEXTAREA') !== $setting->field->type_id) m6 @endif">
    @if (getSettingFieldType('TYPE_TEXT') === $setting->field->type_id)
    <input id="{{ $setting->path }}" type="text" name="settings[{{ $setting->path }}]" class="validate {{ $setting->field->class }}" value="{{ $setting->value }}" />
    @elseif (getSettingFieldType('TYPE_EMAIL') === $setting->field->type_id)
    <input id="{{ $setting->path }}" type="email" name="settings[{{ $setting->path }}]" class="validate {{ $setting->field->class }}" value="{{ $setting->value }}" />
    @elseif (getSettingFieldType('TYPE_SELECT') === $setting->field->type_id)
    <select id="{{ $setting->path }}" name="settings[{{ $setting->path }}]" class="material-select auto-select {{ $setting->field->class }}" data-value="{{ $setting->value }}">
        <option value="" disabled>Choose your option</option>
        {!! $setting->field->options !!}
    </select>
    @elseif (getSettingFieldType('TYPE_TEXTAREA') === $setting->field->type_id)
    <textarea id="{{ $setting->path }}" name="settings[{{ $setting->path }}]" class="materialize-textarea height-10 {{ $setting->field->class }}">{{ $setting->value }}</textarea>
    @elseif (getSettingFieldType('TYPE_TELEPHONE') === $setting->field->type_id)
    <input id="{{ $setting->path }}" type="tel" name="settings[{{ $setting->path }}]" class="validate {{ $setting->field->class }}" value="{{ $setting->value }}" />
    @endif
    <label for="{{ $setting->path }}">{{ $setting->field->label }}</label>
</div>
@endforeach