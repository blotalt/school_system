<form method="POST" action="{{ route('locale.update') }}" class="lang-switch">
    @csrf
    <button type="submit" name="locale" value="en" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">English</button>
    <button type="submit" name="locale" value="km" class="lang-btn {{ app()->getLocale() === 'km' ? 'active' : '' }}">ភាសាខ្មែរ</button>
</form>
