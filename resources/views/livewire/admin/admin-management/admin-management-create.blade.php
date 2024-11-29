<div>
    <section class="section">
        <div class="section-header">
            <h1>Admin Management</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Admin</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input wire:model="name" type="text" name="name" class="form-control">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input wire:model="email" type="text" name="email" class="form-control">
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select wire:model="role" name="role" id="" class="form-control">
                            <option selected="">Choose...</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input wire:model="password" type="password" name="password" class="form-control">
                        @error('password') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input wire:model="password_confirmation" type="password" name="password_confirmation" class="form-control">
                        @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
</div>
