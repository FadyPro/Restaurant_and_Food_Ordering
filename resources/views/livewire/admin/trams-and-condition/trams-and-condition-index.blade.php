<div>
    <section class="section">
        <div class="section-header">
            <h1>Terms and Conditions</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Terms and Conditions</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="form-group" wire:ignore>
                        <label>Content</label>
                        <textarea wire:model="content" name="content" class="form-control" id="content"></textarea>
                        @error('content') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
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
