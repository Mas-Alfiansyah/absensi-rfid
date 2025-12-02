<div class="mb-3">
  <label>Ganti Foto Profil</label>
  <input type="file" name="profile_photo" class="form-control">
  @if(auth()->user()->profile_photo)
    <form action="{{ route('profile.delete','profile') }}" method="POST" class="mt-2">
      @csrf
      @method('DELETE')
      <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus foto profil?')">Hapus Foto Profil</button>
    </form>
  @endif
</div>

<div class="mb-3">
  <label>Ganti Foto Sampul</label>
  <input type="file" name="cover_photo" class="form-control">
  @if(auth()->user()->cover_photo)
    <form action="{{ route('profile.delete','cover') }}" method="POST" class="mt-2">
      @csrf
      @method('DELETE')
      <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus foto sampul?')">Hapus Foto Sampul</button>
    </form>
  @endif
</div>
