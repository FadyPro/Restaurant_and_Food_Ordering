<div>
    <section class="section">
        <div class="section-header">
            <h1>Contact</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Updated Contact</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="form-group">
                        <label for="">Phone One</label>
                        <input wire:model="phone_one" type="text" class="form-control" name="phone_one">
                        @error('phone_one') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Phone Two</label>
                        <input wire:model="phone_two" type="text" class="form-control" name="phone_two">
                        @error('phone_two') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Email One</label>
                        <input wire:model="mail_one" type="text" class="form-control" name="mail_one">
                        @error('mail_one') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Email Two</label>
                        <input wire:model="mail_two" type="text" class="form-control" name="mail_two">
                        @error('mail_two') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Address</label>
                        <input wire:model="address" type="text" class="form-control" name="address">
                        @error('address') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Google Map Link</label>
                        <input wire:model="map_link" type="text" class="form-control" name="map_link">
                        @error('map_link') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
</div>
