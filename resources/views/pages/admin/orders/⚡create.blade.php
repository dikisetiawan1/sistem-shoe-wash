<?php

use Livewire\Component;
use function Livewire\Volt\{computed, mount, updated};
use Livewire\Attributes\Validate;
use Livewire\Attributes\Computed;
use App\Models\Orders;
use App\Models\Services;
use App\Models\Customers;
use Carbon\Carbon;

new class extends Component
{
    #[Validate('required')]
    public $customers_id = '';
    #[Validate('required')]
    public $payment_status = 'unpaid';
    #[Validate('required')]
    public $payment_method = 'cash';
    #[Validate('required|date')]
    public $entry_date = '';
    #[Validate('required|date')]
    public $estimated_completion_date = '';

    // untuk menyimpan data sepatu yang akan dicuci
    public $order_number = '';
    public $user_id = null;
    public $shoes = [];
    public $serviceOptions = [];
    public $customerOptions = [];


// 2. Mount => akan jalankan saat komponen pertama kali di-render, untuk inisialisasi data awal
    public function mount()  {
    $this->user_id = auth()->id() ?? 1;
    $this->entry_date = Carbon::now()->format('Y-m-d');
    $this->estimated_completion_date = Carbon::now()->addDays(3)->format('Y-m-d');

    // Ambil data dari database
    $this->serviceOptions = Services::all()->toArray();
    $this->customerOptions = Customers::all()->toArray();

    // Generate Order Number (SW-YYMMDD-001)
    $todayCode = Carbon::now()->format('ymd');
    $lastOrder = Orders::whereDate('created_at', Carbon::today())
                      ->latest('id')
                      ->first();

    $nextSequence = $lastOrder ? ((int) substr($lastOrder->order_number, -3) + 1) : 1;
    $this->order_number = 'SW-' . $todayCode . '-' . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);

    // Inisialisasi 1 baris sepatu default
    $this->addShoe();
}

 public function render()
    {
        // Kembalikan view dengan membawa data, layout, dan title
        return $this->view([])
            ->layout('layouts::app')
            ->title('Create orders'); 
    }   

// Helper: Tambah Sepatu
// fungsi ini akan menambahkan satu baris sepatu baru ke array $shoes
public function addShoe() {
    // masuk ke dalam array $shoes, setiap sepatu memiliki atribut brand, color, services_id, price, notes
    $this->shoes[] = [
        'brand' => '',
        'color' => '',
        'services_id' => '',
        'price' => 0,
        'notes' => '',
    ];
}

// Helper: Hapus Sepatu
public function removeShoe($index) {
    if (count($this->shoes) > 1) {
        unset($this->shoes[$index]);
        $this->shoes = array_values($this->shoes);
    }
}

// Auto-update harga ketika pilihan layanan berubah
public function updatedShoes($value, $key)
    {
        // $key contohnya: "0.service_id"
        $parts = explode('.', $key); 
        
        // Pastikan bagian kedua adalah 'service_id' dan index-nya ada
        if (isset($parts[1]) && $parts[1] === 'services_id') {
            $index = $parts[0]; // Ini adalah urutan indeks sepatu ke-0, ke-1, dst.

            foreach ($this->serviceOptions as $service) {
                if ($service['id'] == $value) {
                    $this->shoes[$index]['price'] = $service['price'];
                    break;
                }
            }
        }
    }

// Computed Property untuk Total Harga
#[Computed]
public function total()
{
    return array_reduce($this->shoes, function ($carry, $item) {
        return $carry + (int) ($item['price'] ?? 0);
    }, 0);
}


// Action Simpan
public function save()

    {

        // dd($this->all());
        // Validasi gabungan: Atribut #[Validate] otomatis tervalidasi,
        // ditambah validasi array untuk list sepatu di sini:
        $this->validate([
            'customers_id' => 'required', 
            'payment_status' => 'required|string',
            'payment_method' => 'required|string',
            'entry_date' => 'required|date',
            'estimated_completion_date' => 'required|date|after_or_equal:entry_date',
            'shoes' => 'required|array|min:1',
            'shoes.*.brand' => 'required|string',
            'shoes.*.color' => 'required|string',
            'shoes.*.services_id' => 'required',
            'shoes.*.price' => 'required|numeric|min:0',
        ]);
        $order = Orders::create([
            'order_number' => $this->order_number,
            'customers_id' => $this->customers_id,
            'total_price' => $this->total,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'entry_date' => $this->entry_date,
            'estimated_completion_date' => $this->estimated_completion_date,
        ]);

        foreach ($this->shoes as $shoe) {
            $order->items()->create([
                'services_id' => $shoe['services_id'],
                'brand' => $shoe['brand'],
                'color' => $shoe['color'],
                'price' => $shoe['price'],
                'notes' => $shoe['notes'] ?? null,
                'status' => 'pending',
            ]);
        }

    session()->flash('success', 'Order ' . $this->order_number . ' berhasil disimpan!');
    return redirect()->to('/orders');
}
}
?>


