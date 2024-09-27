<x-app-layout>
    <div class="overflow-x-auto">
        @if (session('success'))
            <div class="flex items-center justify-between p-4 mb-4 text-white bg-green-500 rounded-lg shadow-md">
                <div>{{ session('success') }}</div>
                <button type="button" class="text-2xl leading-none"
                    onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        

        <h2 class="my-12 text-4xl font-bold text-center">Gestion des utilisateurs</h2>
        <table class="w-full divide-y table-auto whitespace-nowrap">
            <thead class="bg-white">
                <tr>
                    <th class="px-4 py-2 font-medium text-gray-900">ID</th>
                    <th class="px-4 py-2 font-medium text-gray-900">Nom</th>
                    <th class="px-4 py-2 font-medium text-gray-900">Email</th>
                    <th class="px-4 py-2 font-medium text-gray-900">Rôle</th>
                    <th class="px-4 py-2 font-medium text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-2">{{ $user->id }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->role }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" aria-label="modifier"
                                class="text-blue-600 hover:underline">Modifier</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline"
                                onclick="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" role="button"
                                aria-label="enregistrer">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>

<style lang="scss">
    table {
        text-align: left;
    }
</style>
