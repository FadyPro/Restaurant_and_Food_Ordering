<?php

namespace App\Livewire\Admin\MenuBuilder;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Efectn\Menu\Models\Menus;
use Efectn\Menu\Models\MenuItems;

#[Layout('layouts.admin.master')]
class MenuBuilderCreate extends Component
{
    public function render()
    {
        return view('livewire.admin.menu-builder.menu-builder-create');
    }
}
