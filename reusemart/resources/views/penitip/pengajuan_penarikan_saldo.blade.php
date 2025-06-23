@extends('layouts.app_dashboard')

@section('content')
<div class="container mt-4">
    <h2>Pengajuan Penarikan Saldo</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div id="alertSaldoKurang" class="alert alert-danger d-none" role="alert">
        Saldo tidak mencukupi untuk penarikan!
    </div>
    <div class="mb-3">
        <label><b>Total Saldo Yang Sudah Ditarik:</b></label>
        <input type="text" class="form-control" value="Rp {{ number_format($penitip->nominal_tarik, 0, ',', '.') }}" readonly>
    </div>
    <div class="card">
        <div class="card-body">
            <form id="formPenarikan" action="{{ route('penitip.penarikan-saldo') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>ID Penitip</label>
                    <input type="text" class="form-control" value="{{ 'T' . $penitip->id_penitip }}" readonly>
                </div>
                <div class="mb-3">
                    <label>Nama Penitip</label>
                    <input type="text" class="form-control" value="{{ $penitip->nama_penitip }}" readonly>
                </div>
                <div class="mb-3">
                    <label>Saldo Penitip</label>
                    <input type="text" id="saldoPenitip" class="form-control" value="{{ $penitip->saldo_penitip }}" data-saldo="{{ $penitip->saldo_penitip }}" readonly>
                </div>
                <div class="mb-3">
                    <label>Nominal Penarikan</label>
                    <input type="number" id="nominalTarik" name="nominal_tarik" class="form-control" min="1" required>
                    <small class="form-text text-muted">Biaya penarikan 5% akan dipotong dari nominal yang diajukan.</small>
                </div>
                <button type="submit" class="btn btn-primary">Ajukan Penarikan</button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-labelledby="modalKonfirmasiLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalKonfirmasiLabel">Konfirmasi Penarikan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalKonfirmasiBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btnKonfirmasiYakin">Setuju</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
    const form = document.getElementById('formPenarikan');
    const saldoInput = document.getElementById('saldoPenitip');
    const nominalInput = document.getElementById('nominalTarik');
    const alertSaldoKurang = document.getElementById('alertSaldoKurang');
    let modalKonfirmasi = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
    let btnKonfirmasiYakin = document.getElementById('btnKonfirmasiYakin');
    let lastNominal = 0;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        alertSaldoKurang.classList.add('d-none');
        let saldo = parseFloat(saldoInput.value);
        let nominal = parseFloat(nominalInput.value);
        if (isNaN(nominal) || nominal < 1) {
            nominalInput.focus();
            return;
        }
        if (nominal > saldo) {
            alertSaldoKurang.classList.remove('d-none');
            return;
        }
        let fee = 0.05 * nominal;
        let diterima = nominal - fee;
        let sisa = saldo - nominal;
        document.getElementById('modalKonfirmasiBody').innerHTML = `
            <div class='text-start'>
                <b>Nominal Penarikan:</b> Rp ${nominal.toLocaleString('id-ID')}<br>
                <b>Biaya Penarikan (5%):</b> Rp ${fee.toLocaleString('id-ID')}<br>
                <b>Saldo Diterima:</b> Rp ${diterima.toLocaleString('id-ID')}<br>
                <b>Sisa Saldo:</b> Rp ${sisa.toLocaleString('id-ID')}
            </div>
        `;
        lastNominal = nominal;
        modalKonfirmasi.show();
    });

    btnKonfirmasiYakin.addEventListener('click', function() {
        modalKonfirmasi.hide();
        form.submit();
    });
</script>
@endpush
@endsection 