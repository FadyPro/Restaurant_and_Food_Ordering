<div>
    <section class="section">
        <div class="section-header">
            <h1>Menu builder</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Main Menu builder</h4>

            </div>
            <div class="card-body">
                {!! Menu::render() !!}
            </div>
        </div>
    </section>
    //YOU MUST HAVE JQUERY LOADED BEFORE menu scripts
    @push('scripts')
        {!! Menu::scripts() !!}
    @endpush
</div>
