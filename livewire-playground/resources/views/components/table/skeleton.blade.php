@props(['rows' => 5, 'cols' => 4])

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                @for($i = 0; $i < $cols; $i++)
                    <th class="px-6 py-3 text-left">
                        <div class="h-3 bg-gray-200 rounded animate-pulse w-16"></div>
                    </th>
                @endfor
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @for($i = 0; $i < $rows; $i++)
                <tr>
                    <td class="px-6 py-4">
                        <div class="h-4 bg-gray-200 rounded animate-pulse w-8"></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="h-4 bg-gray-200 rounded animate-pulse w-32"></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="h-4 bg-gray-200 rounded animate-pulse w-48"></div>
                    </td>
                    <td class="px-6 py-4 flex justify-end gap-2">
                        <div class="h-5 w-5 bg-gray-200 rounded animate-pulse"></div>
                        <div class="h-5 w-5 bg-gray-200 rounded animate-pulse"></div>
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>
