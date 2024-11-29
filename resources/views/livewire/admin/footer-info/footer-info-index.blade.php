<div>
    <section class="section">
        <div class="section-header">
            <h1>Footer Info</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Footer Info</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="form-group">
                        <label>Short Info</label>
                        <textarea wire:model="short_info" name="short_info" class="form-control"></textarea>
                        @error('short_info') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input wire:model="address" type="text" name="address" class="form-control">
                        @error('address') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input wire:model="phone" type="text" name="phone" class="form-control">
                        @error('phone') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input wire:model="email" type="text" name="email" class="form-control">
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Copyright</label>
                        <input wire:model="copyright" type="text" name="copyright" class="form-control">
                        @error('copyright') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
</div>
