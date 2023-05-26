<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-base font-semibold leading-6 text-gray-900">Todo List</h1>
                                <p class="mt-2 text-sm text-gray-700">A list of all the todos including their type,
                                    title, description and date.
                                </p>
                            </div>
                            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                <a href="{{ route('todos.create') }}"
                                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add
                                    todo
                                </a>
                            </div>
                        </div>
                        <div class="-mx-4 mt-8 sm:-mx-0">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                            Type
                                        </th>
                                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                            Title
                                        </th>
                                        <th scope="col"  class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">
                                            Description
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Date
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($todos as $todo)
                                        <tr>
                                            <td
                                                class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-0">
                                                {{ $todo->todoType->name }}
                                                <dl class="font-normal lg:hidden">
                                                    <dt class="sr-only">{{ $todo->todoType->name }}</dt>
                                                    <dd class="mt-1 truncate text-gray-700">{{ $todo->title }}</dd>
                                                    <dt class="sr-only sm:hidden">{{ $todo->description }}</dt>
                                                </dl>
                                            </td>
                                            <td class="hidden px-3 max-w-[8rem] py-4 text-sm text-gray-500 lg:table-cell">
                                                <a href="{{ route('todos.show', $todo->id)}}">
                                                    {{ $todo->title }}
                                                </a>
                                            </td>
                                            <td class="hidden px-3 max-w-[20rem] truncate sm:table-cell py-4 text-sm text-gray-500 ">
                                                {{ $todo->description }}
                                            </td>
                                            <td class="px-3 py-4 text-sm text-gray-500">{{ dateFormat($todo->date) }}</td>
                                            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                <form action="{{ route('todos.destroy',$todo->id) }}" method="post">
                                                    <a href="{{ route('todos.edit', $todo->id) }}"class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you ready to delete this todo?')" type="submit" class="text-red-600 ml-2 hover:text-red-900">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- More people... -->
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="py-4">
                            {{ $todos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
