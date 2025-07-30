<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-2xl p-8 space-y-10">

        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-blue-600">Hello, {{ auth()->user()->name }} 👋</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-semibold">
                    Logout
                </button>
            </form>
        </div>

        <!-- Task Creation -->
        <div>
            <h2 class="text-xl font-semibold text-gray-700 mb-4">📝 Create a New Task</h2>

            <form method="POST" action="{{ route('tasks.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-600">Title</label>
                    <input type="text" name="title" required
                        class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-600">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Status</label>
                    <select name="status"
                        class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="pending" selected>Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Priority</label>
                    <select name="priority"
                        class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-600">Deadline</label>
                    <input type="date" name="deadline" required
                        class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="col-span-2 text-right">
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-300">
                        Create Task
                    </button>
                </div>
            </form>
        </div>

        <!-- Task List -->
        <div>
            <h2 class="text-xl font-semibold text-gray-700 mb-4">📋 Your Tasks</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-sm">
                    <thead class="bg-gray-100 text-gray-600 text-sm uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Title</th>
                            <th class="px-4 py-3 text-left">Description</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Priority</th>
                            <th class="px-4 py-3">Deadline</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($tasks as $task)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $task->title }}</td>
                                <td class="px-4 py-3">{{ $task->description }}</td>
                                <td class="px-4 py-3 text-center capitalize">{{ $task->status }}</td>
                                <td class="px-4 py-3 text-center capitalize">{{ $task->priority }}</td>
                                <td class="px-4 py-3 text-center">{{ $task->deadline }}</td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="{{ route('tasks.edit', $task->id) }}"
                                       class="text-blue-600 hover:underline text-sm font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Delete this task?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-sm font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if($tasks->isEmpty())
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-400">No tasks available.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
