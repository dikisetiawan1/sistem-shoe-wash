<?php

use App\Models\Branches;
use Livewire\Component;
use Livewire\Attributes\Validate;

new class extends Component
{
   
    public Branches $branches;

    #[Validate('required')]
    public $name;

      #[Validate('required')]
    public $address;

    #[Validate('required')]
    public $notlp;

  

    public function mount($id)
    {
        $this->branches = Branches::findOrFail($id);

        // set default value from database
        $this->name = $this->branches->name;
        $this->address = $this->branches->address;
        $this->notlp = $this->branches->notlp;
    }

    public function update()
    {
        $this->validate();

        // update to database
        $this->branches->update([
            'name'    => $this->name,
            'address' => $this->address,
            'notlp'   => $this->notlp,
        ]);

        session()->flash('message', 'Data Branches Berhasil Diupdate.');
        return redirect()->route('admin.branches.index');
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::app')
            ->title('Edit Branches');
    }
};
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
<!--begin::Row-->
            <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="fw-bold mb-0 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Update Branch</h4>
                        <small class="text-muted">Kelola seluruh data layanan</small>
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


                        <button type="submit" class="btn text-white fw-semibold border-0 shadow-sm px-3 py-2" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);">UPDATE</button>
                        <a href="/masterdata/branches" wire:navigate class="btn btn-md btn-secondary">BACK</a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
