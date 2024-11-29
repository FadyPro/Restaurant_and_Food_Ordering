<div>
    <section class="section">
        <div class="section-header">
            <h1>Custom Page Builder</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Page</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="form-group">
                        <label>Page Name</label>
                        <input wire:model="name" type="text" name="name" class="form-control">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div wire:ignore class="form-group">
                        <label>Page Contents</label>
                        <textarea wire:model="content" name="content" id="content" class="form-control"></textarea>
                        @error('content') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select wire:model="status" name="status" class="form-control">
                            <option selected="">Choose...</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
</div>
@script('script')
<script>
    // tiny editor
    tinymce.init({
        selector: '#content',
        forced_root_block: false,
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
            editor.on('change', function (e) {
                @this.set('content', editor.getContent());
            });
        }
    });
</script>
@endscript
