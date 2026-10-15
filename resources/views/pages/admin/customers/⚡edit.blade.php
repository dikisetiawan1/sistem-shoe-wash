<?php

use App\Models\Customers;
use Livewire\Component;
use Livewire\Attributes\Validate;

new class extends Component
{
   
    public Customers $customer;

    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $phone;

    #[Validate('required|email')]
    public $email;

    #[Validate('required')]
    public $address;

    public function mount($id)
    {
        $this->customer = Customers::findOrFail($id);

        // set default value from database
        $this->name = $this->customer->name;
        $this->phone = $this->customer->phone;
        $this->email = $this->customer->email;
        $this->address = $this->customer->address;
    }

    public function update()
    {
        $this->validate();

        // update to database
        $this->customer->update([
            'name'    => $this->name,
            'phone'   => $this->phone,
            'email'   => $this->email,
            'address' => $this->address,
        ]);

        session()->flash('message', 'Data Customer Berhasil Diupdate.');
        return redirect()->route('admin.customers.index');
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::app')
            ->title('Edit Customer');
    }
};
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">

             <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h1 class="mb-5 fs-3"> <i class="fa-solid fa-pen-to-square"></i> Update Data Customer</h1>
              </div>
              <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Data Customer</li>
                  </ol>
                </nav>
              </div>
            </div>
            <!--end::Row-->

            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">

                    <form wire:submit.prevent="update" class="form">
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
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" wire:model="phone">
                            @error('phone')
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
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" wire:model="address">
                            @error('address')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                        <a href="/customers" wire:navigate class="btn btn-md btn-secondary">BACK</a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
