<div>
    <section class="section">
        <div class="section-header">
            <h1>Banner Slider</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Banner Slider</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="form-group">
                        <label>Image</label>
                        <div>
                            <div wire:loading wire:target="banner" style="color: red">Uploading...</div>
                            <input wire:model="banner" name="banner" type="file" class="form-control" />
                            @error('banner') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        @if ($banner)
                            <img src="{{ $banner->temporaryUrl() }}" class="p-1 bg-primary" width="100" height="100">
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="">Title</label>
                        <input wire:model="title" type="text" class="form-control" name="title">
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Sub Title</label>
                        <input wire:model="sub_title" type="text" class="form-control" name="sub_title">
                        @error('sub_title') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Url</label>
                        <input wire:model="url" type="text" class="form-control" name="url">
                        @error('url') <span class="error">{{ $message }}</span> @enderror
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
