// rencana.js - Modern AJAX CRUD for Rencana Kegiatan (SweetAlert2 Version)

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('dataModal');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModal = document.getElementById('closeModal');
    const form = document.getElementById('dataForm');
    const tableBody = document.getElementById('tableBody');
    let editId = null;

    // Helper to read the currently selected year from the UI (id/name 'tahun')
    function getSelectedYear() {
        const el = document.getElementById('tahun') || document.querySelector('select[name="tahun"]') || document.querySelector('input[name="tahun"]');
        return el ? String(el.value) : String(new Date().getFullYear());
    }

    // Refresh full dataset used for validation from server
    async function refreshAllRencanaData() {
        try {
            // request authoritative dataset for the currently selected year
            const year = getSelectedYear();
            const resp = await fetch('/rencana-kegiatan/all-data?year=' + encodeURIComponent(year), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!resp.ok) throw new Error('HTTP ' + resp.status);
            const json = await resp.json();
            if (Array.isArray(json)) {
                window.allRencanaData = json;
                console.debug('Refreshed allRencanaData:', json.length);
            } else {
                window.allRencanaData = [];
                console.debug('Refreshed allRencanaData: non-array response');
            }
            return window.allRencanaData;
        } catch (err) {
            console.error('Failed to refresh allRencanaData:', err);
            return window.allRencanaData || [];
        }
    }

    // Call refresh on page load to ensure client has up-to-date dataset
    refreshAllRencanaData();

    // When main filters change, refresh authoritative dataset so client-side
    // validations consult the latest DB state. Listen to common filter IDs.
    ['kegiatan', 'output', 'akun', 'tahun'].forEach(id => {
        const el = document.getElementById(id) || document.querySelector('[name="' + id + '"]');
        if (el) el.addEventListener('change', () => refreshAllRencanaData());
    });


    // Open modal for add
    if (openModalBtn) {
        openModalBtn.onclick = function() {
            window._isLoadingData = false; // Reset flag
            form.reset();
            editId = null;
            document.getElementById('modalTitle').innerText = 'Tambah Data';
            modal.style.display = 'block';
            if (typeof filterAkunUraianByOutput === 'function') filterAkunUraianByOutput();
        };
    }

    // Close modal
    closeModal.onclick = function() {
        modal.style.display = 'none';
    };
    window.onclick = function(event) {
        if (event.target == modal) modal.style.display = 'none';
    };

    // Edit & Delete
    tableBody.addEventListener('click', function(e) {
        // Edit button
        if (e.target.classList.contains('warning')) {
            const tr = e.target.closest('tr');
            editId = tr.getAttribute('data-id_rencana');
            
            // Set flag untuk mencegah trigger event listener saat loading data
            window._isLoadingData = true;
            
            // Adjusted indexes: a new 'No' column was added as the first <td>,
            // so shift all cell indices by +1 compared to older code.
            document.getElementById('kegiatan').value = tr.children[1].innerText;
            // Enable and filter the Output select so user can change Output within same Kegiatan.
            (function() {
                const keg = tr.children[1].innerText;
                const outputEl = document.getElementById('output');
                if (!outputEl) return;
                Array.from(outputEl.options).forEach(opt => {
                    if (!opt.value) return opt.style.display = '';
                    const allowed = (opt.dataset.kegiatan || '').split(',').map(s => s.trim());
                    if (allowed.includes(keg) || allowed.includes('all')) {
                        opt.style.display = '';
                    } else {
                        opt.style.display = 'none';
                    }
                });
                outputEl.disabled = false;
                // Set value to current output (shifted index)
                outputEl.value = tr.children[2].innerText;
            })();
            if (document.getElementById('komponen')) document.getElementById('komponen').value = tr.children[3].innerText;
            if (document.getElementById('jenis_belanja')) document.getElementById('jenis_belanja').value = tr.children[4].innerText;
            if (document.getElementById('unit_kerja')) document.getElementById('unit_kerja').value = tr.children[5].innerText;
            document.getElementById('akun').value = tr.getAttribute('data-akun');
            document.getElementById('uraian').value = tr.getAttribute('data-uraian');
            if (document.getElementById('uraians')) document.getElementById('uraians').value = tr.children[8].innerText;
            if (document.getElementById('target')) document.getElementById('target').value = tr.getAttribute('data-target');
            
            const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
            months.forEach((m) => {
                document.getElementById('bulan-' + m).value = tr.getAttribute('data-' + m.toLowerCase());
            });
            
            // Panggil filter setelah semua data diset, tapi masih dalam loading mode
            if (typeof filterAkunUraianByOutput === 'function') filterAkunUraianByOutput();
            
            // Reset flag setelah semua selesai dengan delay minimal
            setTimeout(function() {
                window._isLoadingData = false;
            }, 100);
            
            document.getElementById('modalTitle').innerText = 'Edit Data';
            modal.style.display = 'block';
        }

        // Delete
        if (e.target.classList.contains('danger')) {
            const id_rencana = e.target.closest('tr').getAttribute('data-id_rencana');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/rencana-kegiatan/${id_rencana}`, {
                        method: 'DELETE',
                        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
                    })
                    .then(response => {
                        if (response && response.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => refreshAllRencanaData().then(() => location.reload()).catch(() => location.reload()));
                        } else {
                            // try to read server message if available
                            if (response && response.text) {
                                response.text().then(txt => {
                                    Swal.fire('Gagal', txt || 'Terjadi kesalahan saat menghapus data.', 'error');
                                }).catch(() => {
                                    Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus data.', 'error');
                                });
                            } else {
                                Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        }
                    })
                    .catch(err => {
                        console.error('Fetch DELETE error:', err);
                        Swal.fire('Gagal', 'Terjadi kesalahan jaringan saat menghapus data: ' + (err.message || err), 'error');
                    });
                }
            });
        }
    });

    // Submit form (add/edit)
    form.onsubmit = function(e) {
        e.preventDefault();
            const data = {
            kegiatan: document.getElementById('kegiatan').value,
            output: document.getElementById('output').value,
            komponen: document.getElementById('komponen') ? document.getElementById('komponen').value : '',
            jenis_belanja: document.getElementById('jenis_belanja') ? document.getElementById('jenis_belanja').value : '',
            unit_kerja: document.getElementById('unit_kerja') ? document.getElementById('unit_kerja').value : '',
            akun_id: document.getElementById('akun').value,
            uraian_id: document.getElementById('uraian').value,
            target: document.getElementById('target').value,
            uraians: document.getElementById('uraians') ? document.getElementById('uraians').value : '',
            // include selected year so server-side 'whereYear(created_at, year)' validation matches user's chosen year
            tahun: getSelectedYear()
        };
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
        months.forEach(m => {
            data[m.toLowerCase()] = document.getElementById('bulan-' + m).value;
        });

        // Validasi duplikasi data (berlaku untuk add & edit)
        // Jika sedang edit, abaikan baris yang sedang diedit (data-id_rencana === editId)
        // Uniqueness considers `uraians` text so different uraian strings are allowed
        // for the same akun_id/uraian_id. Comparison trims whitespace; case-sensitive for now.
        {
        const uraiansInput = document.getElementById('uraians');
        const uraiansTextRaw = (uraiansInput ? uraiansInput.value : (data.uraians || '')).trim();
        const uraiansText = (uraiansTextRaw === '-' ? '' : uraiansTextRaw);

        const komponenText = (data.komponen || '').trim();
        const jenisBelanjaText = (data.jenis_belanja || '').trim();
        const unitKerjaText = (data.unit_kerja || '').trim();

        // Build `existingRows` from full dataset when available so validation
        // always checks all rencana for the selected year (not only visible rows).
        // Fallback to DOM rows when `window.allRencanaData` is not present.
        let existingRows;
        if (window && Array.isArray(window.allRencanaData) && window.allRencanaData.length > 0) {
            // Map server data to objects with minimal interface used below
            existingRows = window.allRencanaData.map(item => {
                // Normalize akun id possibilities
                const akunId = item.akun_id ?? (item.akun ? (item.akun.id_akun ?? item.akun.id) : undefined) ?? '';
                const uraianId = item.uraian_id ?? (item.uraian ? (item.uraian.id_uraian ?? item.uraian.id) : undefined) ?? '';
                const komponenTextSrc = item.komponen ?? item.komponen_text ?? '';
                const jenisBelanjaSrc = item.jenis_belanja ?? '';
                const unitKerjaSrc = item.unit_kerja ?? item.unit_kerja_text ?? '';
                const uraiansSrc = item.uraians ?? item.uraians_text ?? '';

                return {
                    _raw: item,
                    getAttribute: function(attr) {
                        if (attr === 'data-id_rencana') return item.id_rencana ?? item.id ?? '';
                        if (attr === 'data-akun') return akunId;
                        if (attr === 'data-uraian') return uraianId;
                        return '';
                    },
                    children: [
                        { innerText: '' },
                        { innerText: item.kegiatan ?? '' },
                        { innerText: item.output ?? '' },
                        { innerText: komponenTextSrc },
                        { innerText: jenisBelanjaSrc },
                        { innerText: unitKerjaSrc },
                        { innerText: '' },
                        { innerText: '' },
                        { innerText: uraiansSrc }
                    ]
                };
            });

            // Debug: log akun distribution in allRencanaData to help diagnose missing akun entries
            try {
                const akunCounts = existingRows.reduce((acc, row) => {
                    const a = String(row.getAttribute('data-akun') || '').trim();
                    acc[a] = (acc[a] || 0) + 1;
                    return acc;
                }, {});
                console.debug('Validation dataset akun counts:', akunCounts);
            } catch (err) {
                console.debug('Error computing akun counts for validation debug:', err);
            }

            // Note: intentionally do NOT apply page-level filters here —
            // validations should consult the full dataset for the selected year.
        } else {
            existingRows = Array.from(tableBody.querySelectorAll('tr[data-id_rencana]'));
        }


        // ======================================================
        // (1) VALIDASI DUPLIKAT HARD: kegiatan + output + akun_id + uraian_id + uraians semuanya sama
        // ======================================================
        const isHardDuplicate = existingRows.some(row => {
            const rowId = row.getAttribute('data-id_rencana');
            if (editId && String(rowId).trim() === String(editId).trim()) return false;

            if (!row.children || row.children.length < 9) return false;

            const rowKegiatan = row.children[1].innerText;
            const rowOutput = row.children[2].innerText;
            const rowAkunId = row.getAttribute('data-akun');
            const rowUraianId = row.getAttribute('data-uraian');

            let rowUraianText = (row.children[8].innerText || '').trim();
            if (rowUraianText === '-') rowUraianText = '';

            return (
                rowKegiatan === data.kegiatan &&
                rowOutput === data.output &&
                String(rowAkunId).trim() === String(data.akun_id).trim() &&
                String(rowUraianId).trim() === String(data.uraian_id).trim() &&
                rowUraianText === uraiansText
            );
        });

        if (isHardDuplicate) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Duplikat!',
                text: 'Kombinasi kegiatan/output/akun/uraian/uraians ini sudah ada.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#ff9800'
            });
            return;
        }

            // Duplicate check complete; uraians text is already part of hard duplicate check above
        }

        const url = editId ? `/rencana-kegiatan/${editId}` : '/rencana-kegiatan';
        const method = editId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (response && response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'Data berhasil diedit!' : 'Data berhasil disimpan!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => refreshAllRencanaData().then(() => location.reload()).catch(() => location.reload()));
            } else {
                // Handle server-side validation / duplicate (409) with JSON message
                if (response && response.status === 409) {
                    try {
                        response.json().then(j => {
                            Swal.fire('Gagal', j.message || 'Data duplikat terdeteksi.', 'warning');
                        }).catch(() => {
                            response.text().then(txt => Swal.fire('Gagal', txt || 'Data duplikat terdeteksi.', 'warning'));
                        });
                    } catch (err) {
                        Swal.fire('Gagal', 'Data duplikat terdeteksi.', 'warning');
                    }
                } else if (response && response.text) {
                    response.text().then(txt => {
                        Swal.fire('Gagal', txt || 'Terjadi kesalahan saat menyimpan data.', 'error');
                    }).catch(() => {
                        Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan data.', 'error');
                    });
                } else {
                    Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan data.', 'error');
                }
            }
        })
        .catch(err => {
            console.error('Fetch POST/PUT error:', err);
            Swal.fire('Gagal', 'Terjadi kesalahan jaringan saat menyimpan data: ' + (err.message || err), 'error');
        });
    };
});
