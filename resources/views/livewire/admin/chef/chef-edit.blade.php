<div>
    <section class="section">
        <div class="section-header">
            <h1>Chefs</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Chef</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="form-group">
                        <label>Image</label>
                        <div>
                            <div wire:loading wire:target="image" style="color: red">Uploading...</div>
                            <input wire:model="image" name="image" type="file" class="form-control" />
                            @error('image') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="p-1 bg-primary" width="100" height="100">
                        @else
                            <img src="{{(!empty($chef->image))? url('/uploads/chefs/'.$chef->image) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="">Name</label>
                        <input wire:model="name" type="text" class="form-control" name="name">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Title</label>
                        <input wire:model="title" type="text" class="form-control" name="title">
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <br>
                    <h5>Social Links</h5>
                    <div class="form-group">
                        <label for="">Facebook <code>(Leave empty for hide)</code></label>
                        <input wire:model="fb" type="text" class="form-control" name="fb">
                        @error('fb') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Linkedin <code>(Leave empty for hide)</code></label>
                        <input wire:model="in" type="text" class="form-control" name="in">
                        @error('in') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="">X <code>(Leave empty for hide)</code></label>
                        <input wire:model="x" type="text" class="form-control" name="x">
                        @error('x') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Web <code>(Leave empty for hide)</code></label>
                        <input wire:model="web" type="text" class="form-control" name="web">
                        @error('web') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Show at Home</label>
                        <select wire:model="show_at_home" name="show_at_home" class="form-control" id="">
                            <option selected="">Choose...</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
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
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
</div>
