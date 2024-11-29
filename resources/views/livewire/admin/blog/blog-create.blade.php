<div>
    <section class="section">
        <div class="section-header">
            <h1>Blog</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Blog</h4>

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
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input wire:model="title" type="text" name="title" class="form-control" value="{{ old('title') }}">
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group" wire:ignore>
                        <label>Category</label>
                        <select wire:model="category_id" name="category_id" class="form-control select2" id="category_id" >
                            <option value="">select</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group" wire:ignore>
                        <label>Description</label>
                        <textarea wire:model="description" name="description" class="form-control" id="description">{{ old('description') }}</textarea>
                        @error('description') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Seo Title</label>
                        <input wire:model="seo_title" type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}">
                        @error('seo_title') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Seo Description</label>
                        <textarea wire:model="seo_description" name="seo_description" class="form-control" id="">{{ old('seo_description') }}</textarea>
                        @error('seo_description') <span class="error">{{ $message }}</span> @enderror
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
@script()
<script>
    // select2
    $(document).ready(function() {
        $('#category_id').select2();
        $('#category_id').on('change',function (){
            let data = $(this).val()
            console.log(data)
            $wire.set('category_id',data)
        });
    });

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
