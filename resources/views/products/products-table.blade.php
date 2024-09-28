<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800">
                <!-- Filter Section -->
                <div class="px-6 py-4 shadow-md rounded-t-lg overflow-hidden">
                    <form method="GET" action="{{ route('products.index') }}" class="flex space-x-4">
                        <div class="">
                            <x-input-label for="category" value="{{ __('Categoria') }}" />
                            <select
                                id="category_filter"
                                name="category"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-off-white dark:text-gray-500 
                                focus:border-green-700 dark:focus:border-green-700 
                                focus:ring-2 focus:ring-green-700 dark:focus:ring-green-700 
                                rounded-md shadow-sm"
                                placeholder="{{ __('Descrição do Produto') }}">
                                <option value="" disabled selected>{{ __('Selecione uma categoria') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="name" value="{{ __('Nome') }}" />
                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="{{ __('Nome do Produto') }}" />
                        </div>
                        <div class="flex items-center mt-5">
                            <input type="checkbox" id="without_image" name="without_image" class="mr-2">
                            <x-input-label for="without_image" value="{{ __('Sem Imagem') }}" />
                        </div>
                        <div class="flex items-center mt-5">
                            <input type="checkbox" id="with_image" name="with_image" class="mr-2">
                            <x-input-label for="with_image" value="{{ __('Com Imagem') }}" />
                        </div>
                        <div class="flex items-center mt-5">
                            <x-primary-button type="submit">
                                {{ __('Filtrar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
                <div class="shadow-md text-gray-900 dark:text-gray-100">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="w-2/4 px-5 py-2 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Nome</th>
                                <th class="w-1/6 px-5 py-2 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Preço</th>
                                <th class="w-1/6 px-5 py-2 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Categoria</th>
                                <th class="w-4/4 px-5 py-2 text-xs font-medium leading-4 tracking-wider text-center text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Imagem</th>
                                <th class="w-2/6 px-5 py-2 border-b border-gray-200 bg-gray-50">
                                    <button
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'create-product')"
                                        class="bg-white border-2 w-46  border-black rounded-lg text-gray-900 px-6 py-1 text-base hover:border-green-600 hover:text-green-600 cursor-pointer transition">
                                        Criar Produto
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($data as $product)
                            <tr>
                                <td class="px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-xs font-medium leading-5 text-gray-900">{{ $product["name"] }}</div>
                                </td>
                                <td class="px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-xs leading-5 text-gray-900">{{ 'R$ ' . number_format($product->price, 2, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-xs leading-5 text-gray-900">{{ $product->category->name }}</div>
                                </td>

                                <td class="px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                    <img class="w-10 h-10 rounded-full m-auto" src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" />
                                </td>

                                <td class="px-6 py-3 text-sm font-medium leading-5 text-center whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex space-x-2 justify-center">
                                        <button
                                            x-data=""
                                            x-on:click.prevent="
                                                $dispatch('set-data', {
                                                    id: {{ $product->id }},
                                                    name: '{{ addslashes($product['name']) }}',
                                                    price: '{{ number_format($product['price'], 2, ',', '.')}}',
                                                    category: '{{ addslashes($product->category->name) }}',
                                                    category_id: {{ $product->category->id }},
                                                    description: '{{ addslashes($product['description']) }}',
                                                    image_url: '{{ $product['image_url'] }}'
                                                });
                                            $dispatch('open-modal', 'view-product')"
                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold border border-gray-200 text-green-600 bg-white rounded hover:bg-white-600">
                                            Visualizar
                                        </button>
                                        <button
                                            x-data=""
                                            x-on:click.prevent="
                                                $dispatch('set-data', {
                                                    id: {{ $product->id }},
                                                    name: '{{ addslashes($product['name']) }}',
                                                    price: '{{ number_format($product['price'], 2, ',', '.')}}',
                                                    category: '{{ addslashes($product->category->name) }}',
                                                    category_id: {{ $product->category->id }},
                                                    description: '{{ addslashes($product['description']) }}',
                                                    image_url: '{{ $product['image_url'] }}'
                                                });
                                            $dispatch('open-modal', 'update-product')"
                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded hover:bg-green-800">
                                            Editar
                                        </button>
                                        <button
                                            x-data=""
                                            x-on:click.prevent="
                                            $dispatch('set-data', {
                                                id: {{ $product->id }},
                                                name: '{{ addslashes($product['name']) }}',
                                            });
                                            $dispatch('open-modal', 'delete-product')"
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

    <!-- Criar Produto -->
    <x-modal name="create-product" :show="$errors->getBag('create')->any()" focusable>
        <form method="post" action="{{ route('products.store') }}" class="p-6" enctype="multipart/form-data">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Criar Produto') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Insira os detalhes do produto abaixo.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="name" value="{{ __('Nome do Produto') }}" />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Nome do Produto') }}"
                    required />
                <x-input-error :messages="$errors->getBag('create')->get('name')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="description" value="{{ __('Descrição') }}" />
                <textarea
                    id="description"
                    name="description"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-off-white dark:text-gray-500 
                focus:border-green-700 dark:focus:border-green-700 
                focus:ring-2 focus:ring-green-700 dark:focus:ring-green-700 
                rounded-md shadow-sm"
                    placeholder="{{ __('Descrição do Produto') }}"
                    required></textarea>
                <x-input-error :messages="$errors->getBag('create')->get('description')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="category" value="{{ __('Categoria') }}" />
                <select
                    id="category_create"
                    name="category"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-off-white dark:text-gray-500 
                focus:border-green-700 dark:focus:border-green-700 
                focus:ring-2 focus:ring-green-700 dark:focus:ring-green-700 
                rounded-md shadow-sm"
                    placeholder="{{ __('Descrição do Produto') }}"
                    required>
                    <option value="" disabled selected>{{ __('Selecione uma categoria') }}</option>
                </select>
                <x-input-error :messages="$errors->getBag('create')->get('category')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="price" value="{{ __('Preço') }}" />
                <x-text-input
                    id="price"
                    name="price"
                    type="text"
                    class="mt-1 block w-1/2"
                    placeholder="{{ __('Preço') }}"
                    required />
                <x-input-error :messages="$errors->getBag('create')->get('price')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="image" value="{{ __('Imagem do Produto') }}" />
                <input
                    id="image"
                    name="image"
                    type="file"
                    accept="image/*"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-off-white dark:text-gray-500 
                focus:border-green-700 dark:focus:border-green-700 
                focus:ring-2 focus:ring-green-700 dark:focus:ring-green-700 
                rounded-md shadow-sm" />
                <x-input-error :messages="$errors->getBag('create')->get('image')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Criar Produto') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Modal -->
    <x-modal name="update-product" :show="$errors->getBag('update')->any()" focusable>
        <form method="post" x-bind:action="`{{ route('products.update', '') }}/${productData.id}`" class="p-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Atualizar Produto') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Insira os detalhes do produto abaixo.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="name" value="{{ __('Nome do Produto') }}" />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Nome do Produto') }}"
                    x-bind:value="productData.name"
                    required />
                <x-input-error :messages="$errors->getBag('update')->get('name')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="description" value="{{ __('Descrição') }}" />
                <textarea
                    id="description"
                    name="description"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-off-white dark:text-gray-500 
                focus:border-green-700 dark:focus:border-green-700 
                focus:ring-2 focus:ring-green-700 dark:focus:ring-green-700 
                rounded-md shadow-sm"
                    placeholder="{{ __('Descrição do Produto') }}"
                    required
                    x-bind:value="productData.description">

                </textarea>
                <x-input-error :messages="$errors->getBag('update')->get('description')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="category" value="{{ __('Categoria') }}" />
                <select
                    id="category_update"
                    name="category"
                    x-model="productData.category_id"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-off-white dark:text-gray-500 
                focus:border-green-700 dark:focus:border-green-700 
                focus:ring-2 focus:ring-green-700 dark:focus:ring-green-700 
                rounded-md shadow-sm"
                    required>
                    <option value="" disabled selected>Selecione uma categoria</option>
                    <template x-for="category in categories" :key="category.id">
                        <option :value="category.id" x-text="category.name"></option>
                    </template>
                </select>
                <x-input-error :messages="$errors->getBag('update')->get('category')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="price" value="{{ __('Preço') }}" />
                <x-text-input
                    id="price"
                    name="price"
                    type="text"
                    class="mt-1 block w-1/2"
                    placeholder="{{ __('Preço') }}"
                    required
                    x-bind:value="productData.price" />
                <x-input-error :messages="$errors->getBag('update')->get('price')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="image" value="{{ __('Imagem do Produto') }}" />
                <input
                    id="image"
                    name="image"
                    type="file"
                    accept="image/*"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-off-white dark:text-gray-500 
                focus:border-green-700 dark:focus:border-green-700 
                focus:ring-2 focus:ring-green-700 dark:focus:ring-green-700 
                rounded-md shadow-sm" />
                <x-input-error :messages="$errors->getBag('update')->get('image')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Atualizar Produto') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>


    <x-modal name="view-product" :show="$errors->any()" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Visualizar Produto') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Aqui estão os detalhes do produto.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="name" value="{{ __('Nome do Produto') }}" />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Nome do Produto') }}"
                    x-bind:value="productData.name"
                    readonly />
            </div>

            <div class="mt-6">
                <x-input-label for="description" value="{{ __('Descrição') }}" />
                <textarea
                    id="description"
                    name="description"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-off-white dark:text-gray-500 
                focus:border-green-700 dark:focus:border-green-700 
                focus:ring-2 focus:ring-green-700 dark:focus:ring-green-700 
                rounded-md shadow-sm"
                    placeholder="{{ __('Descrição do Produto') }}"
                    readonly
                    x-bind:value="productData.description"></textarea>
            </div>

            <div class="mt-6">
                <x-input-label for="category" value="{{ __('Categoria') }}" />
                <select
                    id="category_view"
                    name="category"
                    x-model="productData.category_id"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-off-white dark:text-gray-500 
                focus:border-green-700 dark:focus:border-green-700 
                focus:ring-2 focus:ring-green-700 dark:focus:ring-green-700 
                rounded-md shadow-sm"
                    disabled>
                    <option value="" disabled selected>Selecione uma categoria</option>
                    <template x-for="category in categories" :key="category.id">
                        <option :value="category.id" x-text="category.name"></option>
                    </template>
                </select>
            </div>

            <div class="mt-6">
                <x-input-label for="price" value="{{ __('Preço') }}" />
                <x-text-input
                    id="price"
                    name="price"
                    type="text"
                    class="mt-1 block w-1/2"
                    placeholder="{{ __('Preço') }}"
                    readonly
                    x-bind:value="productData.price" />
            </div>

            <div class="mt-6">
                <x-input-label for="image" value="{{ __('Imagem do Produto') }}" />
                <img :src="productData.image_url" alt="{{ __('Imagem do Produto') }}" class="mt-1 block w-60" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Fechar') }}
                </x-secondary-button>
            </div>
        </div>
    </x-modal>

    <x-modal name="delete-product" focusable>
        <form method="post" x-bind:action="`{{ route('products.destroy', '') }}/${productData.id}`" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Deletar Produto') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Tem certeza que deseja deletar este produto? Essa ação não pode ser desfeita.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" autofocus>
                    {{ __('Deletar Produto') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>



    <script>

        function handlePageChange(page, lastPage) {
            // Verifica se a página solicitada é válida
            if (page < 1 || page > lastPage) {
                return;
            }

            // Cria uma URL com base na página solicitada
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);

            // Redireciona para a nova URL com a página atualizada
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const priceInput = document.querySelector('input[name="price"]');
            const priceTable = document.querySelector('.price')
            if (priceInput) {
                applyCurrencyMask(priceInput);
            }
            if (priceTable) {
                applyCurrencyMask(priceTable);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Função para buscar categorias e preencher o select
            async function fetchCategories() {
                const selectCreate = document.getElementById('category_create');
                const selectUpdate = document.getElementById('category_update');
                const selectFilter = document.getElementById('category_filter');
                const selectView = document.getElementById('category_view');
                const url = 'categorias/select';

                try {
                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Network response was not ok');

                    const categories = await response.json();

                    // Preencher o select com as opções
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        selectCreate.appendChild(option);
                    });
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        selectUpdate.appendChild(option);
                    });
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        selectFilter.appendChild(option);
                    });
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        selectView.appendChild(option);
                    });
                } catch (error) {
                    console.error('There was a problem with the fetch operation:', error);
                }
            }

            // Chama a função para buscar categorias ao carregar a página
            fetchCategories();
        });
    </script>
</x-app-layout>