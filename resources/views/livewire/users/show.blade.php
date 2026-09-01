<div class="flex overflow-y-auto flex-col h-full rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
    <div class="p-3 bg-white dark:bg-zinc-800">
        <flux:heading size="xl">{{__("Users")}}</flux:heading>
        <flux:text>{{__("Show all users in the system")}}</flux:text>
    </div>

    <table class="min-w-full divide-y divide-zinc-200 text-left text-sm dark:divide-zinc-700">
        <thead class="bg-zinc-50 dark:bg-zinc-800">
            <tr>
                <th class="py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200">{{__("Name")}}</th>
                <th class="py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200">{{__("Email")}}</th>
                <th class="w-16 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200">{{__("Role")}}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
            @foreach ($this->users as $user)
                <tr class="*:p-3 hover:bg-zinc-50 dark:hover:bg-zinc-800/60">
                    <td class="">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center">
                                <flux:avatar :name="$user->name" color="auto" :color:seed="$user->id" size="sm"/>
                            </div>
                            <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-center text-zinc-600 dark:text-zinc-300">{{ $user->email }}</td>
                    <td class=" text-center">
                        <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-700 dark:bg-blue-950/60 dark:text-blue-300">
                            {{ $user->is_admin ? 'Admin' : 'User' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <flux:spacer />
    <div class="p-2 sticky bottom-0 bg-zinc-50 dark:bg-zinc-800 ">
        {{$this->users->onEachSide(1)->links()}}
    </div>
</div>
