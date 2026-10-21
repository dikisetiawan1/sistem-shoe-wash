<?php

use App\Models\Branches;
use Livewire\Component;
use Livewire\Attributes\Validate;

new class extends Component
{
    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $address;

    #[Validate('required')]
    public $notlp;


    public function store()
    {
        $this->validate();

      
        // insert data
        Branches::create([
            'name' => $this->name,
            'address' => $this->address,
            'notlp' => $this->notlp,
        ]);

        // flash message
        session()->flash('message', 'Data Branches Berhasil Disimpan.');

        // redirect to index
        return redirect()->route('admin.branches.index');
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::app')
            ->title('Create Branches');
    }
};
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">

              <!--begin::Row-->
            <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">Tambah Toko</h4>
                        <small class="text-muted">Kelola seluruh data layanan</small>
                    </div>
            </div>
            <!--end::Row-->

            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">

                    <form wire:submit.prevent="store" class="form">


                        <div class="mb-3">
                            <label class="form-label">Branch</label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" wire:model="address">
                            @error('address')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No Tlp</label>
                            <input type="text" class="form-control" wire:model="notlp">
                            @error('notlp')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                       

                        <button type="submit" class="btn btn-md btn-primary">SAVE</button>
                        <a href="/branches" wire:navigate class="btn btn-md btn-secondary">BACK</a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
