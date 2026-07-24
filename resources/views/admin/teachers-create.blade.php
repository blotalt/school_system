@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a> &gt;
    <a href="{{ route('admin.teachers.index') }}">{{ __('admin.teachers.title') }}</a> &gt;
    <span>{{ __('admin.teachers.add_new') }}</span>
</div>

<x-page-header>
    <div>
        <h1>{{ __('admin.teachers.registration_title') }}</h1>
        <p>{{ __('admin.teachers.registration_subtitle') }}</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('admin.teachers.store') }}" class="form-card" enctype="multipart/form-data">
    @csrf

    <h3 class="form-section-title"><i class="fa-solid fa-briefcase"></i> {{ __('admin.teachers.faculty_information') }}</h3>

    <div class="form-row form-row-3">
        <div class="form-group">
            <label>{{ __('common.full_name') }}</label>
            <input type="text" name="name" placeholder="{{ __('admin.teachers.name_placeholder') }}" value="{{ old('name') }}">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.date_of_birth') }}</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
            @error('date_of_birth') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.gender') }}</label>
            <select name="gender">
                <option value="">{{ __('admin.teachers.select_gender') }}</option>
                <option value="male" @selected(old('gender') === 'male')>{{ __('common.male') }}</option>
                <option value="female" @selected(old('gender') === 'female')>{{ __('common.female') }}</option>
            </select>
        </div>
    </div>

    <div class="form-row">
    <div class="form-group">
        <label>ឈ្មោះជាអក្សរខ្មែរ (Khmer Name)</label>
        <input type="text" name="khmer_name" placeholder="ឧ. ចាន់ ប្រាក់" value="{{ old('khmer_name') }}">
        @error('khmer_name') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>Profile Picture</label>
        <input type="file" name="profile_picture" accept="image/*">
        <small style="color:#9ca3af;">Optional. Default based on gender if not uploaded.</small>
        @error('profile_picture') <span class="field-error">{{ $message }}</span> @enderror
    </div>
</div>

    <div class="form-row">
        <div class="form-group">
            <label>{{ __('common.email_address') }}</label>
            <input type="email" name="email" placeholder="{{ __('admin.teachers.email_placeholder') }}" value="{{ old('email') }}">
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.phone_number') }}</label>
            <input type="text" name="phone" placeholder="{{ __('admin.teachers.phone_placeholder') }}" value="{{ old('phone') }}">
            @error('phone') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group" style="max-width:400px;">
        <label>{{ __('common.system_password') }}</label>
        <div class="password-input-wrapper">
            <input type="password" name="password" placeholder="••••••••">
            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)" aria-label="{{ __('common.show_password') }}"><i class="fa-solid fa-eye"></i></button>
        </div>
        @error('password') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <hr class="form-divider">

    <div class="form-group">
        <label>{{ __('admin.teachers.subject_specialization') }}</label>
        <div class="section-toggle-group">
            @foreach($subjects as $subject)
                <label class="section-toggle">
                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" {{ in_array($subject->id, old('subjects', [])) ? 'checked' : '' }}>
                    <span>{{ $subject->displayName() }}</span>
                </label>
            @endforeach
        </div>
        @error('subjects') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>{{ __('common.assigned_classes') }}</label>
        <div class="section-toggle-group">
            @foreach($classes as $class)
                <label class="section-toggle">
                    <input type="checkbox" name="classes[]" value="{{ $class->id }}" {{ in_array($class->id, old('classes', [])) ? 'checked' : '' }}>
                    <span>{{ $class->displayName() }}</span>
                </label>
            @endforeach
        </div>
        @error('classes') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="info-box">
        <i class="fa-solid fa-circle-info"></i>
        <span>{{ __('admin.teachers.reassign_notice') }}</span>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.teachers.index') }}" class="cancel-btn">{{ __('common.cancel') }}</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-user-plus"></i> {{ __('admin.teachers.register_button') }}</button>
    </div>
</form>
@endsection