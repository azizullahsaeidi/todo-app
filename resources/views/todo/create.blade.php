<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-base font-semibold leading-6 text-gray-900">Add todo</h1>
                            </div>
                            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                <a href="{{ route('todos.index') }}"
                                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Todo List
                                </a>
                            </div>
                        </div>
                        <div class="-mx-4 mt-8 sm:-mx-0">

                            <form action="{{ route('todos.store') }}" method="post" id="todo-form">

                                @csrf
                                <div class="space-y-12 sm:space-y-16">
                                    <div>
                                        <div
                                            class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                                            
                                            {{-- Todo Type --}}
                                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                                                <label for="todo-type"
                                                    class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Type</label>
                                                <div class="mt-2 sm:col-span-2 sm:mt-0">
                                                    <select id="todo-type" name="todo_type_id" autocomplete="todo-type-name"
                                                        class="block w-full max-w-2xl rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                        @foreach ($todoTypes as $todoType)
                                                        <option value="{{ $todoType->id }}">{{ $todoType->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Title --}}
                                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                                                <label for="title"
                                                    class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Title</label>
                                                <div class="mt-2 sm:col-span-2 sm:mt-0">
                                                    <input type="text" name="title" placeholder="Title" id="title" autocomplete="title" class="block w-full max-w-2xl rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                </div>
                                            </div>

                                            {{-- Date --}}
                                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                                                <label for="date"
                                                    class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Date</label>
                                                <div class="mt-2 sm:col-span-2 sm:mt-0">
                                                    <input type="date" name="date" placeholder="Date" id="date" value="{{ date('Y-m-d') }}" autocomplete="date" class="block w-full max-w-2xl rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                </div>
                                            </div>

                                            {{-- Description --}}
                                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                                                <label for="description"
                                                    class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Description</label>
                                                <div class="mt-2 sm:col-span-2 sm:mt-0">
                                                    <textarea id="description" placeholder="Write a few sentences about your doto." name="description" rows="3"
                                                        class="block w-full max-w-2xl rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex items-center justify-end gap-x-6">
                                    <button type="button"
                                        class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\TodoRequest', '#todo-form'); !!}
</x-app-layout>
