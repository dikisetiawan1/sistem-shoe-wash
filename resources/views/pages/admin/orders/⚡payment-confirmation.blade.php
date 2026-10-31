<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;


new class extends Component
{
  
   public $search = '';
    
    // Properti untuk modal/pilihan pembayaran jika ingin memilih metode (Cash, Transfer, QRIS)
    public $selectedOrderId = null;
    public $paymentMethod = 'cash';

   
 
    public function selectOrder($orderId)
    {
        $this->selectedOrderId = $orderId;
        // Buka modal konfirmasi menggunakan JavaScript
        $this->dispatch('open-payment-modal');
    }

    // Fungsi utama mengubah status dari unpaid ke paid
    public function markAsPaid($orderId)
    {
        $branchId = Auth::user()->branch_id;

        $order = Orders::where('branch_id', $branchId)->where('id', $orderId)->first();

        if ($order) {
            $order->update([
                'payment_status' => 'paid', 
                'payment_method' => $this->paymentMethod 
            ]);

            session()->flash('success', 'Pembayaran pesanan #' . $order->order_number . ' berhasil dikonfirmasi (Lunas).');
        }

        $this->selectedOrderId = null;
        $this->dispatch('close-payment-modal');
    }

    public function updatePaymentMethod($orderId, $updatePayment){

                    $item = Orders::find($orderId);

                    if($item){
                        $item->payment_method = $updatePayment;
                        $item->save();
                    }

                     // flash message
            session()->flash('message', "Payment Method Pesanan {$item->name} Berhasil Di Update.");
            return redirect()->route('admin.orders.payment-confirmation');

    }

    public function render()
    {
        $branchId = Auth::user()->branch_id;

        $unpaidOrders = Orders::with('customers')
                            ->where('branch_id', $branchId)
                            ->where('payment_status', 'unpaid') 
                            ->when($this->search, function($query) {
                                $query->where('order_number', 'like', '%'.$this->search.'%')
                                      ->orWhereHas('customers', function($query) {
                                          $query->where('name', 'like', '%'.$this->search.'%');
                                      });
                            })
                            ->latest()
                            ->get();
                            

        return $this->view([
            'unpaidOrders' => $unpaidOrders
        ])
        ->layout('layouts::app')
        ->title('Konfirmasi Pembayaran');
    }
};
?>

<div>

    <!--begin::App Content-->
    <div class="app-content ">
        <div class="container-fluid mb-5 mt-5 ">
             <div class="row">
                <div class="col-sm-6 mb-3">
                    <h5 class="fw-bold" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Konfirmasi Pembayaran
                    </h5>
                    <small class="text-muted">Kelola pembayaran seluruh customers</small>
                </div>
            </div>
            <!-- Alert Notifikasi -->
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Card Tabel Konfirmasi -->
            <div class="card border-0 shadow-sm bg-white">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-semibold text-dark">Daftar Pesanan Belum Lunas (Unpaid)</h5>
                    
                    <!-- Kotak Pencarian -->
                    <div class="input-group" style="width: 250px;">
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Cari Nota / Pelanggan...">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id='paymentTable'>
                            <thead class="table-light text-uppercase fs-7">
                                <tr>
                                    <th class="ps-4">Order ID</th>
                                    <th>CUSTOMERS</th>
                                    <th>ENTRY DATE</th>
                                    <th>TOTAL PRICE</th>
                                    <th>PAYMENT METHOD</th>
                                    <th>STATUS</th>
                                    <th class="text-end pe-4">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($unpaidOrders as $order)
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">#{{ $order->order_number}}</td>
                                        <td>{{ $order->customers->name ?? 'Pelanggan Umum' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y, H:i') }}</td>
                                        <td class="fw-semibold">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</td>
                                        <td class="fw-semibold">
                                                <select 
                                                wire:change="updatePaymentMethod({{ $order->id }}, $event.target.value)" 
                                                class="form-select form-select-sm text-xs rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="cash" {{ $order->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                                <option value="transfer" {{ $order->payment_method == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                                <option value="qris" {{ $order->payment_method == 'qris' ? 'selected' : '' }}>qris</option>
                                              
                                    </td>
                                        <td>
                                                @if($order->payment_status == 'paid')
                                                    <span class="badge bg-success float-end text-uppercase">Paid</span>
                                                    @elseif($order->payment_status == 'unpaid')
                                                        <span class="badge bg-danger  float-end text-uppercase">Unpaid</span>
                                                    @else
                                                    <span class="badge bg-dark text-uppercase">{{ $order->payment_status }}</span>
                                                @endif    
                                        </td>
                                        <td class="text-end pe-4">
                                            <!-- Tombol Konfirmasi Cepat / Ubah ke Paid -->
                                            <button wire:click="markAsPaid({{ $order->id }})" 
                                                    wire:confirm="Yakin ingin mengubah status pesanan #{{ $order->order_number }} menjadi Lunas (Paid)?"
                                                    class="btn btn-sm text-white px-3" 
                                                    style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); border-radius: 20px;">
                                                <i class="bi bi-check2-circle me-1"></i> Tandai Lunas
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                            Tidak ada data pesanan yang belum lunas saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--end::App Content-->
</div>

 <script>
    $(document).ready(function() {
        let table = new DataTable('#paymentTable', {
            destroy: true, // Mengizinkan inisialisasi ulang jika tabel sudah ada
            // Huruf 'l' ditambahkan di sebelah 'i' (menjadi 'li') agar dropdown entries per page muncul di kiri bawah
            dom: '<"row mb-3"<"col-md-6"B><"col-md-6"f>>rt<"row mt-3 align-items-center"<"col-md-6"li><"col-md-6 d-flex justify-content-end"p>>',
            buttons: [
                { 
                    extend: 'copy', 
                    text: '<i class="fas fa-copy"></i>', // Ikon Salin
                    titleAttr: 'Salin ke Clipboard',      // Tooltip saat kursor diarahkan ke tombol
                    className: 'btn btn-secondary btn-sm' 
                },
                { 
                    extend: 'excel', 
                    text: '<i class="fas fa-file-excel"></i>', // Ikon Excel
                    titleAttr: 'Ekspor ke Excel',
                    className: 'btn btn-success btn-sm' 
                },
                { 
                    extend: 'pdf', 
                    text: '<i class="fas fa-file-pdf"></i>', // Ikon PDF
                    titleAttr: 'Ekspor ke PDF',
                    className: 'btn btn-danger btn-sm' 
                },
                { 
                    extend: 'print', 
                    text: '<i class="fas fa-print"></i>', // Ikon Cetak
                    titleAttr: 'Cetak Tabel',
                    className: 'btn btn-primary btn-sm' 
                }
            ]
        });

        // table.on('click', 'tbody tr', function () {
        //     let data = table.row(this).data();
        //     alert('You clicked on ' + data[0] + "'s row");
        // });
    });
</script>