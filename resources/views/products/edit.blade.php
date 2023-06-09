<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('product.update',['product' => $product->id]) }}">
                    @csrf
                    @method('patch')
            
                    <div class="px-3 pt-4">
                        <x-input-label for="email" :value="__('Product Name')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="text" name="name" :value="$product->name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
            
                    <div class="mt-4 px-3">
                        <x-input-label for="price" :value="__('Price')" />
            
                        <x-text-input id="price" class="block mt-1 w-full" 
                                        type="number"
                                        name="price"
                                         :value="$product->price" />
            
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
            
                    <div class="py-4">
                        <x-primary-button class="ml-3 pt-2">
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
