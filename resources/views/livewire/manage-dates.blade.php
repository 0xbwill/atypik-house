<div>
    @if (session()->has('message'))
        <div class="p-4 my-4 text-green-800 bg-green-300 rounded-md">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <button id="bookButton" class="px-4 py-2 mt-4 text-white rounded-md bg-vert focus:outline-none" role="button"
    aria-label="Ajouter des disponibilités">
        <i class="mr-2 fas fa-calendar-alt"></i> Ajouter des disponibilités
    </button>
    <div id="calendarContainer" class="hidden mt-4">
        <input type="text" id="calendar" placeholder="Sélectionner une date"
            class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-semibold">Créneaux disponibles</h2>
        <table class="min-w-full mt-4 bg-white divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date de début</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date de fin</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($datesDuLogement as $date)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $date['debut_dispo'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $date['fin_dispo'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button wire:click="deleteDate({{ $date['id'] }})" class="text-red-600 hover:text-red-900" role="button"
                            aria-label="Supprimer">Supprimer</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('bookButton').addEventListener('click', function() {
                document.getElementById('calendarContainer').classList.toggle('hidden');

                flatpickr('#calendar', {
                    mode: 'range',
                    minDate: 'today',
                    dateFormat: 'd/m/Y',
                    locale: 'fr',
                    onClose: function(selectedDates, dateStr, instance) {
                        console.log(selectedDates);
                        if (selectedDates.length == 2) {
                            @this.call('updateDates', selectedDates);
                        }
                    }
                });
            });
        });
    </script>
</div>
