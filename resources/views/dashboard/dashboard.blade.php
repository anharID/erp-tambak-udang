<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>You're logged in! Welcome {{ Auth::user()->name }}</h1>
                </div>
            </div>
        </div>
    </div>
</x-admin>