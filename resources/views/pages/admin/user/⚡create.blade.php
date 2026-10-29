<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Branches;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Validate;


new class extends Component
{
   
    public $name;
    public $email;
    public $password;
    public $role;
    public $branch_id;

    
    protected $rules = [
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|min:6',
        'role'  => 'required',
        'branch_id' => 'required|integer'
    ];
    
    public function store()
    {
        $this->validate();

      
        // insert data
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password'  => Hash::make($this->password),
            'role' => $this->role,    
            'branch_id' => $this->branch_id,
        ]);

        // flash message
        session()->flash('message', 'Data User Berhasil Disimpan.');

        // redirect to index
        return redirect()->route('admin.user.index');
    }

    public function render()
        
    {

        $branches = Branches::all();
        return $this->view([
            'branches' => $branches
        ]
        )
            ->layout('layouts::app')
            ->title('Create Users');
    }
};
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">

             <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="fw-bold mb-0 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Tambah User</h4>
                        <small class="text-muted">Kelola seluruh user </small>
                    </div>
                    
                </div>

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
                        <label for="branch_id" class="form-label">Branch</label>
                                    
                                    <!-- Hubungkan dengan properti branch_id di class Livewire -->
                                    <select wire:model="branch_id" class="form-select @error('branch_id') is-invalid @enderror" id="branch_id">
                                        <option value="">-- Pilih Cabang --</option>
                                        
                                        @foreach ($branches as $branch)
                                            <!-- value diisi ID cabang, teks yang tampil di layar adalah Nama Cabang -->
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('branch_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                        </div>

                        <div class="mb-3">
                               <label for="role" class="form-label ">Role</label>
                                    
                                    <!-- Hubungkan dengan properti branch_id di class Livewire -->
                                    <select wire:model="role" class="form-select @error('role') is-invalid @enderror" id="role">
                                        <option value="">-- Pilih Role --</option>
                                            <option value="admin">Admin</option>
                                            <option value="owner">Owner</option>
                                    </select>

                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                        </div>

                         <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" wire:model="password">
                            @error('password')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                           

                        <button type="submit" class="btn text-white fw-semibold border-0 shadow-sm px-3 py-2" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);">SAVE</button>
                        <a href="/settings/user" wire:navigate class="btn btn-md btn-secondary">BACK</a>

                    </form>
            </div>
                </div>
            </div>

        </div>
    </div>
</div>