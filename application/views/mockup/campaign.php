<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Campaign Kanban Board</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1773cf",
                        "background-light": "#f6f7f8",
                        "background-dark": "#0f172a",
                        "column-dark": "#1e293b",
                        "card-dark": "#334155",
                    },
                    fontFamily: {
                        "display": ["Inter"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }#archived-toggle:checked ~ .archived-expanded {
            display: none;
        }
        #archived-toggle:checked ~ .archived-collapsed {
            display: flex;
        }
        #archived-toggle:not(:checked) ~ .archived-expanded {
            display: flex;
        }
        #archived-toggle:not(:checked) ~ .archived-collapsed {
            display: none;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen">
    <header
        class="sticky top-0 z-50 w-full border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md px-6 py-3">
        <div class="max-w-[1800px] mx-auto flex items-center justify-between gap-4">
            <div class="flex items-center gap-8 shrink-0">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-3xl font-bold">view_kanban</span>
                    <h2 class="text-slate-900 dark:text-white text-xl font-bold leading-tight tracking-tight">
                        CampaignFlow</h2>
                </div>
                <div
                    class="hidden md:flex items-center gap-1 bg-slate-100 dark:bg-slate-800 rounded-lg px-3 py-1.5 border border-slate-200 dark:border-slate-700 w-80">
                    <span class="material-symbols-outlined text-slate-400 text-xl">search</span>
                    <input
                        class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-slate-500 text-slate-200"
                        placeholder="Search campaigns, tasks, or members..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button
                    class="hidden sm:flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">
                    <span class="material-symbols-outlined text-lg">filter_list</span>
                    Filters
                </button>
                <button onclick="document.getElementById('create-campaign-modal').classList.remove('hidden')"
                    class="flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg text-sm font-semibold transition-colors shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-lg">add</span>
                    <span>Create New Campaign</span>
                </button>
                <div class="h-8 w-[1px] bg-slate-200 dark:border-slate-800 mx-2"></div>
                <div class="flex items-center gap-3">
                    <button class="p-2 text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <div class="h-10 w-10 rounded-full bg-cover bg-center border-2 border-primary"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAQQTYCk4i-oc8MXPCDuU3VMUXWlCYDaxvt2wtQZRA3x62Hn2DOpTPjhM1J5uPG_XmHR3FReG6jDwfTqt-aVKS-z_INkdpGaHtM-OFFwe50I7xVkUIGb3fG1dtsHQETL2T7W6Wb-l-WlV_bFWuh2YylhG1JesRdvBYi6xSpfscmh2iL2IVyZpw_56535jELM-MQMW5nSWI_b1wTTXmzG5fnJW4vSwIy2imqbvReYqalH1cr9X55y4pRiVhcSVMI-SrqvMxxKoKTqwNR')">
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="p-6 max-w-[1800px] mx-auto h-[calc(100vh-73px)]">
        <div class="flex flex-col h-full">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Campaign Board</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage and track your active marketing
                        workflows</p>
                </div>
                <div class="flex gap-2">
                    <div class="flex -space-x-2 mr-4">
                        <div class="h-8 w-8 rounded-full border-2 border-background-dark bg-cover bg-center"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDfHcjP712hm9jdrmBmU7iC73a4YuvGSedbkEr5Wfyca2nJVPVPvr8OGc-EC0gCjz4qiSVhbkJk_OphfB044KJpQKZ2BywEGqorNxbWlPCf_3HLgtTtwkfhfvzoRhEVJEuVRzMxf6oY-pj_HdV6omvhZVSZZq0K785vj5zK1GKJ6JMT9LJh-A1p35xWrSN7JghBeXfZ9rOkTwuC0-I0YiN8YFfWLyHZRvdeDXNPsi2XCsGWRxiYH0xr8AnRLT81zmft9u1rYI5fCSiH')">
                        </div>
                        <div class="h-8 w-8 rounded-full border-2 border-background-dark bg-cover bg-center"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAiOPGFY-EmYPZDN-AOx_bFAA_2ndlKzJcHc6ePKMVjjGFH9O2PWqoHpRWe6G8bUuxQ4AbSNoEqN89UNlVDdFx75q-mSSzY0P8Vwf-ROOsWR_qXrsMOTnwh_sILxT-KhWVACtACV4ZRpBvoUfsAuNZYIy0VVdA6oWx_0St2XiOrFChfc9QgJ_s--14XR8wcQAlhyy7RESfvKt3pWRkYWrQsSR9oSeLJFGYZAyLSeEZFiLVBgU6gS-V3NDUlWmPV1nItu7KTggsymT5b')">
                        </div>
                        <div class="h-8 w-8 rounded-full border-2 border-background-dark bg-cover bg-center"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCm8WuAyjpxCE00Cf3rMW-J4vVaN1Zj-xnDmQCB43PU91S_kcrNAe0iyhElr22bnGaKW7ymOCh5Zi_lUp1Z4fF26R9jZg8hxjrYue-ke5kYJL6E6JOnlER06izyVawKdpIehgQZuhJ0NW50xQnJZhd5ejDodIQRHUDGYRU_9Qc15MwtQ6EJ56BTdKIA_Ac-RDTb8RGlXVSaddzrEZueN8RJjy0LgkhMo0aOz3n4Z1Styo7jR9PYCWQCasbuU-Vr1L-7Q6_VXdsXyJjv')">
                        </div>
                        <div
                            class="h-8 w-8 rounded-full border-2 border-background-dark bg-slate-700 flex items-center justify-center text-[10px] font-bold text-white">
                            +12</div>
                    </div>
                    <button
                        class="p-2 bg-slate-100 dark:bg-slate-800 rounded-lg text-slate-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">settings</span>
                    </button>
                    <button
                        class="p-2 bg-slate-100 dark:bg-slate-800 rounded-lg text-slate-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">more_horiz</span>
                    </button>
                </div>
            </div>
            <div class="flex gap-6 overflow-x-auto pb-6 h-full items-start">
                <div
                    class="flex flex-col min-w-[320px] w-80 shrink-0 bg-slate-100/50 dark:bg-column-dark/40 rounded-xl p-3 max-h-full">
                    <div class="flex items-center justify-between px-2 mb-4">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-slate-700 dark:text-slate-300 text-sm uppercase tracking-wider">
                                Draft</h3>
                            <span
                                class="px-2 py-0.5 bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-xs font-bold rounded-full">3</span>
                        </div>
                        <button class="text-slate-400 hover:text-white transition-colors"><span
                                class="material-symbols-outlined text-xl">add</span></button>
                    </div>
                    <div class="flex flex-col gap-4 overflow-y-auto pr-1">
                        <div onclick="document.getElementById('modal-detail').classList.remove('hidden')"
                            class="bg-white dark:bg-card-dark p-4 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 cursor-grab active:cursor-grabbing hover:border-primary/50 transition-all group">
                            <div class="w-full h-32 rounded-md mb-3 bg-cover bg-center overflow-hidden"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBLqiCgfujEdX7FOZ35mRWz8VujnngpiGJ_WptkZEKH83Jdvc80j3S13TuU2Vhm2EUTSY_b2hrrHSeDCH7y_ir2ebaMnGDEYGlAL-ncIOhZzwhYsb0b4lWTIcMjeh6LwkXaUqBZd2INLCtDDumsiSZASCBnMkT3uOtILd5kIwe_o5qWMkAaC5rFxDLA1Ufb-OREnySZY50tA8o75ilrqeTu-xlLYA5iffVdVDw1HtDfXNgKqX3KqTDJlgFvztV14_10GiGEpQNpTjgh')">
                            </div>
                            <div class="flex justify-between items-start mb-2">
                                <span
                                    class="px-2 py-1 bg-amber-500/10 text-amber-500 text-[10px] font-bold uppercase rounded leading-none">High
                                    Priority</span>
                                <button
                                    class="opacity-0 group-hover:opacity-100 text-slate-400 transition-opacity"><span
                                        class="material-symbols-outlined text-lg">edit</span></button>
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white mb-1">Summer Sale 2024</h4>
                            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-4">Initial asset
                                creation and budget approval for Q3 discount blitz.</p>
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-1.5">
                                    <div class="h-6 w-6 rounded-full border-2 border-card-dark bg-cover bg-center"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDsnTf8UrBJiRF17PLolBzR43gIhevUVP5TiHKABBUuw9_nSa3NBaiiFah-9UlEyC_yrzOCk9PstSLfq5rk6AEIjlcyU67rNaNT9I8Q8ktPPja5GAJPddz0P2Ep1szexJ0kWqUCq0WNTowNaZblmL3TlKOHpkfdys2wxTvjAbtOUqDHZ3PqZjlj675as9LHEYqGB9uMqVmkXkyVV96FvMaFZxv2YFhdJEtmo4YiljWyNo1TYxXM60mgvwrGyfaw8gLZhDEws18nOXQ-')">
                                    </div>
                                    <div class="h-6 w-6 rounded-full border-2 border-card-dark bg-cover bg-center"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAXxf6ou0ywrd3GiG-_lXHqtGVWWTh0uZr70i_ieD5qHskfyWJoZhAa3apid5j6t5R1MBAsUrrU13GEAxNFk5YUaksAxECVrf1DcLAs_HSKofDesknFUS7qw4oBUk894SoKad1IHWNkNKQUP716uLEBBqaKDmMXznv1j1izbFtLg3LnN3Dq-GC5agGIkmJ05K9Ip5igSLbhPTN9IFTT3eJltZFq6BHWqO0DywpIP0EaiMLo1FzUX13mf941Wbmi2lto4EIEOcFzIOVd')">
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                                    <span class="flex items-center gap-1 text-[10px] font-medium"><span
                                            class="material-symbols-outlined text-sm">chat_bubble</span> 12</span>
                                    <span class="flex items-center gap-1 text-[10px] font-medium"><span
                                            class="material-symbols-outlined text-sm">attach_file</span> 4</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col min-w-[320px] w-80 shrink-0 bg-slate-100/50 dark:bg-column-dark/40 rounded-xl p-3 max-h-full">
                    <div class="flex items-center justify-between px-2 mb-4">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-slate-700 dark:text-slate-300 text-sm uppercase tracking-wider">
                                Pre-Production</h3>
                            <span
                                class="px-2 py-0.5 bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-xs font-bold rounded-full">2</span>
                        </div>
                        <button class="text-slate-400 hover:text-white transition-colors"><span
                                class="material-symbols-outlined text-xl">add</span></button>
                    </div>
                    <div class="flex flex-col gap-4 overflow-y-auto pr-1">
                        <div
                            class="bg-white dark:bg-card-dark p-4 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 cursor-grab hover:border-primary/50 transition-all group">
                            <div class="w-full h-32 rounded-md mb-3 bg-cover bg-center overflow-hidden"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAoReUuhyU19ZvkNF_Yu2B0GtohzMdS-d8Ym2jTOD8HE0mgWeRlDeHAJJwTeOn9oYWCZQMA1Rmq6RZoj0k6inkxdeW8xANMDhELPdhZ8T9OLCmGpFgQx3pqyjGsPytazLWGCl5dX6d85CjJnSPLynpayIQa16tOcC8YqbvbdgzCpNH9Vs_drUQi4lN0aJHWMpaByJJPhDLOPffPIGEBjvfD5T9ooI603kRiWzE4glfv4Q9qIK5Hm55fzBgRJNcbIdNlXGqyYoW6ik8Z')">
                            </div>
                            <div class="flex justify-between items-start mb-2">
                                <span
                                    class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold uppercase rounded leading-none">In
                                    Review</span>
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white mb-1">Product Launch v2</h4>
                            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-4">Finalizing
                                landing page copy and video trailers for the smartphone refresh.</p>
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-1.5">
                                    <div class="h-6 w-6 rounded-full border-2 border-card-dark bg-cover bg-center"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDIH0BfNovuXp3tns0ChYyT3fio3LI3OkpZ0-4pzHdvtp6ux6ocISo1lTttlP1hw4WHS2JU_XlQxtVm-IADZYBVe_HjzmYmf8RXZ3BYJLnHW0tJel06CVtnMdeGLHLdvV5IUiNsRlEfN7ffDl8MIZ-K_FICtc5WRft_y7u9eP0uLrNUBPwbosum3rSpx3nOkpouDCL7b-7aVPpZngpIMX8NSRxwGKum1GZVqpfkwfhC3V3id4fduJI4bEVts-yRz2upTVBi3Ej6Yzvx')">
                                    </div>
                                    <div class="h-6 w-6 rounded-full border-2 border-card-dark bg-cover bg-center"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAHhROHE_qC2WdfQyOnitJ6GDC3cZS36xeia06QlYemarcZVnvia2JHMEFZE72tmU--Mpxg94DsLHNEHUgDy_9G6Kilz2-5LXyfvbSpAB57sGVkZ6T8TpdmUFWHjz1GgJoUmhSKVu9m4C9EsdAn0_8xBNeKVHWG-blAXXPoAJDLkgRW8ROy6BxbaHA18Kl5B-1gYOx1Yb1xxim97CM8KeSuG4ZmfbK_ywX7r1huApvrtfMXIPIe9QZYHuBXDyheHqMuCXYFaYVwfPm7')">
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                                    <span class="flex items-center gap-1 text-[10px] font-medium"><span
                                            class="material-symbols-outlined text-sm">task_alt</span> 8/12</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col min-w-[320px] w-80 shrink-0 bg-slate-100/50 dark:bg-column-dark/40 rounded-xl p-3 max-h-full">
                    <div class="flex items-center justify-between px-2 mb-4">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-slate-700 dark:text-slate-300 text-sm uppercase tracking-wider">
                                Activation</h3>
                            <span
                                class="px-2 py-0.5 bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-xs font-bold rounded-full">4</span>
                        </div>
                        <button class="text-slate-400 hover:text-white transition-colors"><span
                                class="material-symbols-outlined text-xl">add</span></button>
                    </div>
                    <div class="flex flex-col gap-4 overflow-y-auto pr-1">
                        <div
                            class="bg-white dark:bg-card-dark p-4 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 cursor-grab hover:border-primary/50 transition-all group ring-2 ring-primary ring-offset-2 ring-offset-background-dark">
                            <div class="w-full h-32 rounded-md mb-3 bg-cover bg-center overflow-hidden"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCYx-5HwWH_s7oUus5etzHylJlO63mleGr3CNOXGi6UZ3O3wrCCDt2wmkrPsKzUtc8tEgQ3pZx2yT3r8nmjY7fXK3d12MpGCZWudj1VfuhYn3T3H-J7IYIm-WttECHet7LOV_2Ll0h_liGs_wt2GQUjykdtLxtldL_yyLAC0gsKrTH_7akekNSBmifnH7VRWB-oMVFqqebbM9-Y0I24q3_H2_0ZduD721Jz24jpC1Lok5Lw1XFVmuwg6vZT0zGbQH2qdVaqs3hbEGca')">
                            </div>
                            <div class="flex justify-between items-start mb-2">
                                <span
                                    class="px-2 py-1 bg-green-500/10 text-green-500 text-[10px] font-bold uppercase rounded leading-none">Live
                                    Now</span>
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white mb-1">Influencer Outreach</h4>
                            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-4">Coordinating with
                                15 lifestyle influencers for the "Back to School" push.</p>
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-1.5">
                                    <div class="h-6 w-6 rounded-full border-2 border-card-dark bg-cover bg-center"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuA-_5kwFWCkklaYkfYteY4LyXtTGeNluUMldjqj-X_uvhy6QDUTrDOG-LlE-OXneEN-HHqELIxa046NPmFbGdD91Gk6WT8OmqgnZB59W3-_dRJ7G5qhecYOYLH7A3en1ri6f1xEq3Oq_alsDXqpT7FSTtpsg4pphNDobsIh9BsAenakHEOT5DP0pj6sYi6dZKbred3GTf8k0hIb-GYzzpXT7sPQ7Sirm1Eyig4iG-4b63WQn0q0kiRFm5b8uZluAJQ9RQlkmsJfNpSC')">
                                    </div>
                                    <div class="h-6 w-6 rounded-full border-2 border-card-dark bg-cover bg-center"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCcNBJia3pTUFCrse5ddhbx8KOixkLnil0mad-FedcAmS0FEOuVBubfZFEIb3hxWWgNhb42HBI3QYu9b9pI7JuHGjXeB1nYOWaIrBh4mXW2YR8BycK9PMGf_M-b33mEmuWj4XFNTor4eltwGAB7Xc8996-6YArGdI04p_NrAf2-nkDDya3tzblkZ1gkc5TMSogDty4jVIXQ35Xi7WTkeiytE638waTExemsGdQdby3uGbFCOzuhK8WtP9OYgjy-ADI85KSjRv1c0Hka')">
                                    </div>
                                    <div
                                        class="h-6 w-6 rounded-full border-2 border-card-dark bg-slate-700 flex items-center justify-center text-[8px] font-bold text-white">
                                        +3</div>
                                </div>
                                <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                                    <span class="flex items-center gap-1 text-[10px] font-medium text-primary"><span
                                            class="material-symbols-outlined text-sm">trending_up</span> Active</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col min-w-[320px] w-80 shrink-0 bg-slate-100/50 dark:bg-column-dark/40 rounded-xl p-3 max-h-full">
                    <div class="flex items-center justify-between px-2 mb-4">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-slate-700 dark:text-slate-300 text-sm uppercase tracking-wider">
                                Post-Production</h3>
                            <span
                                class="px-2 py-0.5 bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-xs font-bold rounded-full">1</span>
                        </div>
                        <button class="text-slate-400 hover:text-white transition-colors"><span
                                class="material-symbols-outlined text-xl">add</span></button>
                    </div>
                    <div class="flex flex-col gap-4 overflow-y-auto pr-1">
                        <div
                            class="bg-white dark:bg-card-dark p-4 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 cursor-grab hover:border-primary/50 transition-all group">
                            <div class="w-full h-32 rounded-md mb-3 bg-cover bg-center overflow-hidden"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCzkzBcc9BBVg9TbIgS--vEUa_YYXBNgdGDNLjVJLbub_fNdaVjH12mA6WRp2YUzIk250-3xbtE7XiTuvjnxVdBnhpCAgrA2v8qHm8QyJfuwahJh9WVCYDNdg0nGWIJ-NTBcPo8CoHzuDm5W0z_F6waxvonNILP08sa_Zyr_YwGF4PYsZDclUXFdWjqUTjJt1GYLMWydE4Vh3YSps7ZPyG8fLuOjkI1NrHYnQxaYH9yf_CK2Fh-aHA6JbL3XoFzP8np9AKhH2GyNefQ')">
                            </div>
                            <div class="flex justify-between items-start mb-2">
                                <span
                                    class="px-2 py-1 bg-slate-500/10 text-slate-400 text-[10px] font-bold uppercase rounded leading-none">Archiving</span>
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white mb-1">Winter Clearance</h4>
                            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-4">Generating final
                                ROI reports and asset archiving from the January sale.</p>
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-1.5">
                                    <div class="h-6 w-6 rounded-full border-2 border-card-dark bg-cover bg-center"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBFWHpniaI24J1C-46yMdunfPR69hbb1T_iJghhUIS2tAy8-_QQwjUBudpn41Y-8IN5-kGnEeSPSl0zv24A9zjRZ1RGQVYDWYKQ-xBVfd2kvQLd6Qv3cJMHQT9o9yMbfHuo8Qp7w-hGHsxkAzxdn7qTxQVv1LYv5vap3-S_Viivqyqyy6SUTW0eZAROVnwDvsCAG-XOK_4ni_7tM9MnVLYW7aOR6ss0mQavku1uyTp5Zi1guHe_G0F8z3Bp50_tmXq-HQFA72p1HhbX')">
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                                    <span class="flex items-center gap-1 text-[10px] font-medium"><span
                                            class="material-symbols-outlined text-sm">history</span> Ended</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative shrink-0 flex">
                    <input class="hidden" id="archived-toggle" type="checkbox" />
                    <div
                        class="archived-expanded flex-col min-w-[320px] w-80 bg-slate-200/40 dark:bg-slate-900/30 rounded-xl p-3 max-h-full border border-dashed border-slate-300 dark:border-slate-800 transition-all duration-300">
                        <div class="flex items-center justify-between px-2 mb-4">
                            <div class="flex items-center gap-2">
                                <h3
                                    class="font-bold text-slate-500 dark:text-slate-500 text-sm uppercase tracking-wider">
                                    Archived</h3>
                                <span
                                    class="px-2 py-0.5 bg-slate-300 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-bold rounded-full">2</span>
                            </div>
                            <label
                                class="cursor-pointer text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                                for="archived-toggle">
                                <span class="material-symbols-outlined text-xl">keyboard_double_arrow_right</span>
                            </label>
                        </div>
                        <div class="flex flex-col gap-4 overflow-y-auto pr-1 opacity-75 grayscale-[0.5]">
                            <div
                                class="bg-white/60 dark:bg-card-dark/60 p-4 rounded-lg shadow-sm border border-slate-200/50 dark:border-slate-700/50 cursor-not-allowed">
                                <div class="flex justify-between items-start mb-2">
                                    <span
                                        class="px-2 py-1 bg-slate-500/10 text-slate-500 text-[10px] font-bold uppercase rounded leading-none">Rejected</span>
                                </div>
                                <h4 class="font-bold text-slate-700 dark:text-slate-300 mb-1">Q1 Brand Refresh</h4>
                                <p class="text-slate-400 dark:text-slate-500 text-xs leading-relaxed">Proposal cancelled
                                    due to budget realignment for the fiscal year.</p>
                            </div>
                            <div
                                class="bg-white/60 dark:bg-card-dark/60 p-4 rounded-lg shadow-sm border border-slate-200/50 dark:border-slate-700/50 cursor-not-allowed">
                                <div class="flex justify-between items-start mb-2">
                                    <span
                                        class="px-2 py-1 bg-red-500/10 text-red-400 text-[10px] font-bold uppercase rounded leading-none">Cancelled</span>
                                </div>
                                <h4 class="font-bold text-slate-700 dark:text-slate-300 mb-1">Pop-up Event NY</h4>
                                <p class="text-slate-400 dark:text-slate-500 text-xs leading-relaxed">Event cancelled
                                    following logistics challenges and venue availability.</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="archived-collapsed flex-col w-12 bg-slate-200/20 dark:bg-slate-900/20 rounded-xl p-3 h-full border border-dashed border-slate-300/50 dark:border-slate-800/50 transition-all duration-300 group hover:bg-slate-200/40 dark:hover:bg-slate-900/40">
                        <div class="flex flex-col items-center gap-8">
                            <label
                                class="cursor-pointer text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                                for="archived-toggle">
                                <span class="material-symbols-outlined text-xl">keyboard_double_arrow_left</span>
                            </label>
                            <div class="flex items-center gap-2 [writing-mode:vertical-lr] rotate-180">
                                <h3
                                    class="font-bold text-slate-400 dark:text-slate-600 text-sm uppercase tracking-wider">
                                    Archived</h3>
                                <span
                                    class="w-6 h-6 flex items-center justify-center bg-slate-300 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold rounded-full rotate-180">2</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div
        class="fixed bottom-6 right-6 flex items-center gap-3 bg-slate-900 border border-slate-800 text-white px-4 py-3 rounded-xl shadow-2xl">
        <div class="h-2 w-2 rounded-full bg-primary animate-pulse"></div>
        <p class="text-sm font-medium">Card "Summer Sale" moved to Pre-Production</p>
        <button class="ml-2 text-slate-500 hover:text-white"><span
                class="material-symbols-outlined text-lg">close</span></button>
    </div>

    <!-- Create Campaign Modal -->
    <div id="create-campaign-modal" class="hidden fixed inset-0 z-[100]" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"
            onclick="document.getElementById('create-campaign-modal').classList.add('hidden')"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0 overflow-y-auto">
            <div
                class="relative transform rounded-2xl bg-white dark:bg-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-slate-200 dark:border-slate-700 flex flex-col max-h-[90vh]">
                <!-- Header -->
                <div
                    class="bg-white dark:bg-slate-800 px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center sticky top-0 z-10 shrink-0 rounded-t-2xl">
                    <h3 class="text-lg font-bold leading-6 text-slate-900 dark:text-white" id="modal-title">Create New
                        Campaign</h3>
                    <button type="button" class="text-slate-400 hover:text-slate-500 focus:outline-none"
                        onclick="document.getElementById('create-campaign-modal').classList.add('hidden')">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Form Content -->
                <div class="bg-white dark:bg-slate-800 px-6 py-6 overflow-y-auto custom-scrollbar grow">
                    <form class="space-y-8">
                        <!-- Section 1: Basic Info -->
                        <div>
                            <div class="flex items-center gap-2 mb-4 text-primary">
                                <span class="material-symbols-outlined">info</span>
                                <h4 class="text-sm font-bold uppercase tracking-wider">Basic Info</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Tema -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tema
                                        Campaign</label>
                                    <input type="text" placeholder="e.g. Summer Vibes 2024"
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm placeholder:text-slate-400">
                                </div>
                                <!-- Brand -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Brand</label>
                                    <input type="text" placeholder="Brand Name"
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm placeholder:text-slate-400">
                                </div>
                                <!-- Periode -->
                                <div class="md:col-span-2">
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Periode
                                        Campaign</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="relative">
                                            <span
                                                class="absolute left-3 top-2.5 text-slate-400 material-symbols-outlined text-[18px]">calendar_today</span>
                                            <input type="date"
                                                class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm pl-10">
                                        </div>
                                        <div class="relative">
                                            <span
                                                class="absolute left-3 top-2.5 text-slate-400 material-symbols-outlined text-[18px]">event</span>
                                            <input type="date"
                                                class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm pl-10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Strategy -->
                        <div class="pt-6 border-t border-slate-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-2 mb-4 text-primary">
                                <span class="material-symbols-outlined">lightbulb</span>
                                <h4 class="text-sm font-bold uppercase tracking-wider">Strategy & Content</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Pilar Konten -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pilar
                                        Konten</label>
                                    <input type="text"
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm">
                                </div>
                                <!-- Angle -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Angle</label>
                                    <input type="text"
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm">
                                </div>
                                <!-- Tujuan Utama -->
                                <div class="md:col-span-2">
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tujuan
                                        Utama Konten</label>
                                    <textarea rows="2"
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm"></textarea>
                                </div>
                                <!-- Target Audiens -->
                                <div class="md:col-span-2">
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target
                                        Audiens</label>
                                    <input type="text"
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm">
                                </div>
                                <!-- Problem & Key Message -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Problem</label>
                                    <textarea rows="3"
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Key
                                        Message</label>
                                    <textarea rows="3"
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm"></textarea>
                                </div>
                                <!-- Reason to Believe & CTA -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Reason
                                        to Believe</label>
                                    <textarea rows="3"
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm"></textarea>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">CTA</label>
                                    <textarea rows="3"
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Content Production -->
                        <div class="pt-6 border-t border-slate-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-2 mb-4 text-primary">
                                <span class="material-symbols-outlined">movie</span>
                                <h4 class="text-sm font-bold uppercase tracking-wider">Production Output</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Konten yang dihasilkan -->
                                <div class="md:col-span-2">
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Konten
                                        yang dihasilkan</label>
                                    <input type="text"
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm">
                                </div>
                                <!-- Format -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Format</label>
                                    <select
                                        class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm">
                                        <option>Video (Reels/TikTok/Shorts)</option>
                                        <option>Static Post (Feed)</option>
                                        <option>Carousel/Slider</option>
                                        <option>Story/Status</option>
                                        <option>Article/Blog</option>
                                    </select>
                                </div>
                                <!-- Blank for Grid alignment -->
                                <div class="hidden md:block"></div>

                                <!-- Internal Content -->
                                <div
                                    class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-dashed border-slate-200 dark:border-slate-700">
                                    <h5 class="text-xs font-bold text-slate-500 uppercase mb-3 text-center">Internal
                                        Sources</h5>
                                    <div class="space-y-4">
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Jumlah
                                                Konten</label>
                                            <input type="number"
                                                class="w-full rounded-lg bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Referensi</label>
                                            <input type="url" placeholder="https://"
                                                class="w-full rounded-lg bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm">
                                        </div>
                                    </div>
                                </div>

                                <!-- External Content -->
                                <div
                                    class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-dashed border-slate-200 dark:border-slate-700">
                                    <h5 class="text-xs font-bold text-slate-500 uppercase mb-3 text-center">External
                                        Sources</h5>
                                    <div class="space-y-4">
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Jumlah
                                                Konten</label>
                                            <input type="number"
                                                class="w-full rounded-lg bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Referensi</label>
                                            <input type="url" placeholder="https://"
                                                class="w-full rounded-lg bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Targets & Costs -->
                        <div class="pt-6 border-t border-slate-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-2 mb-4 text-primary">
                                <span class="material-symbols-outlined">ads_click</span>
                                <h4 class="text-sm font-bold uppercase tracking-wider">Targets & Financials</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target
                                        Views</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-2.5 text-slate-400 material-symbols-outlined text-[18px]">visibility</span>
                                        <input type="number"
                                            class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm pl-10">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target
                                        Leads</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-2.5 text-slate-400 material-symbols-outlined text-[18px]">group_add</span>
                                        <input type="number"
                                            class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm pl-10">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target
                                        Transaksi</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-2.5 text-slate-400 material-symbols-outlined text-[18px]">shopping_cart</span>
                                        <input type="number"
                                            class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white text-sm pl-10">
                                    </div>
                                </div>
                                <div class="md:col-span-1">
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Cost
                                        Produksi Konten</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-2 text-slate-500 text-sm font-semibold">Rp</span>
                                        <input type="text"
                                            class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white pl-10 text-sm"
                                            placeholder="0">
                                    </div>
                                </div>
                                <div class="md:col-span-1">
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Cost
                                        Placement</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-2 text-slate-500 text-sm font-semibold">Rp</span>
                                        <input type="text"
                                            class="w-full rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent text-slate-900 dark:text-white pl-10 text-sm"
                                            placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Footer -->
                <div
                    class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 border-t border-slate-200 dark:border-slate-700 flex justify-end gap-3 rounded-b-2xl shrink-0">
                    <button type="button"
                        class="px-4 py-2 bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-600 rounded-lg text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors shadow-sm"
                        onclick="document.getElementById('create-campaign-modal').classList.add('hidden')">
                        Cancel
                    </button>
                    <button type="button"
                        class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                        Create Campaign
                    </button>
                </div>
            </div>
        </div>
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

    <div id="modal-edit"
        class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4 backdrop-blur-sm">
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-8 bg-black/20">
            <div
                class="bg-white dark:bg-slate-900 w-full max-w-4xl max-h-[90vh] rounded-2xl shadow-[0_32px_64px_-12px_rgba(0,0,0,0.5)] border border-slate-200 dark:border-slate-800 flex flex-col relative animate-in fade-in zoom-in-95 duration-200">
                <div
                    class="px-8 py-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/20 rounded-t-2xl">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Edit Campaign</h2>
                        <p class="text-slate-500 text-xs font-medium mt-1 uppercase tracking-widest">Update campaign
                            details and targets</p>
                    </div>
                    <button
                        class="p-2 text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors"
                        onclick="document.getElementById('modal-edit').classList.add('hidden')">
                        <span class="material-symbols-outlined text-2xl">close</span>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-8 modal-scroll">
                    <form class="space-y-10">
                        <section>
                            <h3
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-primary mb-6 flex items-center gap-3">
                                <span class="w-8 h-px bg-primary/30"></span> Core Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Campaign
                                        Theme</label>
                                    <input
                                        class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-primary focus:border-primary transition-all"
                                        type="text" value="Summer Tech Launch 2024" />
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Brand</label>
                                    <select
                                        class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-primary focus:border-primary transition-all">
                                        <option>Global Tech Solutions</option>
                                        <option>NextGen Electronics</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Content
                                        Pillar</label>
                                    <input
                                        class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-primary focus:border-primary transition-all"
                                        type="text" value="Innovation &amp; Lifestyle" />
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Angle</label>
                                    <input
                                        class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-primary focus:border-primary transition-all"
                                        type="text" value="Empowering Productivity" />
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Primary
                                        Objective</label>
                                    <select
                                        class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-primary focus:border-primary transition-all">
                                        <option>Brand Awareness</option>
                                        <option>Lead Generation</option>
                                        <option>Direct Sales</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Period</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input
                                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2 text-sm"
                                            type="date" value="2024-10-01" />
                                        <input
                                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2 text-sm"
                                            type="date" value="2024-12-31" />
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section>
                            <h3
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-primary mb-6 flex items-center gap-3">
                                <span class="w-8 h-px bg-primary/30"></span> Strategy &amp; Messaging
                            </h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Target
                                        Audience</label>
                                    <input
                                        class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm"
                                        type="text" value="IT Decision Makers, Tech Enthusiasts, 25-45" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Problem</label>
                                        <textarea
                                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm"
                                            rows="2">Complex workflows slowing down creative production across distributed teams.</textarea>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Key
                                            Message</label>
                                        <textarea
                                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm"
                                            rows="2">Simplify your vision with our intuitive AI-powered tech ecosystem.</textarea>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Reason
                                            to Believe (RTB)</label>
                                        <input
                                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm"
                                            type="text" value="Used by 40% of Fortune 500 companies" />
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Call
                                            to Action (CTA)</label>
                                        <input
                                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm"
                                            type="text" value="Start Free Trial" />
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section>
                            <h3
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-primary mb-6 flex items-center gap-3">
                                <span class="w-8 h-px bg-primary/30"></span> Production Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Produced
                                        Content</label>
                                    <input
                                        class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm"
                                        type="text" value="Main Promo Video" />
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Format</label>
                                    <select
                                        class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm">
                                        <option>4K Video (16:9)</option>
                                        <option>Social Reel (9:16)</option>
                                        <option>Static Carousel</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Int.
                                            Ref</label>
                                        <input
                                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm"
                                            type="number" value="12" />
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Ext.
                                            Ref</label>
                                        <input
                                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm"
                                            type="number" value="4" />
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section>
                            <h3
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-primary mb-6 flex items-center gap-3">
                                <span class="w-8 h-px bg-primary/30"></span> Targets &amp; Costs
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div
                                    class="p-4 bg-slate-50 dark:bg-slate-800/30 rounded-xl border border-slate-200 dark:border-slate-700/50 space-y-3">
                                    <p
                                        class="text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">
                                        Views Target</p>
                                    <input
                                        class="w-full bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded px-3 py-1.5 text-center font-bold text-slate-900 dark:text-white"
                                        type="text" value="1,200,000" />
                                </div>
                                <div
                                    class="p-4 bg-slate-50 dark:bg-slate-800/30 rounded-xl border border-slate-200 dark:border-slate-700/50 space-y-3">
                                    <p
                                        class="text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">
                                        Leads Target</p>
                                    <input
                                        class="w-full bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded px-3 py-1.5 text-center font-bold text-slate-900 dark:text-white"
                                        type="text" value="45,000" />
                                </div>
                                <div
                                    class="p-4 bg-slate-50 dark:bg-slate-800/30 rounded-xl border border-slate-200 dark:border-slate-700/50 space-y-3">
                                    <p
                                        class="text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">
                                        Transactions</p>
                                    <input
                                        class="w-full bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded px-3 py-1.5 text-center font-bold text-slate-900 dark:text-white"
                                        type="text" value="2,800" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Production
                                        Costs</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">$</span>
                                        <input
                                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg pl-8 pr-4 py-2.5 text-sm font-medium"
                                            type="text" value="15,000.00" />
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Placement
                                        Costs</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">$</span>
                                        <input
                                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-lg pl-8 pr-4 py-2.5 text-sm font-medium"
                                            type="text" value="35,000.00" />
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
                <div
                    class="bg-slate-50 dark:bg-slate-900 px-8 py-5 border-t border-slate-200 dark:border-slate-800 flex justify-end items-center gap-4 rounded-b-2xl">
                    <button
                        class="px-5 py-2.5 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 text-sm font-bold transition-colors"
                        onclick="document.getElementById('modal-edit').classList.add('hidden')">Cancel</button>
                    <button
                        class="px-8 py-2.5 bg-primary text-white rounded-lg font-bold text-sm shadow-xl shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">Save
                        Changes</button>
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