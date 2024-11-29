<div>
    <section class="section">
        <div class="section-header">
            <h1>Blog Categories</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Blog Category</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="form-group">
                        <label for="">Name</label>
                        <input wire:model="name" type="text" class="form-control" name="name">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
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
