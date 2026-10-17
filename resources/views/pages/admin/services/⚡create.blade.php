<?php

use App\Models\Services;
use Livewire\Component;
use Livewire\Attributes\Validate;

new class extends Component
{
    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $description;

     #[Validate('required|numeric')]
    public $price;

    #[Validate('required|numeric')]
    public $estimated_days;


    public function store()
    {
        $this->validate();

      
        // insert data
        Services::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'estimated_days' => $this->estimated_days,
        ]);

        // flash message
        session()->flash('message', 'Data Services Berhasil Disimpan.');

        // redirect to index
        return redirect()->route('admin.services.index');
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::app')
            ->title('Create Services');
    }
};
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">

              <!--begin::Row-->
            <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">Tambah Layanan</h4>
                        <small class="text-muted">Kelola seluruh data layanan</small>
                    </div>
            </div>
            <!--end::Row-->

            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">

                    <form wire:submit.prevent="store" class="form">


                        <div class="mb-3">
                            <label class="form-label">Name Service</label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" wire:model="description" rows="3"></textarea>
                            @error('description')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" wire:model="price">
                            @error('price')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Estimated Days</label>
                            <input type="number" class="form-control" wire:model="estimated_days">
                            @error('estimated_days')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-md btn-primary">SAVE</button>
                        <a href="/services" wire:navigate class="btn btn-md btn-secondary">BACK</a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
