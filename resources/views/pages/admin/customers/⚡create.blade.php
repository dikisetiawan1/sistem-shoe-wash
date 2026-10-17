<?php

use App\Models\Customers;
use Livewire\Component;
use Livewire\Attributes\Validate;

new class extends Component
{
    #[Validate('required')]
    public $name;

    #[Validate('required|email|unique:customers')]
    public $email;

     #[Validate('required')]
    public $phone;

    #[Validate('required')]
    public $address;


    public function store()
    {
        $this->validate();

      
        // insert data
        Customers::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        // flash message
        session()->flash('message', 'Data Customer Berhasil Disimpan.');

        // redirect to index
        return redirect()->route('admin.customers.index');
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::app')
            ->title('Create Customer');
    }
};
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">

              <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h1 class="mb-5 fs-3"> <i class="fa-solid fa-circle-plus"></i> Create New Customer</h1>
              </div>
              <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item active" aria-current="page"> Our Customers</li>
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
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" wire:model="email">
                            @error('email')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" wire:model="phone">
                            @error('phone')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" wire:model="address" rows="3"></textarea>
                            @error('address')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                           

                        <button type="submit" class="btn btn-md btn-primary">SAVE</button>
                        <a href="/customers" wire:navigate class="btn btn-md btn-secondary">BACK</a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
