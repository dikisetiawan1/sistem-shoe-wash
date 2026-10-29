<?php

use App\Models\Services;
use Livewire\Component;
use Livewire\Attributes\Validate;

new class extends Component
{
   
    public Services $service;

    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $category;

    #[Validate('required')]
    public $description;

    #[Validate('required|numeric|min:0')]
    public $price;

    public function mount($id)
    {
        $this->service = Services::findOrFail($id);

        // set default value from database
        $this->name = $this->service->name;
        $this->category = $this->service->category;
        $this->description = $this->service->description;
        $this->price = $this->service->price;
        $this->estimated_days = $this->service->estimated_days;
    }

    public function update()
    {
        $this->validate();

        // update to database
        $this->service->update([
            'name'    => $this->name,
            'category'    => $this->category,
            'description'   => $this->description,
            'price'   => $this->price,
        ]);

        session()->flash('message', 'Data Service Berhasil Diupdate.');
        return redirect()->route('admin.services.index');
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::app')
            ->title('Edit Service');
    }
};
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">

             <!--begin::Row-->
            <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">Update Layanan</h4>
                        <small class="text-muted">Kelola seluruh data layanan</small>
                    </div>
            </div>
            <!--end::Row-->

            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">

                    <form wire:submit.prevent="update" class="form">
                        <div class="mb-3">
                            <label class="form-label">Service </label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            {{-- <input type="text" class="form-control" wire:model="category"> --}}
                             <select type="text" class="form-control" name="category" id="" wire:model="category">
                                <option value="sepatu">Sepatu</option>
                                <option value="other">Other</option>
                            </select>
                            @error('category')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" wire:model="description">
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

                        <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                        <a href="/masterdata/services" wire:navigate class="btn btn-md btn-secondary">BACK</a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