<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
             <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">Buat Pesanan Baru</h4>
                        <small class="text-muted">Kelola input pesanan baru untuk layanan cuci sepatu</small>
                    </div>
                    
                </div>
            <form wire:submit="save">
                
                {{-- Card: Informasi Customer & Transaksi --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="bi bi-journal-plus me-2"></i>Formulir Pesanan Baru
                        </h5>
                        <span class="badge bg-light text-primary fs-6 fw-bold">{{ $order_number }}</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            {{-- Pilih Customer dari DB --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Customer <span class="text-danger">*</span></label>
                                <select class="form-select " wire:model="customers_id">
                                    <option value="">-- Select Customer --</option>
                                    @foreach($customerOptions as $cust)
                                        <option value="{{ $cust['id'] }}">{{ $cust['name'] }} ({{ $cust['phone'] }})</option>
                                    @endforeach
                                </select>
                                @error('customers_id')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                                
                            </div>

                            {{-- Tanggal Masuk --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Entry Date</label>
                                <input type="date" class="form-control" wire:model="entry_date">
                                 @error('entry_date')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>

                            {{-- Estimasi Selesai --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Estimated Completion Date</label>
                                <input type="date" class="form-control @error('estimated_completion_date') is-invalid @enderror" wire:model="estimated_completion_date">
                                 @error('estimated_completion_date')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                              
                            </div>

                            {{-- Status Pembayaran --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Payment Status</label>
                                <select class="form-select" wire:model="payment_status">
                                    <option value="unpaid">Belum Lunas (Unpaid)</option>
                                    <option value="paid">Lunas (Paid)</option>
                                </select>
                                 @error('payment_status')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>

                            {{-- Metode Pembayaran --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Payment Method</label>
                                <select class="form-select" wire:model="payment_method">
                                    <option value="cash">Cash (Tunai)</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="qris">QRIS</option>
                                </select>
                                 @error('payment_method')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card: Daftar Sepatu --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                        <h6 class="card-title mb-0 fw-bold text-dark">
                            <i class="bi bi-box-seam me-2"></i>Shoe List ({{ count($shoes) }} Pairs)
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" wire:click="addShoe">
                            <i class="bi bi-plus-lg me-1"></i>Add Shoe
                        </button>
                    </div>
                    <div class="card-body p-4">

                        @foreach($shoes as $index => $shoe)
                            <div class="p-3 mb-3 border rounded bg-light position-relative" wire:key="shoe-item-{{ $index }}">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-secondary">Shoe #{{ $index + 1 }}</span>
                                    @if(count($shoes) > 1)
                                        <button type="button" class="btn btn-sm btn-outline-danger border-0" wire:click="removeShoe({{ $index }})">
                                            <i class="bi bi-trash me-1"></i>Delete
                                        </button>
                                    @endif
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Brand / Series</label>
                                        <input type="text" class="form-control form-control-sm " wire:model="shoes.{{ $index }}.brand" placeholder="Nike Air Jordan">
                                         @error('shoes.' . $index . '.brand')
                                                <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                </div>
                            @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Color</label>
                                        <input type="text" class="form-control form-control-sm " wire:model="shoes.{{ $index }}.color" placeholder="White">
                                        @error('shoes.' . $index . '.color')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Service</label>
                                        <select class="form-select form-select-sm " wire:model.live="shoes.{{ $index }}.services_id">
                                            <option value="">-- Select Service --</option>
                                            @foreach($serviceOptions as $service)
                                                <option value="{{ $service['id'] }}">
                                                    {{ $service['name'] }} (Rp {{ number_format($service['price'], 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('shoes.' . $index . '.services_id')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Price (Rp)</label>
                                        <input type="number" class="form-control form-control-sm bg-white" wire:model="shoes.{{ $index }}.price" readonly>
                                         @error('shoes.' . $index . '.price')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                                    </div>

                                    <div class="col-12">
                                        <input type="text" class="form-control form-control-sm" wire:model="shoes.{{ $index }}.notes" placeholder="Note about the initial condition of the shoe...">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- Footer: Total & Submit --}}
                    <div class="card-footer bg-white p-4 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted d-block small">Total Payment</span>
                                <h3 class="fw-bold text-primary mb-0">
                                    Rp {{ number_format($this->total, 0, ',', '.') }}
                                </h3>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <span wire:loading.remove wire:target="save">
                                        <i class="bi bi-check-circle me-1"></i> Save Order
                                    </span>
                                    <span wire:loading wire:target="save">
                                        <span class="spinner-border spinner-border-sm me-1"></span> Saving...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>