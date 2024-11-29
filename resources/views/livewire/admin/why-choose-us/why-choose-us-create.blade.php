<div>
    <section class="section">
        <div class="section-header">
            <h1>why choose us</h1>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Create why choose us</h4>

                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        @csrf
                        <div class="form-group">
                            <label>Icon</label>
                            <input wire:model="icon" role="iconpicker" class="form-control" name="icon">
                           <h3><a href="https://fontawesome.com/icons">Icons</a></h3>
                            @error('icon') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input wire:model="title" type="text" class="form-control" name="title">
                            @error('title') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Short Description</label>
                            <textarea wire:model="short_description" name="short_description" class="form-control"></textarea>
                            @error('short_description') <span class="error">{{ $message }}</span> @enderror
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
