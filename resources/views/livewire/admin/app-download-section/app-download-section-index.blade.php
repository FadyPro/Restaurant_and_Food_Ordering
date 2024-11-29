<div>
    <section class="section">
        <div class="section-header">
            <h1>App Download Section</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Section</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
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
                                    <img src="{{(!empty($AppDownloadSection->image))? url('/uploads/'.$AppDownloadSection->image) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Background</label>
                                <div>
                                    <div wire:loading wire:target="background" style="color: red">Uploading...</div>
                                    <input wire:model="background" name="background" type="file" class="form-control" />
                                    @error('background') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                @if ($background)
                                    <img src="{{ $background->temporaryUrl() }}" class="p-1 bg-primary" width="100" height="100">
                                @else
                                    <img src="{{(!empty($AppDownloadSection->background))? url('/uploads/'.$AppDownloadSection->background) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="">Title</label>
                        <input wire:model="title" type="text" class="form-control" name="title">
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea wire:model="short_description" name="short_description" id="" class="form-control"></textarea>
                        @error('short_description') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Play Store Link <code>(Leave empty for hide)</code></label>
                        <input wire:model="play_store_link" type="text" class="form-control" name="play_store_link">
                        @error('play_store_link') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Apple Store Link <code>(Leave empty for hide)</code></label>
                        <input wire:model="apple_store_link" type="text" class="form-control" name="apple_store_link">
                        @error('apple_store_link') <span class="error">{{ $message }}</span> @enderror
                    </div>


                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
</div>
