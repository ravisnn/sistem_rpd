<div style="
    width:220px; 
    background:#2c3e50; 
    height:100vh; 
    position:fixed; 
    display:flex; 
    flex-direction:column; 
    padding-top:20px;
    overflow-y:auto;
">

  <!-- USER PROFILE -->
  @auth
  <div style="
      display:flex; 
      flex-direction:column; 
      align-items:center; 
      padding:0 0 16px 0;
      flex-shrink:0;
  ">
    <div style="
        width:40px;
        height:40px;
        background:#007bff;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        color:white;
        font-size:20px;
        font-weight:bold;
        cursor:pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      "
      onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 0 10px rgba(0,123,255,0.6)';"
      onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
      👤
    </div>
    <span style="color:#fff; font-weight:700; font-size:0.9rem; margin-top:6px; text-align:center;">{{ auth()->user()->name }}</span>
  </div>
  @endauth

  <!-- NAVIGATION MENU -->
  <nav style="width:100%; display:flex; flex-direction:column; gap:4px; flex:1;">
    @php
      $menuItems = [
        ['url' => url('/dashboard'), 'label' => '📊 Dashboard', 'check' => 'dashboard'],
        ['url' => url('/rencana-kegiatan'), 'label' => '📋 Rencana Kegiatan', 'check' => 'rencana-kegiatan'],
        ['url' => url('/realisasi'), 'label' => '✅ Realisasi', 'check' => 'realisasi'],
        ['url' => route('kertas-kerja.index'), 'label' => '📑 Monitoring RPD', 'check' => 'kertas-kerja'],
        ['url' => route('monitoring.rpd'), 'label' => '📊 Monitoring RPD per Kelompok Bagian Substansi', 'check' => 'monitoring-rpd'],
        ['url' => route('laporan.index'), 'label' => '📄 Laporan', 'check' => 'laporan'],
      ];
    @endphp

    @foreach($menuItems as $item)
      <a href="{{ $item['url'] }}" 
        class="{{ request()->is($item['check']) ? 'active' : '' }}" 
        style="
          color:#fff; 
          text-decoration:none; 
          padding:8px 32px; 
          font-size:1.08rem; 
          {{ request()->is($item['check']) ? 'background:#007bff;' : 'background:none;' }} 
          border-left:4px solid {{ request()->is($item['check']) ? '#007bff' : 'transparent' }};
          transition: background 0.2s ease, box-shadow 0.2s ease;
          border-radius:4px;
          display:block;
        "
        onmouseover="this.style.background='#007bff'; this.style.boxShadow='inset 4px 0 0 rgba(255,255,255,0.4)';"
        onmouseout="this.style.background='{{ request()->is($item['check']) ? '#007bff' : 'none' }}'; this.style.boxShadow='none';"
      >
        {{ $item['label'] }}
      </a>
    @endforeach

    <!-- LOGOUT BUTTON (use GET to avoid 419 when session expired) -->
    <form method="GET" action="{{ route('logout.get') }}" style="margin-top:16px; display:flex; justify-content:center;">
      <button type="submit" style="width:80%; background:#e74c3c; color:#fff; border:none; padding:10px 0; border-radius:4px; font-size:1rem; cursor:pointer; transition:0.2s;" 
      onmouseover="this.style.background='#c0392b';" 
      onmouseout="this.style.background='#e74c3c';">
        Logout
      </button>
    </form>
  </nav>
</div>

<!-- RESPONSIVE MOBILE -->
<style>
@media(max-width:768px){
  div[style*="width:220px"] {
    width:100%;
    height:auto;
    flex-direction:row;
    align-items:center;
    overflow-x:auto;
    overflow-y:hidden;
    padding:8px 8px;
  }
  nav[style*="flex-direction:column"] {
    flex-direction:row;
    gap:12px;
  }
  form[style*="margin-top:16px"] {
    flex-shrink:0;
  }
}
</style>
