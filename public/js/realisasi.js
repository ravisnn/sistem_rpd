// realisasi.js - Modern AJAX edit for Realisasi (SweetAlert2 Version)

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('dataModal');
    const closeModal = document.getElementById('closeModal');
    const form = document.getElementById('dataForm');
    const tableBody = document.getElementById('tableBody');
    let editRealisasiId = null;

    // Helper to read selected year from UI (id/name 'tahun')
    function getSelectedYear() {
        const el = document.getElementById('tahun') || document.querySelector('select[name="tahun"]') || document.querySelector('input[name="tahun"]');
        return el ? String(el.value) : String(new Date().getFullYear());
    }

    // Close modal
    if (closeModal) closeModal.onclick = function() {
        modal.style.display = 'none';
    };
    window.onclick = function(event) {
        if (event.target == modal) modal.style.display = 'none';
    };

    // Edit button
    tableBody && tableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('warning')) {
            const tr = e.target.closest('tr');
            // Force create behavior from modal: always create new record on submit
            editRealisasiId = null;

            document.getElementById('modalRencanaId').value = tr.getAttribute('data-id_rencana');
            // Table has a leading 'No' column, so shift all child indices by +1
            document.getElementById('kegiatan').value = tr.children[1].innerText;
            document.getElementById('output').value = tr.children[2].innerText;
            if(document.getElementById('komponen')) document.getElementById('komponen').value = tr.children[3].innerText;
            if(document.getElementById('jenis_belanja')) document.getElementById('jenis_belanja').value = tr.children[4].innerText;
            if(document.getElementById('unit_kerja')) document.getElementById('unit_kerja').value = tr.children[5].innerText;
            if(document.getElementById('sub_komponen')) document.getElementById('sub_komponen').value = tr.children[6] ? tr.children[6].innerText : '';
            if(document.getElementById('akun')) document.getElementById('akun').value = tr.children[7] ? tr.children[7].innerText : '';
            if(document.getElementById('uraians')) document.getElementById('uraians').value = tr.children[8] ? tr.children[8].innerText : '';
            if (document.getElementById('target')) {
                let raw = tr.children[9] ? tr.children[9].innerText : '0';

                // Ambil hanya angka → hapus Rp, titik, koma, spasi, dll
                raw = raw.replace(/[^0-9]/g, '');

                // Jika kosong, set 0
                if (raw === '') raw = '0';

                document.getElementById('target').value = raw;
            }
            // Bulan
            const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
            months.forEach((m) => {
                document.getElementById('bulan-' + m).value = tr.getAttribute('data-' + m.toLowerCase());
            });

            document.getElementById('modalTitle').innerText = 'Edit Realisasi';
            modal.style.display = 'block';
        }
    });

    // Submit form (edit only)
    form && (form.onsubmit = function(e) {
        e.preventDefault();
        const data = {
            rencana_kegiatan_id: document.getElementById('modalRencanaId').value,
            target: document.getElementById('target').value,
            uraians: document.getElementById('uraians') ? document.getElementById('uraians').value : '',
            // include selected year so server will scope duplicate detection by created_at year
            tahun: getSelectedYear()
        };

        const months = ['jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'];
        months.forEach(m => {
            data[m] = document.getElementById('bulan-' + m.charAt(0).toUpperCase() + m.slice(1)).value;
        });

        // Always POST to create a new record from the modal
        const url = '/realisasi';
        const method = 'POST';

        // Debug: log payload to console for easier diagnosis
        try { console.debug('Submitting Realisasi payload:', data); } catch(e) {}

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(async r => {
            let text = '';
            try { text = await r.text(); } catch(e) { text = ''; }
            // Try to parse JSON if possible
            let resp = {};
            try { resp = text ? JSON.parse(text) : {}; } catch(e) { resp = {__raw: text}; }

            if (!r.ok) {
                console.error('Server returned error for realisasi save:', r.status, resp || text);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menyimpan',
                    html: '<div style="text-align:left; max-height:240px; overflow:auto;">'+
                          '<strong>Status:</strong> '+r.status+'<br/>'+
                          '<strong>Response:</strong><pre style="white-space:pre-wrap;">'+(typeof resp === 'object' ? JSON.stringify(resp, null, 2) : resp) + '</pre></div>',
                    confirmButtonColor: '#d33'
                });
                return;
            }

            if (resp.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data realisasi berhasil diperbarui.',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            } else {
                console.warn('Save returned non-success payload:', resp);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: resp.message || 'Terjadi kesalahan saat menyimpan data.',
                    confirmButtonColor: '#d33'
                });
            }
        })
        .catch((err) => {
            console.error('Fetch error when saving realisasi:', err);
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Jaringan!',
                text: 'Tidak dapat terhubung ke server. Periksa konsol (F12) untuk detail.',
                confirmButtonColor: '#d33'
            });
        });
    });
});
