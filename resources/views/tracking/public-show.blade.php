<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Pengerjaan Shoe Wash - Resi #{{ $order->id }}</title>
    <!-- Gunakan Bootstrap 5 atau Tailwind sesuai template Anda -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <!-- Card Informasi Utama Order -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Status Pengerjaan Shoe Wash</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <p class="mb-1 text-muted">No. Resi / Order:</p>
                                <h5 class="fw-bold">#{{ $order->order_number }}</h5>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-1 text-muted">Tanggal Masuk:</p>
                                <h5 class="fw-bold">{{ $order->entry_date }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="mb-1 text-muted">Nama Pelanggan:</p>
                                <h5 class="fw-bold">{{ $order->customers->name ?? 'Pelanggan' }}</h5>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-1 text-muted">Status Keseluruhan:</p>
                                <h5><span class="badge bg-info text-dark">{{ ucfirst($order->status ?? 'Proses') }}</span></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Daftar Item Sepatu (Tabel Detail) -->
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Daftar Item Sepatu dalam Order Ini</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Kategori / Merek Sepatu</th>
                                        <th>Layanan Cuci</th>
                                        <th>Harga</th>
                                        <th>Status Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->items as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $item->category->name ?? 'Sepatu' }} / {{$item->brand}}</strong>
                                                <br><small class="text-muted">{{ $item->notes ?? 'Tidak ada catatan khusus' }}</small>
                                            </td>
                                            <td>{{ $item->service->name ?? 'Standard Wash' }}</td>
                                            <td>Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</td>
                                            {{-- <td>
                                                <span class="badge bg-warning text-dark">{{ ucfirst($item->status) }}</span>
                                                
                                            </td> --}}
                                             <td class="text-center">
                                                <span >
                                                    @if($item->status == 'pending')
                                                        <span class="badge bg-secondary ">Pending</span>
                                                    @elseif($item->status == 'washing')
                                                        <span class="badge bg-info ">Washing</span>
                                                    @elseif($item->status == 'drying')
                                                        <span class="badge bg-warning ">Drying</span>
                                                    @elseif($item->status == 'completed')
                                                        <span class="badge bg-primary ">Completed</span>
                                                    @elseif($item->status == 'received')
                                                        <span class="badge bg-success ">Received</span>
                                                    @else
                                                        <span class="badge bg-dark">{{ $item->status }}</span>
                                                    @endif
                                                </span>
                                            </td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Tidak ada item sepatu pada order ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="text-center mt-4 text-muted">
                    <small>Terima kasih telah mempercayakan perawatan sepatu Anda kepada kami!</small>
                </div>

            </div>
        </div>
    </div>

</body>
</html>