<div>
    <section class="section">
        <div class="section-header">
            <h1>Social Link</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Social Link</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf

                    <div class="form-group">
                        <label for="">Icon</label>
                        <input wire:model="icon" name="icon" type="text" class="form-control">
                        @error('icon') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input wire:model="name" type="text" name="name" class="form-control">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Link</label>
                        <input wire:model="link" type="text" name="link" class="form-control">
                        @error('link') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select wire:model="status" name="status" class="form-control">
                            <option selected="">Choose...</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
</div>
