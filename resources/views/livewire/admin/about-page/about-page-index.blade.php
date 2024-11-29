<div>
    <section class="section">
        <div class="section-header">
            <h1>About Us</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update About Us</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="form-group">
                        <label>Background</label>
                        <div>
                            <div wire:loading wire:target="image" style="color: red">Uploading...</div>
                            <input wire:model="image" name="image" type="file" class="form-control" />
                            @error('image') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="p-1 bg-primary" width="100" height="100">
                        @else
                            <img src="{{(!empty($about->image))? url('/uploads/'.$about->image) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input wire:model="title" type="text" name="title" class="form-control" value="{{ @$about->title }}">
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Main Title</label>
                        <input wire:model="main_title" type="text" name="main_title" class="form-control" value="{{ @$about->main_title }}">
                        @error('main_title') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group" wire:ignore>
                        <label>Description</label>
                        <textarea wire:model="description" name="description" class="form-control" id="description">{{ old('description') }}</textarea>
                        @error('description') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Youtube Video Link</label>
                        <input wire:model="video_link" type="text" name="video_link" class="form-control" value="{{ @$about->video_link }}">
                        @error('video_link') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
</div>
@script()
<script>

    // tiny editor
    tinymce.init({
        selector: '#description',
        forced_root_block: false,
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
            editor.on('change', function (e) {
                @this.set('description', editor.getContent());
            });
        }
    });
</script>
@endscript
