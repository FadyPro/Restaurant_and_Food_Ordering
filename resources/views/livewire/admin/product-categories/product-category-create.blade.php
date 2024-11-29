<div>
    <section class="section">
        <div class="section-header">
            <h1>Product Categories</h1>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Create Product Categories</h4>

                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input wire:model="name" class="form-control" name="name">
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Show at Home</label>
                            <select wire:model="show_at_home" class="form-control">
                                <option selected="">Choose...</option>
                                <option value="1">Yes</option>
                                <option selected value="0">No</option>
                            </select>
                            @error('show_at_home') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select wire:model="status" class="form-control">
                                <option selected="">Choose...</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('status') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>
