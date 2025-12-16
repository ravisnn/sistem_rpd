@extends('layouts.app') <!-- pastikan kamu punya layout app -->

@section('content')
<div class="sidebar">
  <h2>Menu</h2>
  <a href="{{ url('/rencana-kegiatan') }}" class="active">📋 Rencana Kegiatan</a>
  <a href="{{ url('/realisasi') }}">✅ Realisasi</a>
</div>

<div class="content">
<h1>Rencana Kegiatan</h1>
<div class="card">
  <div class="controls">
    <button id="openModalBtn" class="btn primary">+ Tambah Data</button>
  </div>
  <div class="table-wrap">
    <table id="mainTable">
      <thead>
        <tr>
          <th>Kegiatan</th>
          <th>Output</th>
          <th>Akun</th>
          <th>Uraian</th>
          <th>Target</th>
          <th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th>
          <th>Mei</th><th>Jun</th><th>Jul</th><th>Agt</th>
          <th>Sep</th><th>Okt</th><th>Nov</th><th>Des</th>
          <th>Total RPD</th>
          <th>Selisih</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        @foreach($rencana as $item)
        <tr data-id="{{ $item->id }}" 
            data-akun="{{ $item->akun_id }}" 
            data-uraian="{{ $item->uraian_id }}" 
            data-target="{{ $item->target }}"
            @foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m)
            data-{{ $m }}="{{ $item->$m }}"
            @endforeach>
            <td>{{ $item->kegiatan }}</td>
            <td>{{ $item->output }}</td>
            <td>{{ $item->akun->kode }}</td>
            <td>{{ $item->uraian->kode }}</td>
            <td>{{ $item->target }}</td>
            @foreach(['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'] as $m)
            <td>{{ $item->$m }}</td>
            @endforeach
            <td class="rpd">0</td>
            <td class="selisih">0</td>
            <td>
              <button class="btn warning">✎</button>
              <button class="btn danger">✕</button>
            </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="group-totals" id="groupTotals"></div>
</div>
</div>

