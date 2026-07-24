@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a> &gt;
    <a href="{{ route('admin.students.index') }}">{{ __('admin.students.title') }}</a> &gt;
    <span>{{ __('admin.students.add_new') }}</span>
</div>

<x-page-header>
    <div>
        <h1>{{ __('admin.students.registration_title') }}</h1>
        <p>{{ __('admin.students.registration_subtitle') }}</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('admin.students.store') }}" class="form-card" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
        <div class="form-group">
            <label>{{ __('common.full_name') }}</label>
            <input type="text" name="name" placeholder="{{ __('admin.students.name_placeholder') }}" value="{{ old('name') }}">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.email_address') }}</label>
            <input type="email" name="email" placeholder="{{ __('admin.students.email_placeholder') }}" value="{{ old('email') }}">
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
    <div class="form-group">
        <label>ឈ្មោះជាអក្សរខ្មែរ (Khmer Name)</label>
        <input type="text" name="khmer_name" placeholder="ឧ. សុខ ដារ៉ា" value="{{ old('khmer_name') }}">
        @error('khmer_name') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>{{ __('common.gender') }}</label>
        <select name="gender">
            <option value="">-- Select --</option>
            <option value="male" @selected(old('gender') === 'male')>{{ __('common.male') }}</option>
            <option value="female" @selected(old('gender') === 'female')>{{ __('common.female') }}</option>
        </select>
        @error('gender') <span class="field-error">{{ $message }}</span> @enderror
    </div>
</div>

<div class="form-group">
    <label>Profile Picture</label>
    <input type="file" name="profile_picture" accept="image/*">
    @error('profile_picture') <span class="field-error">{{ $message }}</span> @enderror
</div>

    <div class="form-row">
        <div class="form-group">
            <label>{{ __('common.system_password') }}</label>
            <div class="password-input-wrapper">
                <input type="password" name="password" placeholder="••••••••">
                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility(this)" aria-label="{{ __('common.show_password') }}"><i class="fa-solid fa-eye"></i></button>
            </div>
            @error('password') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.roll_number') }}</label>
            <input type="text" name="roll_no" placeholder="{{ __('admin.students.roll_no_placeholder') }}" value="{{ old('roll_no') }}">
            @error('roll_no') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>{{ __('common.date_of_birth') }}</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
            @error('date_of_birth') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.guardian_contact') }}</label>
            <input type="text" name="guardian_contact" placeholder="{{ __('admin.students.guardian_placeholder') }}" value="{{ old('guardian_contact') }}">
            @error('guardian_contact') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label>{{ __('admin.students.assigned_class') }}</label>
        <div class="section-toggle-group">
            @foreach($classes as $class)
                <label class="section-toggle">
                    <input type="radio" name="class_id" value="{{ $class->id }}" {{ (string) old('class_id') === (string) $class->id ? 'checked' : '' }}>
                    <span>{{ $class->name }}</span>
                </label>
            @endforeach
        </div>
        @error('class_id') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="info-box">
        <i class="fa-solid fa-lightbulb"></i>
        <span>{{ __('admin.students.enrollment_notice') }}</span>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.students.index') }}" class="cancel-btn">{{ __('common.cancel') }}</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-user-plus"></i> {{ __('admin.students.register_button') }}</button>
    </div>
</form>
@endsection
