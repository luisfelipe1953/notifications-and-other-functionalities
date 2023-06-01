<div class="relative overflow-x-auto pb-10">
    <table class="w-full text-sm text-left shadow">
        <thead class="text-xs  uppercase bg-cyan-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    NAME
                </th>
                <th scope="col" class="px-6 py-3">
                    PATH
                </th>
                <th scope="col" class="px-6 py-3">
                    EXTENSION
                </th>
                <th scope="col" class="px-6 py-3">
                    ACTIONS
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $file->id }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $file->origin_name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $file->url }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $file->extension }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('downloadFile', $file) }}"
                            class="underline text-cyan-900 hover:text-blue-900 text-center mx-auto">Download</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
