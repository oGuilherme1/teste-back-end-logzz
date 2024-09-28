<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div id="tableContent" class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Selecione uma tabela para exibir") }} <!-- Conteúdo inicial -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function renderTable(table) {
            if (table === 'products') {
                document.getElementById('tableContent').innerHTML = `<h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100">Tabela de Produtos</h3>`;
                // Aqui você pode fazer um fetch para carregar a tabela de produtos se necessário
            } else if (table === 'categories') {
                document.getElementById('tableContent').innerHTML = `<h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100">Tabela de Categorias</h3>`;
                // Aqui você pode fazer um fetch para carregar a tabela de categorias se necessário
            }
        }
    </script>
</x-app-layout>