<!-- Modal -->
<div class="modal" id="dataModal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 id="modalTitle">Tambah Data</h2>
      <span class="close" id="closeModal">&times;</span>
    </div>
    <form id="dataForm">
      <div class="form-section">
        <h3>Informasi Utama</h3>
        <div class="form-grid">
          <div>
            <label>Kegiatan</label>
            <input type="text" id="kegiatan" required>
          </div>
          <div>
            <label>Output</label>
            <input type="text" id="output" required>
          </div>
          <div>
            <label>Akun</label>
            <select id="akun">
              @foreach($akuns as $a)
              <option value="{{ $a->id }}">{{ $a->kode }} - {{ $a->nama }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label>Uraian</label>
            <select id="uraian">
              @foreach($uraians as $u)
              <option value="{{ $u->id }}">{{ $u->kode }} - {{ $u->nama }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label>Target</label>
            <input type="number" id="target" value="0" required>
          </div>
        </div>
      </div>
      <div class="form-section">
        <h3>Rencana per Bulan</h3>
        <div class="month-grid" id="monthInputs">
          @foreach(['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'] as $m)
          <div>
            <label>{{ $m }}</label>
            <input type="number" id="bulan-{{ $m }}" value="0">
          </div>
          @endforeach
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn primary">💾 Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
const tableBody=document.getElementById('tableBody');
const months=['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'];
const modal=document.getElementById('dataModal');
let editRow=null;

// Modal
document.getElementById('openModalBtn').onclick=()=>openModal();
document.getElementById('closeModal').onclick=()=>closeModal();
window.onclick=e=>{if(e.target==modal)closeModal()};

function openModal(row=null){
  modal.style.display='flex';
  document.querySelector('.table-wrap').style.display="none";
  editRow=row;
  if(row){
    document.getElementById('modalTitle').textContent="Edit Data";
    document.getElementById('kegiatan').value=row.cells[0].textContent;
    document.getElementById('output').value=row.cells[1].textContent;
    document.getElementById('akun').value=row.dataset.akun;
    document.getElementById('uraian').value=row.dataset.uraian;
    document.getElementById('target').value=row.dataset.target;
    months.forEach(m=>{document.getElementById('bulan-'+capitalize(m)).value=row.dataset[m]||0});
  }else{
    document.getElementById('modalTitle').textContent="Tambah Data";
    document.getElementById('dataForm').reset();
    months.forEach(m=>{document.getElementById('bulan-'+capitalize(m)).value=0});
  }
}

function closeModal(){modal.style.display='none';document.querySelector('.table-wrap').style.display="block";}
function capitalize(s){return s.charAt(0).toUpperCase()+s.slice(1);}

// Submit form via AJAX
document.getElementById('dataForm').onsubmit=function(e){
  e.preventDefault();
  const data={
    kegiatan:document.getElementById('kegiatan').value,
    output:document.getElementById('output').value,
    akun_id:document.getElementById('akun').value,
    uraian_id:document.getElementById('uraian').value,
    target:parseInt(document.getElementById('target').value)||0
  };
  months.forEach(m=>data[m]=parseInt(document.getElementById('bulan-'+capitalize(m)).value)||0);

  const url=editRow ? `/rencana-kegiatan/${editRow.dataset.id}` : '/rencana-kegiatan';
  const method=editRow ? 'PUT' : 'POST';

  fetch(url,{
    method: method,
    headers:{
      'Content-Type':'application/json',
      'X-CSRF-TOKEN':'{{ csrf_token() }}'
    },
    body: JSON.stringify(data)
  }).then(r=>r.json()).then(res=>{
    if(res.success){
      if(editRow) updateRow(editRow,data);
      else addRow(data,res.id);
      closeModal(); recalc();
    }
  });
};

function addRow(data,id){
  const tr=document.createElement('tr');
  tr.dataset.id=id || Math.random();
  fillRow(tr,data);
  tableBody.appendChild(tr);
}

function updateRow(tr,data){fillRow(tr,data);}
function fillRow(tr,data){
  tr.dataset.akun=data.akun_id;
  tr.dataset.uraian=data.uraian_id;
  tr.dataset.target=data.target;
  months.forEach(m=>tr.dataset[m]=data[m]);
  tr.innerHTML=`
    <td>${data.kegiatan}</td>
    <td>${data.output}</td>
    <td>${data.akun_id}</td>
    <td>${data.uraian_id}</td>
    <td>${data.target}</td>
    ${months.map(m=>`<td>${data[m]}</td>`).join('')}
    <td class="rpd">0</td>
    <td class="selisih">0</td>
    <td>
      <button class="btn warning">✎</button>
      <button class="btn danger">✕</button>
    </td>
  `;
  tr.querySelector('.warning').onclick=()=>openModal(tr);
  tr.querySelector('.danger').onclick=()=>{
    fetch(`/rencana-kegiatan/${tr.dataset.id}`,{
      method:'DELETE',
      headers:{
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
      }
    }).then(r=>r.json()).then(res=>{
      if(res.success){ tr.remove(); recalc(); }
    });
  }
}

function recalc(){
  let groups={};
  tableBody.querySelectorAll('tr').forEach(tr=>{
    const target=parseInt(tr.dataset.target)||0;
    const akun=tr.dataset.akun;
    let rpd=0;
    months.forEach(m=>rpd+=parseInt(tr.dataset[m])||0);
    tr.querySelector('.rpd').textContent=rpd.toLocaleString('id-ID');
    tr.querySelector('.selisih').textContent=(target-rpd).toLocaleString('id-ID');
    if(!groups[akun]) groups[akun]={target:0,rpd:0};
    groups[akun].target+=target;
    groups[akun].rpd+=rpd;
  });
  const groupDiv=document.getElementById('groupTotals');
  groupDiv.innerHTML='';
  Object.keys(groups).forEach(k=>{
    const g=groups[k];
    const selisih=g.target-g.rpd;
    groupDiv.innerHTML+=`
      <div class="group-card">
        <h2>Akun ${k}</h2>
        <p>Total Target: ${g.target.toLocaleString('id-ID')}</p>
        <p>Total RPD: ${g.rpd.toLocaleString('id-ID')}</p>
        <p>Selisih: ${selisih.toLocaleString('id-ID')}</p>
      </div>`;
  });
}
recalc();
</script>
@endsection
