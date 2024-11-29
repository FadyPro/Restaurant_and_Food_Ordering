<div>
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Product</h4>

            </div>
            <div class="card-body">
                <form wire:submit.prevent="save">
                    @csrf
                    <div class="form-group">
                        <label>Image</label>
                        <div>
                            <div wire:loading wire:target="thumb_image" style="color: red">Uploading...</div>
                            <input wire:model="thumb_image" name="thumb_image" type="file" class="form-control" />
                            @error('thumb_image') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        @if ($thumb_image)
                            <img src="{{ $thumb_image->temporaryUrl() }}" class="p-1 bg-primary" width="100" height="100">
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input wire:model="name" type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group" wire:ignore>
                        <label>Category</label>
                        <select wire:model="category_id" name="category" class="form-control select2" id="" >
                            <option value="">select</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input wire:model="price" type="text" name="price" class="form-control" value="{{ old('price') }}">
                        @error('price') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Offer Price</label>
                        <input wire:model="offer_price" type="text" name="offer_price" class="form-control" value="{{ old('offer_price') }}">
                        @error('offer_price') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Quantity</label>
                        <input wire:model="quantity" type="text" name="quantity" class="form-control" value="{{ old('quantity') }}">
                        @error('quantity') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea wire:model="short_description" name="short_description" class="form-control" id="">{{ old('short_description') }}</textarea>
                        @error('short_description') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group" wire:ignore>
                        <label>Long Description</label>
                        <textarea wire:model="long_description" name="long_description" class="form-control" id="long_description"></textarea>
                        @error('long_description') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Sku</label>
                        <input wire:model="sku" type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                        @error('sku') <span class="error">{{ $message }}</span> @enderror
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
                        <label>Show at Home</label>
                        <select wire:model="show_at_home" name="show_at_home" class="form-control" id="">
                            <option selected="">Choose...</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        @error('show_at_home') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select wire:model="status" name="status" class="form-control" id="">
                            <option selected="">Choose...</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </section>
</div>
@script()
<script>
    // select2
    $(document).ready(function() {
        $('#facilities').select2();
        $('#facilities').on('change',function (){
            let data = $(this).val()
            console.log(data)
            $wire.set('facility',data)
        });
    });

    // tiny editor
    tinymce.init({
        selector: '#long_description',
        forced_root_block: false,
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
            editor.on('change', function (e) {
            @this.set('long_description', editor.getContent());
            });
        }
    });
</script>
@endscript
