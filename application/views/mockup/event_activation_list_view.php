<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Event Activation List View</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1773cf",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111921",
                        "status-waiting": "#f59e0b",
                        "status-review": "#1773cf",
                        "status-approved": "#10b981",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #2d3748; border-radius: 10px; }
        tr:hover td {
            @apply bg-slate-50 dark:bg-slate-800/40;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="flex flex-col h-screen">
        <header
            class="flex items-center justify-between whitespace-nowrap border-b border-solid border-slate-200 dark:border-slate-800 bg-white dark:bg-[#111921] px-6 py-3 shrink-0">
            <div class="flex items-center gap-8">
                <div class="flex items-center gap-3">
                    <div class="size-8 bg-primary rounded-lg flex items-center justify-center text-white">
                        <span class="material-symbols-outlined">campaign</span>
                    </div>
                    <h2 class="text-lg font-bold leading-tight tracking-tight">Campaign Management</h2>
                </div>
                <div class="hidden md:flex items-center">
                    <label class="relative flex items-center min-w-[320px]">
                        <span class="material-symbols-outlined absolute left-3 text-slate-400">search</span>
                        <input
                            class="w-full h-10 pl-10 pr-4 rounded-lg border-none bg-slate-100 dark:bg-slate-800 text-sm focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-500"
                            placeholder="Search events, teams or budgets..." />
                    </label>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button
                    class="flex items-center justify-center rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-colors gap-2">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>Create Event</span>
                </button>
                <div class="h-6 w-[1px] bg-slate-200 dark:bg-slate-800 mx-2"></div>
                <button
                    class="size-10 flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button
                    class="size-10 flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700">
                    <span class="material-symbols-outlined">settings</span>
                </button>
                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-9 border-2 border-primary/20"
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuABBqc4faP5OJ9xA-mMIlq3pqppO0h_agU9EcOP1lx4kvocRVdQ-0Du8yrGRIE7t0JJwlkz7Q0-MZfrnrk76kV_SxuQsMMRpgET_38FdoddXuvq7w8LHWRW1Oe1hEykuv1on2x8L6re5qehfGu3ymYnVMY984N-lygpJTygDTxSBxjE0se9AQBTtuovLS6d36ZOmJjkdv1UAVGtoaR-iu33Epob8kuI5S4cQvxbMwQwJPvMw8UPeSR1LS6w3Ueto6ev51tmKAiOcCN5");'>
                </div>
            </div>
        </header>
        <div class="px-6 pt-8 pb-4 shrink-0">
            <div class="flex flex-wrap justify-between items-end gap-4">
                <div class="flex flex-col gap-1">
                    <h1 class="text-3xl font-black tracking-tight uppercase">Event Activation</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Detailed tracking and management
                        of all event assets</p>
                </div>
                <div class="flex gap-2">
                    <button
                        class="flex items-center gap-2 rounded-lg h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">filter_list</span>
                        Filter
                    </button>
                    <button
                        class="flex items-center gap-2 rounded-lg h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">file_download</span>
                        Export
                    </button>
                </div>
            </div>
            <div class="mt-6 flex border-b border-slate-200 dark:border-slate-800 gap-8">
                <a href="https://trusmiverse.com/apps/mockup/event_activation_board_view"
                    class="border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 text-sm font-bold hover:text-slate-700 dark:hover:text-slate-200 transition-colors">Board
                    View</a>
                <a href="https://trusmiverse.com/apps/mockup/event_activation_list_view"
                    class="border-b-2 border-primary text-primary pb-3 text-sm font-bold">List View</a>
                <a href="https://trusmiverse.com/apps/mockup/event_activation_calendar_view"
                    class="border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 text-sm font-bold hover:text-slate-700 dark:hover:text-slate-200 transition-colors">Calendar</a>
            </div>
        </div>
        <main class="flex-1 overflow-hidden p-6 pt-2">
            <div
                class="h-full bg-white dark:bg-slate-800/20 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden flex flex-col shadow-sm">
                <div class="flex-1 overflow-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead
                            class="sticky top-0 bg-slate-50 dark:bg-slate-900/50 backdrop-blur z-10 border-b border-slate-200 dark:border-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                    Event Name</th>
                                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                    Status</th>
                                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">Date
                                </th>
                                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                    Location</th>
                                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                    Budget</th>
                                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">PIC
                                </th>
                                <th
                                    class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-500 text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <tr class="transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 dark:text-slate-100">Summer Music
                                            Fest</span>
                                        <span class="text-[10px] font-bold text-status-waiting uppercase mt-0.5">Medium
                                            Priority</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-status-waiting/10 text-status-waiting text-[10px] font-bold uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-status-waiting"></span>
                                        Waiting
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">Oct 12, 2023</td>
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">New York, NY</td>
                                <td class="px-6 py-5 font-semibold text-sm">$15,000</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="flex -space-x-2">
                                            <img alt="Team"
                                                class="size-7 rounded-full border-2 border-white dark:border-slate-800"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjAATSAfl5wB7utbJc5Ehsu62d0QHqj28D5lGtr7f5Ovk2nGT-NWHpRvx5muhcxNcX9RXZ9R1mNOzZfdfuMtcOVzr7oo1IL6quffcE4DF0FbwC4_oyduqwteMAFuWsPcVxL2cCj-FJQaD5orADk_HjkRKpbWyo5uOh1MxvEL6B5xL7tQG5zEpMabKwce7EHoMVv3wgtdYFPw-taK94CdMRCBwQ3afIIcg8ZwutPE19JfCFaqPhgx7kbR8F0UUVeZRIO6gpzsytZvuB" />
                                            <img alt="Team"
                                                class="size-7 rounded-full border-2 border-white dark:border-slate-800"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuB3pxRyHhcHR9cLvd2X_ZWi7tlG1URMsKbda_YoIkZ_oL96bnp-R3sV4vbOYU8owi6o_QXi0Slppas6Fm1hz0Kn6kSTVzHUJv7Oux6RR_ZVb-1H10FACboZXZLvfgsqixi7saNuCUrxp61IFa3idaDu2acD2zU9_1GptjuOsz7rQXmuRhjURk9MPcgweC9S5kVimQ1pUi6cOOyy4wDHYcZcd63LoJofVgpOLCDTzbL5DNyE5ZA1PqLJshyb_gYZJzoP8O9IOugsukCf" />
                                        </div>
                                        <span class="text-xs font-medium text-slate-500">Alex P.</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="p-1 hover:text-primary transition-colors text-slate-400">
                                        <span class="material-symbols-outlined text-xl">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 dark:text-slate-100">Tech Conference
                                            2024</span>
                                        <span class="text-[10px] font-bold text-red-500 uppercase mt-0.5">High
                                            Priority</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-status-review/10 text-status-review text-[10px] font-bold uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-status-review"></span>
                                        On Review
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">Nov 05, 2023</td>
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">San Francisco, CA</td>
                                <td class="px-6 py-5 font-semibold text-sm">$45,000</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="size-7 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[10px] font-bold">
                                            JK</div>
                                        <span class="text-xs font-medium text-slate-500">Jordan K.</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="p-1 hover:text-primary transition-colors text-slate-400">
                                        <span class="material-symbols-outlined text-xl">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 dark:text-slate-100">Product Launch
                                            2.0</span>
                                        <span
                                            class="text-[10px] font-bold text-status-approved uppercase mt-0.5">Critical</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-status-approved/10 text-status-approved text-[10px] font-bold uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-status-approved"></span>
                                        Approved
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">Dec 01, 2023</td>
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">Austin, TX</td>
                                <td class="px-6 py-5 font-semibold text-sm">$20,000</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <img alt="Sarah W." class="size-7 rounded-full"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBlD9S9LDQllEoee2uxgpLVCdu6raTMFeOy5rgsyQ4j2SnqTJiEWBcl_wuN_pDwxRDPxPjqL7AeffhKz_MIrWhpi6TsxSx8BKXtCpoOtQdyMk54PuSfXZYOD8H5tJs_gvJzlOc8KlDN2_plDD3Ie4lM1mPldYWnCW33IwUMfsdPviyaC7VWTsTlrk_k8T4QQ0yJBxf9K1xj9sH7I9jfAGfy1aBwhyTFfHKFzA4GoMU1BWzMWNGkBQ8ToBgpa3wFmd5kaXJGYYD4hy5q" />
                                        <span class="text-xs font-medium text-slate-500">Sarah W.</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="p-1 hover:text-primary transition-colors text-slate-400">
                                        <span class="material-symbols-outlined text-xl">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 dark:text-slate-100">Urban Art
                                            Exhibit</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase mt-0.5">Low
                                            Priority</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-status-waiting/10 text-status-waiting text-[10px] font-bold uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-status-waiting"></span>
                                        Waiting
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">Oct 25, 2023</td>
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">Brooklyn, NY</td>
                                <td class="px-6 py-5 font-semibold text-sm">$8,200</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <img alt="Maria G." class="size-7 rounded-full"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6qOL8tqNBTZB3wcS94ZecM5lOxaL6ZwWkAip4IRdfU3ujqOBrsvFrJjMLclAUIawWTRoaYnkaTzjZnYSWeV4dZjcOLkA8gxlajpSQRbU0FKHzH-WUPoPb5mm6ocr4dt9lrg5Ow02kbxsLTr2HaQ54jXl3bWvA6weI5SqeSaUty-Ura89qcDGbsrEiafKMHwgfMSLMp7vD42PKg1_3QeqeXoGh0HlzqrLDYuSqRqmynov-N8-dSu91MUsajYOvTCnjFi0b4G9mGPoL" />
                                        <span class="text-xs font-medium text-slate-500">Maria G.</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="p-1 hover:text-primary transition-colors text-slate-400">
                                        <span class="material-symbols-outlined text-xl">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 dark:text-slate-100">Winter Gala
                                            Charity</span>
                                        <span class="text-[10px] font-bold text-status-review uppercase mt-0.5">Internal
                                            Review</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-status-review/10 text-status-review text-[10px] font-bold uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-status-review"></span>
                                        On Review
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">Jan 15, 2024</td>
                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">Chicago, IL</td>
                                <td class="px-6 py-5 font-semibold text-sm">$32,500</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="size-7 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[10px] font-bold">
                                            RB</div>
                                        <span class="text-xs font-medium text-slate-500">Robert B.</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="p-1 hover:text-primary transition-colors text-slate-400">
                                        <span class="material-symbols-outlined text-xl">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-medium">Showing 5 of 24 events</span>
                    <div class="flex gap-1">
                        <button
                            class="px-3 py-1 text-xs font-bold rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50">Previous</button>
                        <button class="px-3 py-1 text-xs font-bold rounded bg-primary text-white">1</button>
                        <button
                            class="px-3 py-1 text-xs font-bold rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50">2</button>
                        <button
                            class="px-3 py-1 text-xs font-bold rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

</html>