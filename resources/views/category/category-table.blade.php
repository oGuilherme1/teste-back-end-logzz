<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800">
                <div class="shadow-md text-gray-900 dark:text-gray-100">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="w-3/4 px-5 py-2 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Nome</th>
                                <th class="w-1/4 px-5 py-2 border-b border-gray-200 bg-gray-50">
                                    <button
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'create-category')"
                                        class="bg-white w-42 border-2 border-black rounded-lg text-gray-900 px-6 py-1 text-base hover:border-green-600 hover:text-green-600 cursor-pointer transition">
                                        Criar Categoria
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($data as $category)
                            <tr>
                                <td class="px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-xs font-medium leading-5 text-gray-900">{{ $category["name"] }}</div>
                                </td>
                                <td class="px-6 py-3 text-sm font-medium leading-5 text-center whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex space-x-2 justify-center">
                                        <button
                                            x-data=""
                                            x-on:click.prevent="
                                            $dispatch('set-data', {
                                                id: {{ $category->id }},
                                                name: '{{ addslashes($category['name']) }}',
                                            });
                                            $dispatch('open-modal', 'update-category')"
                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded hover:bg-green-800">
                                            Editar
                                        </button>
                                        <button
                                            x-data=""
                                            x-on:click.prevent="
                                            $dispatch('set-data', {
                                                id: {{ $category->id }},
                                                name: '{{ addslashes($category['name']) }}',
                                            });
                                            $dispatch('open-modal', 'delete-category')"
                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded hover:bg-red-800">
                                            Deletar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Paginação -->
                    <div class="flex items-center bg-white justify-center m-auto py-3 space-x-4">
                        <button
                            onclick="handlePageChange({{ $data->currentPage() - 1 }}, {{ $data->lastPage() }})"
                            @if($data->currentPage() === 1) disabled @endif
                            class="flex items-center px-4 py-2 text-sm font-semibold text-green-600 bg-white rounded-lg shadow-md transition duration-200 {{ $data->currentPage() === 1 ? 'cursor-not-allowed' : 'hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2' }}">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 0l3 3m-3-3l3-3" />
                            </svg>
                            Previous
                        </button>

                        <span class="text-sm font-medium text-gray-800">
                            Page {{ $data->currentPage() }} of {{ $data->lastPage() }}
                        </span>

                        <button
                            onclick="handlePageChange({{ $data->currentPage() + 1 }}, {{ $data->lastPage() }})"
                            @if($data->currentPage() === $data->lastPage()) disabled @endif
                            class="flex items-center px-4 py-2 text-sm font-semibold text-green-600 bg-white rounded-lg shadow-md transition duration-200 {{ $data->currentPage() === $data->lastPage() ? 'cursor-not-allowed' : 'hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2' }}">
                            Next
                            <svg class="w-6 h-6 ml-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m6 0l-3-3m3 3l-3 3" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-modal name="create-category" :show="$errors->getBag('create')->any()" focusable>
        <form method="post" action="{{ route('category.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Criar Categoria') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Insira os detalhes da categoria abaixo.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="name" value="{{ __('Nome da Categoria') }}" />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Nome da Categoria') }}"
                    required />
                <x-input-error :messages="$errors->getBag('create')->get('name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Criar Categoria') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <x-modal name="update-category" :show="$errors->getBag('update')->any()" focusable>
        <form method="post" x-bind:action="`{{ route('category.update', '') }}/${productData.id}`" class="p-6">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Atualizar Categoria') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Atualize os detalhes da categoria abaixo.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="name" value="{{ __('Nome da Categoria') }}" />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Nome da Categoria') }}"
                    x-bind:value="productData.name"
                    required />
                <x-input-error :messages="$errors->getBag('update')->get('name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Atualizar Categoria') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Modal de Confirmação para Deletar Categoria -->
    <x-modal name="delete-category" focusable>
        <form method="post" x-bind:action="`{{ route('category.destroy', '') }}/${productData.id}`" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Deletar Categoria') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Tem certeza que deseja deletar esta categoria? Essa ação não pode ser desfeita.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" autofocus>
                    {{ __('Deletar Categoria') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>


</x-app-layout>