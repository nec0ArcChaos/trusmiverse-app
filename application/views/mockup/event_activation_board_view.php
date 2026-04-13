<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Event Activation Kanban Board</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
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
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .kanban-column {
            min-width: 350px;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #2d3748;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="flex flex-col h-screen">
        <!-- Top Navigation Bar -->
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
                    data-alt="User profile picture of a male manager"
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuABBqc4faP5OJ9xA-mMIlq3pqppO0h_agU9EcOP1lx4kvocRVdQ-0Du8yrGRIE7t0JJwlkz7Q0-MZfrnrk76kV_SxuQsMMRpgET_38FdoddXuvq7w8LHWRW1Oe1hEykuv1on2x8L6re5qehfGu3ymYnVMY984N-lygpJTygDTxSBxjE0se9AQBTtuovLS6d36ZOmJjkdv1UAVGtoaR-iu33Epob8kuI5S4cQvxbMwQwJPvMw8UPeSR1LS6w3Ueto6ev51tmKAiOcCN5");'>
                </div>
            </div>
        </header>
        <!-- Board Header / Sub-Nav -->
        <div class="px-6 pt-8 pb-4 shrink-0">
            <div class="flex flex-wrap justify-between items-end gap-4">
                <div class="flex flex-col gap-1">
                    <h1 class="text-3xl font-black tracking-tight">Event Activation</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Orchestrate and track event lifecycles across
                        stages</p>
                </div>
                <div class="flex gap-2">
                    <button
                        class="flex items-center gap-2 rounded-lg h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-semibold">
                        <span class="material-symbols-outlined text-[18px]">filter_list</span>
                        Filter
                    </button>
                    <button
                        class="flex items-center gap-2 rounded-lg h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-semibold">
                        <span class="material-symbols-outlined text-[18px]">file_download</span>
                        Export
                    </button>
                </div>
            </div>
            <div class="mt-6 flex border-b border-slate-200 dark:border-slate-800 gap-8">
                <a href="https://trusmiverse.com/apps/mockup/event_activation_board_view"
                    class="border-b-2 border-primary text-primary pb-3 text-sm font-bold">Board View</a>
                <a href="https://trusmiverse.com/apps/mockup/event_activation_list_view"
                    class="border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 text-sm font-bold hover:text-slate-700 dark:hover:text-slate-200 transition-colors">List
                    View</a>
                <a href="https://trusmiverse.com/apps/mockup/event_activation_calendar_view"
                    class="border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 text-sm font-bold hover:text-slate-700 dark:hover:text-slate-200 transition-colors">Calendar</a>
            </div>
        </div>
        <!-- Kanban Board Content -->
        <main class="flex-1 overflow-x-auto p-6 pt-2">
            <div class="flex h-full gap-6 min-w-max">
                <!-- Column: Waiting -->
                <div class="kanban-column flex flex-col w-[400px]">
                    <div class="flex items-center justify-between mb-4 px-2">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-status-waiting"></span>
                            <h3 class="font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-xs">
                                Waiting</h3>
                            <span
                                class="bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-2 py-0.5 rounded text-[10px] font-bold">4</span>
                        </div>
                        <button class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                            <span class="material-symbols-outlined text-[20px]">more_horiz</span>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-4 pr-1">
                        <!-- Card 1 -->
                        <div onclick="document.getElementById('modal-detail').classList.remove('hidden')"
                            class="bg-white dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow group">
                            <div class="flex justify-between items-start mb-3">
                                <span
                                    class="text-[10px] px-2 py-1 rounded bg-status-waiting/10 text-status-waiting font-bold uppercase tracking-tight">Medium
                                    Priority</span>
                                <span
                                    class="material-symbols-outlined text-slate-300 group-hover:text-slate-500 cursor-grab">drag_indicator</span>
                            </div>
                            <h4 class="text-base font-bold mb-3">Summer Music Fest</h4>
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                    <span>Oct 12, 2023</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">location_on</span>
                                    <span>New York, NY</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">payments</span>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">$15,000 Budget</span>
                                </div>
                            </div>
                            <div
                                class="flex justify-between items-center pt-3 border-t border-slate-100 dark:border-slate-700/50">
                                <div class="flex -space-x-2">
                                    <img class="size-6 rounded-full border-2 border-white dark:border-slate-800"
                                        data-alt="Team member portrait"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjAATSAfl5wB7utbJc5Ehsu62d0QHqj28D5lGtr7f5Ovk2nGT-NWHpRvx5muhcxNcX9RXZ9R1mNOzZfdfuMtcOVzr7oo1IL6quffcE4DF0FbwC4_oyduqwteMAFuWsPcVxL2cCj-FJQaD5orADk_HjkRKpbWyo5uOh1MxvEL6B5xL7tQG5zEpMabKwce7EHoMVv3wgtdYFPw-taK94CdMRCBwQ3afIIcg8ZwutPE19JfCFaqPhgx7kbR8F0UUVeZRIO6gpzsytZvuB" />
                                    <img class="size-6 rounded-full border-2 border-white dark:border-slate-800"
                                        data-alt="Team member portrait"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuB3pxRyHhcHR9cLvd2X_ZWi7tlG1URMsKbda_YoIkZ_oL96bnp-R3sV4vbOYU8owi6o_QXi0Slppas6Fm1hz0Kn6kSTVzHUJv7Oux6RR_ZVb-1H10FACboZXZLvfgsqixi7saNuCUrxp61IFa3idaDu2acD2zU9_1GptjuOsz7rQXmuRhjURk9MPcgweC9S5kVimQ1pUi6cOOyy4wDHYcZcd63LoJofVgpOLCDTzbL5DNyE5ZA1PqLJshyb_gYZJzoP8O9IOugsukCf" />
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[11px] font-medium text-slate-400">PIC: Alex P.</span>
                                    <div
                                        class="size-6 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[10px] font-bold">
                                        AP</div>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div
                            class="bg-white dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow group">
                            <div class="flex justify-between items-start mb-3">
                                <span
                                    class="text-[10px] px-2 py-1 rounded bg-red-500/10 text-red-500 font-bold uppercase tracking-tight">High
                                    Priority</span>
                                <span
                                    class="material-symbols-outlined text-slate-300 group-hover:text-slate-500 cursor-grab">drag_indicator</span>
                            </div>
                            <h4 class="text-base font-bold mb-3">Urban Art Exhibit</h4>
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                    <span>Oct 25, 2023</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">location_on</span>
                                    <span>Brooklyn, NY</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">payments</span>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">$8,200 Budget</span>
                                </div>
                            </div>
                            <div
                                class="flex justify-between items-center pt-3 border-t border-slate-100 dark:border-slate-700/50">
                                <div class="flex -space-x-2">
                                    <img class="size-6 rounded-full border-2 border-white dark:border-slate-800"
                                        data-alt="Team member portrait"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6qOL8tqNBTZB3wcS94ZecM5lOxaL6ZwWkAip4IRdfU3ujqOBrsvFrJjMLclAUIawWTRoaYnkaTzjZnYSWeV4dZjcOLkA8gxlajpSQRbU0FKHzH-WUPoPb5mm6ocr4dt9lrg5Ow02kbxsLTr2HaQ54jXl3bWvA6weI5SqeSaUty-Ura89qcDGbsrEiafKMHwgfMSLMp7vD42PKg1_3QeqeXoGh0HlzqrLDYuSqRqmynov-N8-dSu91MUsajYOvTCnjFi0b4G9mGPoL" />
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[11px] font-medium text-slate-400">PIC: Maria G.</span>
                                    <div
                                        class="size-6 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[10px] font-bold">
                                        MG</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column: On Review -->
                <div class="kanban-column flex flex-col w-[400px]">
                    <div class="flex items-center justify-between mb-4 px-2">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-status-review"></span>
                            <h3 class="font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-xs">On
                                Review</h3>
                            <span
                                class="bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-2 py-0.5 rounded text-[10px] font-bold">2</span>
                        </div>
                        <button class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                            <span class="material-symbols-outlined text-[20px]">more_horiz</span>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-4 pr-1">
                        <!-- Card 3 -->
                        <div
                            class="bg-white dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow group border-l-4 border-l-status-review">
                            <div class="flex justify-between items-start mb-3">
                                <span
                                    class="text-[10px] px-2 py-1 rounded bg-status-review/10 text-status-review font-bold uppercase tracking-tight">Active
                                    Review</span>
                                <span
                                    class="material-symbols-outlined text-slate-300 group-hover:text-slate-500 cursor-grab">drag_indicator</span>
                            </div>
                            <h4 class="text-base font-bold mb-3">Tech Conference 2024</h4>
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                    <span>Nov 05, 2023</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">location_on</span>
                                    <span>San Francisco, CA</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">payments</span>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">$45,000 Budget</span>
                                </div>
                            </div>
                            <div
                                class="flex justify-between items-center pt-3 border-t border-slate-100 dark:border-slate-700/50">
                                <div class="flex items-center gap-2">
                                    <div class="size-6 rounded-full bg-primary/20 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[14px] text-primary">chat</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-500">12 Comments</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[11px] font-medium text-slate-400">PIC: Jordan K.</span>
                                    <div
                                        class="size-6 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[10px] font-bold">
                                        JK</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column: Approved -->
                <div class="kanban-column flex flex-col w-[400px]">
                    <div class="flex items-center justify-between mb-4 px-2">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-status-approved"></span>
                            <h3 class="font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-xs">
                                Approved</h3>
                            <span
                                class="bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-2 py-0.5 rounded text-[10px] font-bold">1</span>
                        </div>
                        <button class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                            <span class="material-symbols-outlined text-[20px]">more_horiz</span>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-4 pr-1">
                        <!-- Card 4 -->
                        <div
                            class="bg-white dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow group">
                            <div class="flex justify-between items-start mb-3">
                                <div
                                    class="flex items-center gap-1 bg-status-approved/10 text-status-approved px-2 py-1 rounded">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                    <span class="text-[10px] font-bold uppercase tracking-tight">Finalized</span>
                                </div>
                                <span
                                    class="material-symbols-outlined text-slate-300 group-hover:text-slate-500 cursor-grab">drag_indicator</span>
                            </div>
                            <h4 class="text-base font-bold mb-3">Product Launch 2.0</h4>
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                    <span>Dec 01, 2023</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">location_on</span>
                                    <span>Austin, TX</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">payments</span>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">$20,000 Budget</span>
                                </div>
                            </div>
                            <div
                                class="flex justify-between items-center pt-3 border-t border-slate-100 dark:border-slate-700/50">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-slate-400">LOGISTICS READY</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[11px] font-medium text-slate-400">PIC: Sarah W.</span>
                                    <img class="size-6 rounded-full" data-alt="Female team member portrait"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBlD9S9LDQllEoee2uxgpLVCdu6raTMFeOy5rgsyQ4j2SnqTJiEWBcl_wuN_pDwxRDPxPjqL7AeffhKz_MIrWhpi6TsxSx8BKXtCpoOtQdyMk54PuSfXZYOD8H5tJs_gvJzlOc8KlDN2_plDD3Ie4lM1mPldYWnCW33IwUMfsdPviyaC7VWTsTlrk_k8T4QQ0yJBxf9K1xj9sH7I9jfAGfy1aBwhyTFfHKFzA4GoMU1BWzMWNGkBQ8ToBgpa3wFmd5kaXJGYYD4hy5q" />
                                </div>
                            </div>
                        </div>
                        <!-- Add new card placeholder -->
                        <button
                            class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-6 flex flex-col items-center justify-center gap-2 text-slate-400 hover:text-primary hover:border-primary/50 transition-all bg-transparent hover:bg-primary/5">
                            <span class="material-symbols-outlined text-[32px]">add</span>
                            <span class="text-xs font-bold uppercase tracking-widest">Move approved to archive</span>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Detail -->
    <div id="modal-detail"
        class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4 backdrop-blur-sm">
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-12 bg-black/40 backdrop-blur-[2px]">
            <div
                class="bg-white dark:bg-slate-900 w-full max-w-6xl max-h-full rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 flex flex-col relative animate-in fade-in zoom-in duration-300">
                <!-- edit button -->
                <button
                    class="absolute top-6 right-6 z-10 p-2 text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors"
                    onclick="document.getElementById('modal-detail').classList.add('hidden')">
                    <span class="material-symbols-outlined text-2xl leading-none">close</span>
                </button>
                <div class="flex-1 overflow-y-auto">
                    <div class="px-8 pt-8 pb-6 border-b border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-3 mb-1 pr-12">
                            <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Summer Tech
                                Launch
                                2024</h1>
                            <span
                                class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                            </span>
                            <button
                                class="top-6 right-6 z-10 p-2 text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors me-2"
                                onclick="document.getElementById('modal-edit').classList.remove('hidden')">
                                <span class="material-symbols-outlined text-2xl leading-none">edit</span>
                            </button>
                        </div>
                        <p class="text-slate-500 text-sm font-medium">Campaign ID: <span
                                class="text-slate-700 dark:text-slate-300">ST-2024-089-B</span> • Lead: <span
                                class="text-primary font-semibold">Sarah Jenkins</span></p>
                    </div>
                    <div
                        class="px-8 bg-slate-50/50 dark:bg-slate-800/30 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-20 backdrop-blur-md">
                        <div class="flex gap-8 overflow-x-auto">
                            <button id="tab-btn-overview" onclick="switchTab('overview')"
                                class="tab-btn py-4 border-b-2 border-primary text-primary text-sm font-bold flex items-center gap-2 transition-all whitespace-nowrap">
                                <span class="material-symbols-outlined text-[20px]">insights</span> Overview
                            </button>
                            <button id="tab-btn-event" onclick="switchTab('event')"
                                class="tab-btn py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 text-sm font-bold flex items-center gap-2 transition-all whitespace-nowrap">
                                <span class="material-symbols-outlined text-[20px]">event_available</span> Event
                                Activation
                            </button>
                            <button id="tab-btn-creator" onclick="switchTab('creator')"
                                class="tab-btn py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 text-sm font-bold flex items-center gap-2 transition-all whitespace-nowrap">
                                <span class="material-symbols-outlined text-[20px]">person_add</span> Content Creator
                            </button>
                            <button id="tab-btn-dist" onclick="switchTab('distribution')"
                                class="tab-btn py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 text-sm font-bold flex items-center gap-2 transition-all whitespace-nowrap">
                                <span class="material-symbols-outlined text-[20px]">send</span> Distribution
                            </button>
                            <button id="tab-btn-opt" onclick="switchTab('opt')"
                                class="tab-btn py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 text-sm font-bold flex items-center gap-2 transition-all whitespace-nowrap">
                                <span class="material-symbols-outlined text-[20px]">auto_videocam</span> Opt. Content
                            </button>
                        </div>
                    </div>
                    <div class="p-8">
                        <!-- Overview Content -->
                        <div id="tab-content-overview"
                            class="tab-content space-y-8 animate-in fade-in slide-in-from-bottom-2 duration-300">
                            <section>
                                <h3
                                    class="text-xs font-black uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 mb-6 flex items-center gap-2">
                                    <span class="w-8 h-px bg-slate-200 dark:bg-slate-800"></span> Campaign Basics
                                </h3>
                                <div
                                    class="grid grid-cols-1 md:grid-cols-4 gap-6 bg-slate-50 dark:bg-slate-800/40 p-6 rounded-xl border border-slate-200 dark:border-slate-800">
                                    <div class="space-y-1">
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Brand
                                        </p>
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="size-6 bg-blue-500 rounded flex items-center justify-center text-[10px] font-bold text-white">
                                                GT</div>
                                            <p class="text-sm font-bold text-slate-900 dark:text-white">Global Tech
                                                Solutions</p>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Period
                                        </p>
                                        <p
                                            class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                            <span
                                                class="material-symbols-outlined text-lg text-slate-400">calendar_today</span>
                                            Oct 1 — Dec 31, 2024
                                        </p>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                            Objective
                                        </p>
                                        <p
                                            class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                            <span class="material-symbols-outlined text-lg text-slate-400">target</span>
                                            Brand Awareness
                                        </p>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total
                                            Budget</p>
                                        <p
                                            class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                            <span
                                                class="material-symbols-outlined text-lg text-slate-400">payments</span>
                                            $50,000.00
                                        </p>
                                    </div>
                                </div>
                            </section>
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                                <section class="lg:col-span-7">
                                    <h3
                                        class="text-xs font-black uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 mb-6 flex items-center gap-2">
                                        <span class="w-8 h-px bg-slate-200 dark:bg-slate-800"></span> SWOT Strategic
                                        Analysis
                                    </h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div
                                            class="p-5 rounded-xl border border-slate-200 dark:border-slate-800/50 bg-white dark:bg-slate-800/20 shadow-sm">
                                            <div class="flex items-center gap-2 mb-3 text-blue-600 dark:text-blue-400">
                                                <span
                                                    class="material-symbols-outlined font-bold text-xl">trending_up</span>
                                                <span
                                                    class="text-xs font-black uppercase tracking-wider">Strengths</span>
                                            </div>
                                            <ul class="space-y-2">
                                                <li
                                                    class="text-sm text-slate-700 dark:text-slate-300 flex items-start gap-2">
                                                    <span class="text-blue-500 font-bold leading-none">•</span> High
                                                    video
                                                    engagement (4.2%)
                                                </li>
                                                <li
                                                    class="text-sm text-slate-700 dark:text-slate-300 flex items-start gap-2">
                                                    <span class="text-blue-500 font-bold leading-none">•</span> Strong
                                                    brand
                                                    recall
                                                </li>
                                            </ul>
                                        </div>
                                        <div
                                            class="p-5 rounded-xl border border-slate-200 dark:border-slate-800/50 bg-white dark:bg-slate-800/20 shadow-sm">
                                            <div
                                                class="flex items-center gap-2 mb-3 text-amber-600 dark:text-amber-400">
                                                <span
                                                    class="material-symbols-outlined font-bold text-xl">priority_high</span>
                                                <span
                                                    class="text-xs font-black uppercase tracking-wider">Weaknesses</span>
                                            </div>
                                            <ul class="space-y-2">
                                                <li
                                                    class="text-sm text-slate-700 dark:text-slate-300 flex items-start gap-2">
                                                    <span class="text-amber-500 font-bold leading-none">•</span> Low CTR
                                                    on
                                                    static
                                                    ads
                                                </li>
                                                <li
                                                    class="text-sm text-slate-700 dark:text-slate-300 flex items-start gap-2">
                                                    <span class="text-amber-500 font-bold leading-none">•</span> High
                                                    CPC
                                                    keywords
                                                </li>
                                            </ul>
                                        </div>
                                        <div
                                            class="p-5 rounded-xl border border-slate-200 dark:border-slate-800/50 bg-white dark:bg-slate-800/20 shadow-sm">
                                            <div
                                                class="flex items-center gap-2 mb-3 text-emerald-600 dark:text-emerald-400">
                                                <span
                                                    class="material-symbols-outlined font-bold text-xl">add_circle</span>
                                                <span
                                                    class="text-xs font-black uppercase tracking-wider">Opportunities</span>
                                            </div>
                                            <ul class="space-y-2">
                                                <li
                                                    class="text-sm text-slate-700 dark:text-slate-300 flex items-start gap-2">
                                                    <span class="text-emerald-500 font-bold leading-none">•</span> Scale
                                                    LinkedIn
                                                    outreach
                                                </li>
                                                <li
                                                    class="text-sm text-slate-700 dark:text-slate-300 flex items-start gap-2">
                                                    <span class="text-emerald-500 font-bold leading-none">•</span>
                                                    Retargeting
                                                    funnel
                                                </li>
                                            </ul>
                                        </div>
                                        <div
                                            class="p-5 rounded-xl border border-slate-200 dark:border-slate-800/50 bg-white dark:bg-slate-800/20 shadow-sm">
                                            <div class="flex items-center gap-2 mb-3 text-rose-600 dark:text-rose-400">
                                                <span class="material-symbols-outlined font-bold text-xl">bolt</span>
                                                <span class="text-xs font-black uppercase tracking-wider">Threats</span>
                                            </div>
                                            <ul class="space-y-2">
                                                <li
                                                    class="text-sm text-slate-700 dark:text-slate-300 flex items-start gap-2">
                                                    <span class="text-rose-500 font-bold leading-none">•</span>
                                                    Competitor
                                                    bidding
                                                </li>
                                                <li
                                                    class="text-sm text-slate-700 dark:text-slate-300 flex items-start gap-2">
                                                    <span class="text-rose-500 font-bold leading-none">•</span> Holiday
                                                    ad
                                                    fatigue
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </section>
                                <section class="lg:col-span-5 flex flex-col">
                                    <h3
                                        class="text-xs font-black uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 mb-6 flex items-center gap-2">
                                        <span class="w-8 h-px bg-slate-200 dark:bg-slate-800"></span> AI Insights
                                    </h3>
                                    <div
                                        class="flex-1 bg-slate-900 text-white rounded-xl p-6 border border-slate-800 relative overflow-hidden flex flex-col items-center">
                                        <div class="absolute -top-10 -right-10 size-32 bg-primary/20 blur-[60px]"></div>
                                        <div class="relative size-32 flex items-center justify-center mb-6">
                                            <div
                                                class="radial-progress size-full rounded-full flex items-center justify-center shadow-lg">
                                                <div
                                                    class="bg-slate-900 size-[82%] rounded-full flex flex-col items-center justify-center">
                                                    <span class="text-4xl font-black text-white">85</span>
                                                    <span
                                                        class="text-[9px] text-slate-500 font-bold tracking-tighter uppercase">Health
                                                        Score</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-full bg-slate-800/50 rounded-lg p-5 border border-slate-700">
                                            <div class="flex items-center gap-2 mb-4 text-primary">
                                                <span class="material-symbols-outlined text-lg">auto_awesome</span>
                                                <span class="text-[10px] font-bold uppercase tracking-widest">Smart
                                                    Recommendations</span>
                                            </div>
                                            <ul class="space-y-3">
                                                <li class="flex gap-2">
                                                    <span
                                                        class="material-symbols-outlined text-primary text-base">check_circle</span>
                                                    <p class="text-xs text-slate-300 leading-relaxed">Reallocate <span
                                                            class="text-white font-bold">$4.5k</span> to LinkedIn.</p>
                                                </li>
                                                <li class="flex gap-2">
                                                    <span
                                                        class="material-symbols-outlined text-primary text-base">check_circle</span>
                                                    <p class="text-xs text-slate-300 leading-relaxed">Activate <span
                                                            class="text-white font-bold">Dynamic Creative</span> for
                                                        weekends.</p>
                                                </li>
                                                <li class="flex gap-2">
                                                    <span
                                                        class="material-symbols-outlined text-primary text-base">check_circle</span>
                                                    <p class="text-xs text-slate-300 leading-relaxed">Increase bid cap
                                                        for
                                                        "Innovation" segments by <span
                                                            class="text-white font-bold">12%</span>.</p>
                                                </li>
                                            </ul>
                                            <button
                                                class="w-full mt-6 py-2.5 bg-primary/20 hover:bg-primary/30 text-primary border border-primary/30 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">
                                                Apply All Optimizations
                                            </button>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>

                        <!-- Event Activation Content -->
                        <div id="tab-content-event"
                            class="tab-content hidden animate-in fade-in slide-in-from-bottom-2 duration-300">
                            <div class="flex flex-col items-center justify-center h-64 text-center">
                                <div
                                    class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                    <span
                                        class="material-symbols-outlined text-3xl text-slate-400">event_available</span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Event Activation</h3>
                                <p class="text-slate-500 dark:text-slate-400 max-w-sm mt-2">Manage offline events, booth
                                    setups, and on-ground activation details here.</p>
                                <button
                                    class="mt-4 px-4 py-2 bg-primary/10 text-primary rounded-lg text-sm font-bold hover:bg-primary/20 transition-colors">
                                    + Add Event
                                </button>
                            </div>
                        </div>

                        <!-- Content Creator Content -->
                        <div id="tab-content-creator"
                            class="tab-content hidden animate-in fade-in slide-in-from-bottom-2 duration-300">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                                <div class="lg:col-span-8 flex flex-col gap-6">
                                    <div
                                        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
                                        <div
                                            class="p-4 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/30">
                                            <h3 class="font-bold text-base">Operational Tasks</h3>
                                            <div class="flex items-center gap-2">
                                                <button
                                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-primary text-white rounded-lg text-xs font-bold hover:bg-primary/90 transition-colors">
                                                    <span class="material-symbols-outlined text-base">add</span>
                                                    Add Task
                                                </button>
                                            </div>
                                        </div>
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-left">
                                                <thead class="bg-slate-50 dark:bg-slate-800/50">
                                                    <tr>
                                                        <th
                                                            class="px-6 py-3 text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                                            Task Name</th>
                                                        <th
                                                            class="px-6 py-3 text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                                            Assigned</th>
                                                        <th
                                                            class="px-6 py-3 text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">
                                                            Status</th>
                                                        <th
                                                            class="px-6 py-3 text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30">
                                                        <td class="px-6 py-4">
                                                            <div class="font-semibold text-sm">Script Drafting -
                                                                Series B</div>
                                                            <div class="text-[10px] text-slate-500">Video
                                                                Content</div>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <div class="flex -space-x-2">
                                                                <img alt="Avatar"
                                                                    class="h-7 w-7 rounded-full border-2 border-white dark:border-slate-900"
                                                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBXbWmvXIq0zgos00HR_6QZpRZPiM9gtTXl-R5i2m_iQUzNOdaM2w8PBVI_ykmHIXrzEmXOYfEw9LonI_Z70sEm8zXcsw-QYLPSiuvrNi1g8jMeQw9eyxePPzG5t2JhvFVkrTC6ze8ZI2zbz3SKYJDgrfC_mPMC_GGQH8VZNoX22K4XYerEAH4t87cEVgJOx3Yljz-zln2K6x16Bi_TjSnEixoe5t4SmkAjJukex8PGlfvtLXFPmKIfHr853ulW2O0BxRVtXGewwmoD" />
                                                                <div
                                                                    class="h-7 w-7 rounded-full border-2 border-white dark:border-slate-900 bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[8px] font-bold">
                                                                    +2</div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <div class="flex justify-center">
                                                                <span
                                                                    class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-primary/10 text-primary border border-primary/20">In
                                                                    Progress</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 text-right">
                                                            <button
                                                                class="text-slate-400 hover:text-primary transition-colors"><span
                                                                    class="material-symbols-outlined text-lg"
                                                                    onclick="document.getElementById('modal-sub-detail').classList.remove('hidden')">edit_note</span></button>
                                                        </td>
                                                    </tr>
                                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30">
                                                        <td class="px-6 py-4">
                                                            <div class="font-semibold text-sm">Influencer
                                                                Outreach</div>
                                                            <div class="text-[10px] text-slate-500">Marketing
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <img alt="Avatar"
                                                                class="h-7 w-7 rounded-full border-2 border-white dark:border-slate-900"
                                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDuvXamLfCo4ghXYXQWobODaexecJn9rLtLSBtLH46x8taKCqsSh9hkHaIV_h2whzxB2NdMT8Kyo1p2pDBKY70MahrXQ6BYpL2W7fz6LWFcJZHEPrOTKZr6c5IEm0kw8oo09M3DdksqE22YWV67MqPlWOSdzGytDCccEYE8sfXTuOBw_YVNt2DOjKoooKOWYMycfo85t_BCNbXCTgRG9E2vVhKQRRLxmkn3nB4U2Pa-SVStLpeTaP1WO0wjb5iGYremGs_ar5tCMzNr" />
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <div class="flex justify-center">
                                                                <span
                                                                    class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800/50">Completed</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 text-right">
                                                            <button
                                                                class="text-slate-400 hover:text-primary transition-colors"><span
                                                                    class="material-symbols-outlined text-lg">edit_note</span></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div
                                        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl flex flex-col h-[400px] shadow-sm">
                                        <div
                                            class="p-4 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-primary">forum</span>
                                                <h3 class="font-bold text-base">Discussion</h3>
                                            </div>
                                            <span
                                                class="bg-slate-100 dark:bg-slate-800 text-[9px] px-2 py-0.5 rounded font-bold uppercase tracking-wider text-slate-500">4
                                                Participants</span>
                                        </div>
                                        <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-6">
                                            <div class="flex gap-3">
                                                <img alt="Avatar" class="h-8 w-8 rounded-full"
                                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBUW6hnNf3OSX_JQVBmRHzEKoWecHXDn-nDsdmxjENdcNscPTcvFw4SoZUCsJ_GsKOf3aO1onNgay4IPwbLgD6bMWZGIE-vnjwA5_P9T5Z5W6MuiXl9oQpVsjA1NByFgYEjuceIOMYJ0ZoeYp0nXEmmmi1eSsK7Uab6G4-TgSSlJAaEAhn_kJkk_SIpbcj60nJnE-bNPltPVLfz4oZDj_O2TyRh85QBveOpINIkDnOorJA_ZMzHLXL9CtmWVRxVG1NBhRW7W5_7w0ng" />
                                                <div class="flex flex-col gap-1 max-w-[80%]">
                                                    <div class="flex items-baseline gap-2">
                                                        <span class="font-bold text-xs">Sarah Jenkins</span>
                                                        <span class="text-[10px] text-slate-500">10:42 AM</span>
                                                    </div>
                                                    <div
                                                        class="bg-slate-100 dark:bg-slate-800 p-3 rounded-lg rounded-tl-none text-xs leading-relaxed">
                                                        Hey team, I've just uploaded the final script for the
                                                        Series B video.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex gap-3 flex-row-reverse">
                                                <img alt="Avatar" class="h-8 w-8 rounded-full"
                                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0QrFaDvNO5ek-f5zTSrRhw2kEpCPslAnlLL9tYVNrjkFih2IS8g7d2UTnj2jMeIMinilpvaFR7fpVu64VvcpcFjrvnefmRiwFFwmkeha-OjsLXwJWrkomAccDGakcGHIesdbZ9UJSfDRKjabp03xwHv4j7rXctc5KEA2PJfHJ11RZRRTNL09aUMqcBRk8mwoDu3tKewW5DKfQGBEtr2gxIpbrbHkK38P7TQVahkwItdmDVC87BAdJ6IhJCtVnbaHKnTwTX0H4RBae" />
                                                <div class="flex flex-col gap-1 items-end max-w-[80%] text-right">
                                                    <div class="flex items-baseline gap-2 flex-row-reverse">
                                                        <span class="font-bold text-xs">Mike Ross</span>
                                                        <span class="text-[10px] text-slate-500">10:55 AM</span>
                                                    </div>
                                                    <div
                                                        class="bg-primary text-white p-3 rounded-lg rounded-tr-none text-xs leading-relaxed">
                                                        Looks great, Sarah! I'll have the editors start on the
                                                        B-roll selection.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                                            <div class="relative">
                                                <input
                                                    class="w-full bg-slate-100 dark:bg-slate-800 border-none rounded-lg py-2.5 pl-4 pr-12 text-sm focus:ring-1 focus:ring-primary"
                                                    placeholder="Write a message..." type="text" />
                                                <button
                                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-primary p-1.5 hover:bg-primary/10 rounded-full transition-colors">
                                                    <span class="material-symbols-outlined text-xl">send</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:col-span-4 flex flex-col gap-6">
                                    <div
                                        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 shadow-sm">
                                        <div class="flex items-center justify-between mb-6">
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="material-symbols-outlined text-primary text-xl">history</span>
                                                <h3 class="font-bold text-base">Activity Log</h3>
                                            </div>
                                        </div>
                                        <div
                                            class="relative space-y-6 before:absolute before:inset-0 before:ml-[11px] before:h-full before:w-0.5 before:bg-slate-100 dark:before:bg-slate-800">
                                            <div class="relative pl-8">
                                                <span
                                                    class="absolute left-0 mt-1 flex h-6 w-6 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 ring-4 ring-white dark:ring-slate-900 z-10">
                                                    <span
                                                        class="material-symbols-outlined text-[10px] font-bold">check</span>
                                                </span>
                                                <div>
                                                    <p class="text-[11px] text-slate-900 dark:text-slate-100">
                                                        <span class="font-bold">Mike Ross</span> completed <span
                                                            class="font-medium">Outreach</span>.
                                                    </p>
                                                    <p class="text-[10px] text-slate-500 mt-1">2 hours ago</p>
                                                </div>
                                            </div>
                                            <div class="relative pl-8">
                                                <span
                                                    class="absolute left-0 mt-1 flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-primary ring-4 ring-white dark:ring-slate-900 z-10">
                                                    <span
                                                        class="material-symbols-outlined text-[10px] font-bold">upload_file</span>
                                                </span>
                                                <div>
                                                    <p class="text-[11px] text-slate-900 dark:text-slate-100">
                                                        <span class="font-bold">Sarah J.</span> uploaded a file.
                                                    </p>
                                                    <p class="text-[10px] text-slate-500 mt-1">3 hours ago</p>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="w-full mt-6 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-[10px] font-bold text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors uppercase tracking-widest">
                                            View Full Log
                                        </button>
                                    </div>
                                    <div
                                        class="bg-gradient-to-br from-primary to-blue-700 rounded-xl p-5 text-white shadow-lg">
                                        <h4 class="font-bold text-xs mb-4 uppercase tracking-wider opacity-90">
                                            Team Performance</h4>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div class="bg-white/10 rounded-lg p-3">
                                                <div class="text-xl font-black">84%</div>
                                                <div class="text-[9px] uppercase font-bold opacity-70">
                                                    Efficiency</div>
                                            </div>
                                            <div class="bg-white/10 rounded-lg p-3">
                                                <div class="text-xl font-black">12</div>
                                                <div class="text-[9px] uppercase font-bold opacity-70">Done
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 flex items-center gap-2">
                                            <div class="flex -space-x-1.5">
                                                <img alt="Avatar" class="h-5 w-5 rounded-full border border-white/20"
                                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuB2wbGk24utCbv6DxojQb16JRnFae1wfacZ8Qtqqu66ojxS15slxihkB9H93guAY20TTwUK3mp92sz5dLezNBW4uUIHD8jO8j3RD7jLGhXZrkREEOU4ZOOpUws3IMBxgE1SvyYesQm39YPz-TIMuAGontFqlBm3qxCWdUNS84NpV1_6kFqH_jpCr0X6Wf9aL6vYvUs49BIqFX1guswPBnaeKJ8-pvMFlYodQbJ6aJDBh9AuudWQ_n2kaPkbaB32V4jZjG5VvKAG34fW" />
                                                <img alt="Avatar" class="h-5 w-5 rounded-full border border-white/20"
                                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuACOL4ijQVr2j4r66PBIaGu1-K6T-KDOOG7L3P7eaw0vsMRteswV8TzO2KOHgOa7mdwzhiwEXc1qk9-VBfjOJkzD9Ylj-Cg8YqbekCQN7ejPxjYPzR_aL6qyVNVxObNP3S9b1Dy_pUkLQefAKE8HuH8mkzQSpZ-s681wxfGMfNtyRGlnQx9bK_32ronG4Q5X-LjAovlURJUX9ZAbqBapG3LGCUZ0hdKfYQZIrl88Qn-JTX7t83pJBisyKsK7OjoM-etvdIzd4j2-ue5" />
                                            </div>
                                            <span class="text-[9px] font-medium opacity-80 italic">Rising
                                                stars</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Distribution Content -->
                        <div id="tab-content-distribution"
                            class="tab-content hidden animate-in fade-in slide-in-from-bottom-2 duration-300">
                            <div class="flex flex-col items-center justify-center h-64 text-center">
                                <div
                                    class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-3xl text-slate-400">send</span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Distribution Channels</h3>
                                <p class="text-slate-500 dark:text-slate-400 max-w-sm mt-2">Monitor ad spend, channel
                                    performance, and cross-platform reach.</p>
                                <button
                                    class="mt-4 px-4 py-2 bg-primary/10 text-primary rounded-lg text-sm font-bold hover:bg-primary/20 transition-colors">
                                    View Analytics
                                </button>
                            </div>
                        </div>

                        <!-- Opt. Content -->
                        <div id="tab-content-opt"
                            class="tab-content hidden animate-in fade-in slide-in-from-bottom-2 duration-300">
                            <div class="flex flex-col items-center justify-center h-64 text-center">
                                <div
                                    class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-3xl text-slate-400">auto_videocam</span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Content Optimization</h3>
                                <p class="text-slate-500 dark:text-slate-400 max-w-sm mt-2">A/B testing results and
                                    AI-driven content recommendations.</p>
                                <button
                                    class="mt-4 px-4 py-2 bg-primary/10 text-primary rounded-lg text-sm font-bold hover:bg-primary/20 transition-colors">
                                    Run Optimization Analysis
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-slate-50 dark:bg-slate-900 px-8 py-5 border-t border-slate-200 dark:border-slate-800 flex justify-between items-center rounded-b-2xl">
                    <div class="flex gap-8">
                        <div class="flex items-center gap-2">
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Total
                                Reach</span>
                            <span class="text-slate-900 dark:text-white font-black">1.2M</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Conv.
                                Rate</span>
                            <span class="text-slate-900 dark:text-white font-black">3.8%</span>
                        </div>
                        <div class="flex items-center gap-2 border-l border-slate-200 dark:border-slate-800 pl-8">
                            <button class="flex items-center gap-2 text-primary font-bold text-xs hover:underline">
                                <span class="material-symbols-outlined text-sm">download</span> Download PDF Report
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <button
                            class="px-5 py-2 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 text-sm font-bold"
                            onclick="document.getElementById('modal-detail').classList.add('hidden')">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-sub-detail"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm hidden">
        <div
            class="bg-white dark:bg-slate-900 w-full max-w-4xl max-h-[90vh] rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] flex flex-col overflow-hidden border border-slate-200 dark:border-slate-700">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-start">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-3 text-wrap">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Script Drafting - Series B</h2>
                        <span
                            class="px-2 py-0.5 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 text-[10px] font-bold rounded uppercase tracking-wider flex items-center gap-1 shrink-0">
                            <span class="material-symbols-outlined text-[14px]">priority_high</span>
                            High Priority
                        </span>
                    </div>
                    <div class="flex items-center gap-4 text-xs text-slate-500">
                        <span class="flex items-center gap-1.5"><span
                                class="material-symbols-outlined text-sm">folder_open</span> Video Content</span>
                        <span class="flex items-center gap-1.5"><span
                                class="material-symbols-outlined text-sm">tag</span> TASK-1284</span>
                    </div>
                </div>
                <button class="p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-slate-500"
                        onclick="document.getElementById('modal-sub-detail').classList.add('hidden')">close</span>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto">
                <div class="grid grid-cols-1 lg:grid-cols-12 min-h-full">
                    <div class="lg:col-span-8 p-6 border-r border-slate-200 dark:border-slate-800 flex flex-col gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Assigned
                                    To</label>
                                <div class="flex items-center gap-2">
                                    <img alt="Avatar"
                                        class="h-8 w-8 rounded-full border border-slate-200 dark:border-slate-700"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBXbWmvXIq0zgos00HR_6QZpRZPiM9gtTXl-R5i2m_iQUzNOdaM2w8PBVI_ykmHIXrzEmXOYfEw9LonI_Z70sEm8zXcsw-QYLPSiuvrNi1g8jMeQw9eyxePPzG5t2JhvFVkrTC6ze8ZI2zbz3SKYJDgrfC_mPMC_GGQH8VZNoX22K4XYerEAH4t87cEVgJOx3Yljz-zln2K6x16Bi_TjSnEixoe5t4SmkAjJukex8PGlfvtLXFPmKIfHr853ulW2O0BxRVtXGewwmoD" />
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold">Sarah Jenkins</span>
                                        <span class="text-[10px] text-slate-500">Lead Content Creator</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Due
                                    Date</label>
                                <div
                                    class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300">
                                    <span class="material-symbols-outlined text-primary text-lg">calendar_today</span>
                                    Oct 24, 2024
                                </div>
                            </div>
                            <div class="sm:col-span-2 flex flex-col gap-2">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Task
                                    Description</label>
                                <p class="text-xs leading-relaxed text-slate-600 dark:text-slate-400">
                                    Draft the full technical script for the Series B feature reveal. Focus on the
                                    integration capabilities and the new security dashboard. Must align with the brand
                                    voice guidelines established in the Q3 handbook.
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex flex-col gap-6 bg-slate-50/80 dark:bg-slate-800/40 p-5 rounded-xl border border-slate-100 dark:border-slate-800">
                            <div
                                class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-3">
                                <h4 class="text-xs font-bold flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-sm">edit_note</span>
                                    Post Progress Update
                                </h4>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="flex flex-col gap-2">
                                    <label
                                        class="text-[10px] font-bold text-slate-500 uppercase tracking-wide">Status</label>
                                    <select
                                        class="bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary py-2 px-3">
                                        <option>To Do</option>
                                        <option selected="">In Progress</option>
                                        <option>Review</option>
                                        <option>Completed</option>
                                    </select>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <div class="flex justify-between items-center">
                                        <label
                                            class="text-[10px] font-bold text-slate-500 uppercase tracking-wide">Completion</label>
                                        <span class="text-xs font-bold text-primary">65%</span>
                                    </div>
                                    <input
                                        class="w-full h-1.5 bg-slate-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-primary"
                                        max="100" min="0" type="range" value="65" />
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide">Progress
                                    Update Note</label>
                                <textarea
                                    class="bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg text-xs p-3 focus:ring-primary focus:border-primary min-h-[80px]"
                                    placeholder="Describe current activities, achievements, or any roadblocks encountered..."></textarea>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide">File
                                    Attachments</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-2">
                                    <div
                                        class="flex items-center justify-between p-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg group">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            <span
                                                class="material-symbols-outlined text-red-500 text-lg flex-shrink-0">picture_as_pdf</span>
                                            <span
                                                class="text-[11px] truncate font-medium">brand_guidelines_v2.pdf</span>
                                        </div>
                                        <button class="text-slate-400 hover:text-red-500 flex-shrink-0">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </div>
                                    <div
                                        class="flex items-center justify-between p-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg group">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            <span
                                                class="material-symbols-outlined text-blue-500 text-lg flex-shrink-0">image</span>
                                            <span class="text-[11px] truncate font-medium">dashboard_preview.jpg</span>
                                        </div>
                                        <button class="text-slate-400 hover:text-red-500 flex-shrink-0">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </div>
                                </div>
                                <div
                                    class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 hover:border-primary/50 transition-colors flex flex-col items-center justify-center gap-2 cursor-pointer bg-white/30 dark:bg-slate-900/30">
                                    <span class="material-symbols-outlined text-slate-400">cloud_upload</span>
                                    <span class="text-[10px] font-bold text-slate-500">Drop files here or click to
                                        upload</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-4 p-6 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col gap-6">
                        <h3
                            class="text-[10px] font-black uppercase tracking-widest text-slate-400 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">history</span>
                            Activity Log
                        </h3>
                        <div
                            class="relative space-y-6 before:absolute before:inset-0 before:ml-[7px] before:h-full before:w-0.5 before:bg-slate-200 dark:before:bg-slate-800">
                            <div class="relative pl-6">
                                <span
                                    class="absolute left-0 mt-1 h-3.5 w-3.5 rounded-full bg-primary ring-4 ring-white dark:ring-slate-900 z-10"></span>
                                <div>
                                    <p class="text-[11px] font-medium leading-tight">
                                        <span class="font-bold">Sarah J.</span> added a <span
                                            class="text-primary font-bold">Progress Note</span>
                                    </p>
                                    <p
                                        class="text-[10px] bg-white dark:bg-slate-800 p-2 mt-1.5 rounded border border-slate-100 dark:border-slate-700 italic text-slate-500">
                                        "Completed first 5 minutes of technical scripting. Awaiting feedback on security
                                        modules."
                                    </p>
                                    <p class="text-[9px] text-slate-500 mt-1">15 mins ago</p>
                                </div>
                            </div>
                            <div class="relative pl-6">
                                <span
                                    class="absolute left-0 mt-1 h-3.5 w-3.5 rounded-full bg-slate-300 dark:bg-slate-700 ring-4 ring-white dark:ring-slate-900 z-10"></span>
                                <div>
                                    <p class="text-[11px] font-medium leading-tight text-slate-500">
                                        <span class="font-bold text-slate-700 dark:text-slate-300">Sarah J.</span>
                                        uploaded 2 <span
                                            class="text-primary underline font-bold cursor-pointer">attachments</span>
                                    </p>
                                    <p class="text-[9px] text-slate-500 mt-1">1 hour ago</p>
                                </div>
                            </div>
                            <div class="relative pl-6">
                                <span
                                    class="absolute left-0 mt-1 h-3.5 w-3.5 rounded-full bg-slate-300 dark:bg-slate-700 ring-4 ring-white dark:ring-slate-900 z-10"></span>
                                <div>
                                    <p class="text-[11px] font-medium leading-tight text-slate-500">
                                        <span class="font-bold text-slate-700 dark:text-slate-300">Sarah J.</span>
                                        updated status to <span class="text-primary font-bold">In Progress</span>
                                    </p>
                                    <p class="text-[9px] text-slate-500 mt-1">2 hours ago</p>
                                </div>
                            </div>
                            <div class="relative pl-6">
                                <span
                                    class="absolute left-0 mt-1 h-3.5 w-3.5 rounded-full bg-slate-300 dark:bg-slate-700 ring-4 ring-white dark:ring-slate-900 z-10"></span>
                                <div>
                                    <p class="text-[11px] font-medium leading-tight text-slate-500"><span
                                            class="font-bold text-slate-700 dark:text-slate-300">System</span> created
                                        the task</p>
                                    <p class="text-[9px] text-slate-500 mt-1">Yesterday, 4:15 PM</p>
                                </div>
                            </div>
                        </div>
                        <button class="mt-auto text-[10px] font-bold text-primary hover:underline text-left">View all
                            history</button>
                    </div>
                </div>
            </div>
            <div
                class="p-4 border-t border-slate-200 dark:border-slate-800 flex justify-end gap-3 bg-white dark:bg-slate-900">
                <button
                    class="px-5 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors"
                    onclick="document.getElementById('modal-sub-detail').classList.add('hidden')">Cancel</button>
                <button
                    class="px-6 py-2 bg-primary text-white rounded-lg text-xs font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-colors">Update
                    Task</button>
            </div>
        </div>
    </div>
    <script>
        function switchTab(tabName) {
            // Hide all contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Show selected content
            document.getElementById('tab-content-' + tabName).classList.remove('hidden');

            // Reset all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-primary', 'text-primary');
                btn.classList.add('border-transparent', 'text-slate-500');
            });

            // Activate selected button
            const activeBtn = document.getElementById('tab-btn-' + tabName);
            activeBtn.classList.remove('border-transparent', 'text-slate-500');
            activeBtn.classList.add('border-primary', 'text-primary');
        }
    </script>
</body>

</html>