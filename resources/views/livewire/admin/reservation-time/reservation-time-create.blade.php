<div>
    <section class="section">
        <div class="section-header">
            <h1>Reservation Times</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Time</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="form-group">
                        <label>Start Time</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                            </div>
                            <input
                                wire:model.live="start_time"
                                type="text" class="form-control timepicker" autocomplete="off"
                                data-toggle="datetimepicker" data-target="#datetimepicker3"
                                id="datetimepicker3"
                                onchange="this.dispatchEvent(new InputEvent('input'))"
                            >
                        </div>
                        @error('start_time') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>End Time</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                            </div>
                            <input
                                wire:model.live="end_time"
                                type="text" class="form-control timepicker" autocomplete="off"
                                data-toggle="datetimepicker" data-target="#datetimepicker4"
                                id="datetimepicker4"
                                onchange="this.dispatchEvent(new InputEvent('input'))"
                            >
                        </div>
                        @error('end_time') <span class="error">{{ $message }}</span> @enderror
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
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('datetimepicker3').datetimepicker({
                format: 'LT'
            });
        })
    </script>
@endpush
