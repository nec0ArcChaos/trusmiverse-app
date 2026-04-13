<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Event Activation Calendar View</title>
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
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-auto-rows: minmax(120px, 1fr);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #2d3748; border-radius: 10px; }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="flex flex-col h-screen overflow-hidden">
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
                    <h1 class="text-3xl font-black tracking-tight">Event Activation</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Orchestrate and track event lifecycles across
                        stages</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex bg-slate-100 dark:bg-slate-800 p-1 rounded-lg">
                        <button
                            class="flex items-center justify-center h-8 px-4 rounded-md text-sm font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 transition-colors">Board</button>
                        <button
                            class="flex items-center justify-center h-8 px-4 rounded-md text-sm font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 transition-colors">List</button>
                        <button
                            class="flex items-center justify-center h-8 px-4 rounded-md text-sm font-bold bg-white dark:bg-slate-700 text-primary dark:text-white shadow-sm">Calendar</button>
                    </div>
                    <div class="h-8 w-px bg-slate-200 dark:bg-slate-800"></div>
                    <div class="flex items-center gap-2">
                        <button
                            class="size-10 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                        </button>
                        <span class="text-sm font-bold min-w-[120px] text-center">October 2023</span>
                        <button
                            class="size-10 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex border-b border-slate-200 dark:border-slate-800 gap-8">
                <a href="https://trusmiverse.com/apps/mockup/event_activation_board_view"
                    class="border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 text-sm font-bold hover:text-slate-700 dark:hover:text-slate-200 transition-colors">Board
                    View</a>
                <a href="https://trusmiverse.com/apps/mockup/event_activation_list_view"
                    class="border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 text-sm font-bold hover:text-slate-700 dark:hover:text-slate-200 transition-colors">List
                    View</a>
                <a href="https://trusmiverse.com/apps/mockup/event_activation_calendar_view"
                    class="border-b-2 border-primary text-primary pb-3 text-sm font-bold">Calendar</a>
            </div>
        </div>
        <main class="flex-1 overflow-y-auto p-6 pt-2 custom-scrollbar">
            <div
                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden">
                <div
                    class="grid grid-cols-7 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <div class="py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Sun</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Mon</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Tue</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Wed</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Thu</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Fri</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Sat</div>
                </div>
                <div class="calendar-grid bg-slate-100 dark:bg-slate-800/30 gap-px">
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">1</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">2</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">3</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">4</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">5</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">6</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">7</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">8</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">9</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">10</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">11</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-sm font-medium text-slate-400">12</span>
                        </div>
                        <div
                            class="bg-status-waiting/10 border-l-4 border-status-waiting p-2 rounded-r mb-1 cursor-pointer hover:bg-status-waiting/20 transition-colors">
                            <p class="text-[10px] font-bold text-status-waiting truncate uppercase">Summer Music Fest
                            </p>
                            <div class="flex items-center gap-1 mt-1">
                                <img class="size-3 rounded-full"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjAATSAfl5wB7utbJc5Ehsu62d0QHqj28D5lGtr7f5Ovk2nGT-NWHpRvx5muhcxNcX9RXZ9R1mNOzZfdfuMtcOVzr7oo1IL6quffcE4DF0FbwC4_oyduqwteMAFuWsPcVxL2cCj-FJQaD5orADk_HjkRKpbWyo5uOh1MxvEL6B5xL7tQG5zEpMabKwce7EHoMVv3wgtdYFPw-taK94CdMRCBwQ3afIIcg8ZwutPE19JfCFaqPhgx7kbR8F0UUVeZRIO6gpzsytZvuB" />
                                <span class="text-[8px] text-slate-500">NY</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">13</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">14</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">15</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">16</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">17</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">18</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">19</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">20</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">21</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">22</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">23</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">24</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-sm font-bold text-primary">25</span>
                            <span class="size-1.5 rounded-full bg-primary"></span>
                        </div>
                        <div
                            class="bg-status-waiting/10 border-l-4 border-status-waiting p-2 rounded-r mb-1 cursor-pointer hover:bg-status-waiting/20 transition-colors">
                            <p class="text-[10px] font-bold text-status-waiting truncate uppercase">Urban Art Exhibit
                            </p>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">26</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">27</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">28</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">29</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">30</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-400">31</span>
                    </div>
                    <div class="bg-slate-50/50 dark:bg-slate-800/20 p-2 min-h-[140px]">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-sm font-medium text-slate-300 dark:text-slate-600">Nov 1</span>
                        </div>
                    </div>
                    <div class="bg-slate-50/50 dark:bg-slate-800/20 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-300 dark:text-slate-600">2</span>
                    </div>
                    <div class="bg-slate-50/50 dark:bg-slate-800/20 p-2 min-h-[140px]">
                        <span class="text-sm font-medium text-slate-300 dark:text-slate-600">3</span>
                    </div>
                    <div class="bg-slate-50/50 dark:bg-slate-800/20 p-2 min-h-[140px]">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-sm font-medium text-slate-300 dark:text-slate-600">4</span>
                        </div>
                        <div
                            class="bg-status-review/10 border-l-4 border-status-review p-2 rounded-r mb-1 cursor-pointer hover:bg-status-review/20 transition-colors">
                            <p class="text-[10px] font-bold text-status-review truncate uppercase">Tech Conf 2024</p>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="fixed bottom-10 right-10 w-80 bg-white dark:bg-slate-800 shadow-2xl rounded-xl border border-slate-200 dark:border-slate-700 p-4 z-50">
                <div class="flex justify-between items-start mb-4">
                    <span
                        class="text-[10px] px-2 py-1 rounded bg-status-review/10 text-status-review font-bold uppercase tracking-tight">Active
                        Review</span>
                    <button class="text-slate-400 hover:text-slate-600"><span
                            class="material-symbols-outlined text-[18px]">close</span></button>
                </div>
                <h4 class="text-base font-bold mb-3">Tech Conference 2024</h4>
                <div class="space-y-3 mb-4">
                    <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400 text-xs">
                        <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                        <span>November 04 - 06, 2023</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400 text-xs">
                        <span class="material-symbols-outlined text-[18px]">location_on</span>
                        <span>San Francisco, CA</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400 text-xs">
                        <span class="material-symbols-outlined text-[18px]">payments</span>
                        <span class="font-medium text-slate-700 dark:text-slate-300">$45,000 Budget</span>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <img class="size-6 rounded-full border border-white dark:border-slate-800"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBlD9S9LDQllEoee2uxgpLVCdu6raTMFeOy5rgsyQ4j2SnqTJiEWBcl_wuN_pDwxRDPxPjqL7AeffhKz_MIrWhpi6TsxSx8BKXtCpoOtQdyMk54PuSfXZYOD8H5tJs_gvJzlOc8KlDN2_plDD3Ie4lM1mPldYWnCW33IwUMfsdPviyaC7VWTsTlrk_k8T4QQ0yJBxf9K1xj9sH7I9jfAGfy1aBwhyTFfHKFzA4GoMU1BWzMWNGkBQ8ToBgpa3wFmd5kaXJGYYD4hy5q" />
                        <span class="text-[10px] text-slate-500 font-medium">Jordan K.</span>
                    </div>
                    <button class="text-xs font-bold text-primary hover:underline">View Details</button>
                </div>
            </div>
        </main>
        <footer
            class="px-6 py-4 bg-white dark:bg-[#111921] border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="size-3 rounded-full bg-status-waiting"></span>
                    <span class="text-xs font-medium text-slate-500">Waiting</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="size-3 rounded-full bg-status-review"></span>
                    <span class="text-xs font-medium text-slate-500">On Review</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="size-3 rounded-full bg-status-approved"></span>
                    <span class="text-xs font-medium text-slate-500">Approved</span>
                </div>
            </div>
            <div class="text-xs text-slate-400">
                Total Events this month: <span class="font-bold text-slate-600 dark:text-slate-200">7</span>
            </div>
        </footer>
    </div>

</body>

</html>