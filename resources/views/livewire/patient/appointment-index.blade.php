<?php

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

function showAppointmentStatus(): bool
{
    $appointment = Appointment::where('user_id', Auth::user()->id);
    if ($appointment->exists())
        return $appointment->where('status', 'pending')->exists();

    return false;
}

new class extends Component {

    public bool $show_history = false;

    public function showHistory(): void {
        $this->show_history = !$this->show_history;
    }

}; ?>

<x-empty-card class="flex-row space-y-8 p-8 bg-white font-normal dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

    <x-slot name="header" class="flex flex-nowrap items-center justify-between font-bold text-srx-blue dark:text-srx-white">
        @if($show_history)
            <h2 class="text-3xl">History</h2>
        @endif

        @if(!showAppointmentStatus() && !$show_history)
            <h2 class="text-3xl">Create an Appointment</h2>
        @endif

        <x-secondary-button wire:click="showHistory">
            @if($show_history)
                <x-heroicons::solid.clipboard-document-list/>
            @else
                <x-heroicons::solid.clock/>
            @endif
        </x-secondary-button>
    </x-slot>

    @if($show_history)
        <livewire:patient.appointment-history wire:navigate>
    @else
        @if(showAppointmentStatus())
            <livewire:patient.appointment-status wire:navigate>
        @else
            <livewire:patient.create-appointment wire:navigate>
       @endif
    @endif

</x-empty-card>