<?php

use App\Models\ShoeCategory;
use Livewire\Component;
use Livewire\Attributes\Validate;

new class extends Component
{
    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $brand;

     #[Validate('required')]
    public $description;

   


    public function store()
    {
        $this->validate();

      
        // insert data
        ShoeCategory::create([
            'name' => $this->name,
            'brand' => $this->brand,
            'description' => $this->description,
        ]);

        // flash message
        session()->flash('message', 'Data Shoe Type Berhasil Disimpan.');

        // redirect to index
        return redirect()->route('admin.shoetype.index');
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::app')
            ->title('Create Shoe Type');
    }
};
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">

              <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                
                <h1 class="mb-5 fs-3"> <i class="fa-solid fa-circle-plus"></i> Create New Shoe Type</h1>
              </div>
              <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item active" aria-current="page">Shoe Type</li>
                    <li class="breadcrumb-item"><a href="#">Create</a></li>
                  </ol>
                </nav>
              </div>
            </div>
            <!--end::Row-->

            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">

                    <form wire:submit.prevent="store" class="form">


                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Brand</label>
                            <input type="text" class="form-control" wire:model="brand">
                            @error('brand')
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
                        <button type="submit" class="btn btn-md btn-primary">SAVE</button>
                        <a href="/shoetype" wire:navigate class="btn btn-md btn-secondary">BACK</a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
