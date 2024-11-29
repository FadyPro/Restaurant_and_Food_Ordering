<div>
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Create Slid</h4>

                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
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
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Offer</label>
                            <input wire:model="offer" type="text" class="form-control" name="offer">
                            @error('offer') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input wire:model="title" type="text" class="form-control" name="title">
                            @error('title') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Sub Title</label>
                            <input wire:model="sub_title" type="text" class="form-control" name="sub_title">
                            @error('sub_title') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Short Description</label>
                            <textarea wire:model="short_description" name="short_description" class="form-control"></textarea>
                            @error('short_description') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Button Link</label>
                            <input wire:model="button_link" type="text" class="form-control" name="button_link">
                            @error('button_link') <span class="error">{{ $message }}</span> @enderror
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
