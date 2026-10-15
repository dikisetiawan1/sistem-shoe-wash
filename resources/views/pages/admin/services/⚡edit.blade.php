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
    public $description;

    #[Validate('required|numeric|min:0')]
    public $price;

     #[Validate('required')]
    public $estimated_days;

    public function mount($id)
    {
        $this->service = Services::findOrFail($id);

        // set default value from database
        $this->name = $this->service->name;
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
            'description'   => $this->description,
            'price'   => $this->price,
            'estimated_days'   => $this->estimated_days,
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
            <div class="row">
              <div class="col-sm-6">
                <h1 class="mb-5 fs-3"> <i class="fa-solid fa-pen-to-square"></i> Update Data Service</h1>
              </div>
              <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Data Service</li>
                  </ol>
                </nav>
              </div>
            </div>
            <!--end::Row-->

            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">

                    <form wire:submit.prevent="update" class="form">
                        <div class="mb-3">
                            <label class="form-label">Service Name</label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name')
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

                        <div class="mb-3">
                            <label class="form-label">Estimated Days</label>
                            <input type="number" class="form-control" wire:model="estimated_days">
                            @error('estimated_days')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                        <a href="/services" wire:navigate class="btn btn-md btn-secondary">BACK</a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
