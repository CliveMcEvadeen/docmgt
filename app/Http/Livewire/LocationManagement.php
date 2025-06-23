<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Location;

class LocationManagement extends Component
{
    public string $layout = 'layouts.app';

    public $name, $address;
    public $editLocationId = null;
    public $showModal = false;

    public function mount()
    {
        \Log::info('Mounting LocationManagement component');
    }

    protected $rules = [
        'name' => 'required|string|max:255|unique:locations,name',
        'address' => 'required|string|max:500',
    ];

    public function render()
    {
        \Log::info('Rendering LocationManagement component');
        $locations = Location::orderBy('name')->get();
        return view('livewire.location-management', compact('locations'));
    }

    public function showCreateModal()
    {
        $this->reset(['name', 'address', 'editLocationId']);
        $this->showModal = true;
    }

    public function createLocation()
    {
        $this->validate();
        Location::create([
            'name' => $this->name,
            'address' => $this->address,
        ]);
        $this->showModal = false;
        session()->flash('success', 'Location created successfully!');
    }

    public function editLocation($id)
    {
        $location = Location::findOrFail($id);
        $this->editLocationId = $id;
        $this->name = $location->name;
        $this->address = $location->address;
        $this->showModal = true;
    }

    public function updateLocation()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:locations,name,'.$this->editLocationId,
            'address' => 'required|string|max:500',
        ]);
        $location = Location::findOrFail($this->editLocationId);
        $location->name = $this->name;
        $location->address = $this->address;
        $location->save();
        $this->showModal = false;
        session()->flash('success', 'Location updated successfully!');
    }

    public function deleteLocation($id)
    {
        Location::findOrFail($id)->delete();
        session()->flash('success', 'Location deleted successfully!');
    }
}
