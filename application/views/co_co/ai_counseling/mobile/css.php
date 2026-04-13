<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        font-family: 'Manrope', sans-serif;
    }

    body {
        transition: background-color 0.3s;
    }

    body.dark-mode {
        background-color: var(--bg-dark);
        color: white;
    }

    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
    }

    header {
        background: rgba(246, 246, 248, 0.8);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(203, 213, 225, 0.3);
        sticky-top: 0;
        z-index: 1020;
    }

    body.dark-mode header {
        background: rgba(16, 22, 34, 0.8);
        border-bottom-color: rgba(51, 65, 85, 0.3);
    }

    .logo-icon {
        color: var(--primary-color);
        width: 24px;
        height: 24px;
    }

    .nav-link {
        color: rgba(100, 116, 139, 1) !important;
        font-weight: 500;
        font-size: 0.875rem;
        transition: color 0.3s;
    }

    .nav-link:hover,
    .nav-link.active {
        color: var(--primary-color) !important;
    }

    body.dark-mode .nav-link {
        color: rgba(148, 163, 184, 1) !important;
    }

    .btn-notification {
        background-color: rgba(203, 213, 225, 0.3);
        border: none;
        color: rgba(71, 85, 105, 1);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-notification:hover {
        background-color: rgba(203, 213, 225, 1);
    }

    body.dark-mode .btn-notification {
        background-color: rgba(51, 65, 85, 0.3);
        color: rgba(148, 163, 184, 1);
    }

    body.dark-mode .btn-notification:hover {
        background-color: rgba(51, 65, 85, 1);
    }

    .profile-pic {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
    }

    .welcome-card {
        background: white;
        border: 1px solid rgba(203, 213, 225, 0.3);
        border-radius: 12px;
        padding: 24px;
    }

    body.dark-mode .welcome-card {
        background: #1e293b;
        border-color: rgba(51, 65, 85, 0.3);
    }

    .welcome-card h2 {
        font-size: 1.875rem;
        font-weight: bold;
        color: #1e293b;
        margin-bottom: 8px;
    }

    body.dark-mode .welcome-card h2 {
        color: white;
    }

    .welcome-card p {
        color: rgba(71, 85, 105, 1);
        margin-bottom: 0;
    }

    body.dark-mode .welcome-card p {
        color: rgba(148, 163, 184, 1);
    }

    .btn-primary-custom {
        background-color: var(--primary-color);
        border: none;
        color: white;
        font-weight: 700;
        border-radius: 8px;
        padding: 10px 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: opacity 0.3s;
    }

    .btn-primary-custom:hover {
        opacity: 0.9;
        color: white;
    }

    .section-title {
        font-size: 1.375rem;
        font-weight: bold;
        color: #1e293b;
        padding: 12px 16px 12px 16px;
        margin-bottom: 12px;
    }

    body.dark-mode .section-title {
        color: white;
    }

    .card-session {
        border: 1px solid rgba(203, 213, 225, 0.3);
        border-radius: 12px;
        background: white;
        overflow: hidden;
    }

    body.dark-mode .card-session {
        background: #1e293b;
        border-color: rgba(51, 65, 85, 0.3);
    }

    .session-highlight {
        background: rgba(19, 91, 236, 0.1);
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    body.dark-mode .session-highlight {
        background: rgba(19, 91, 236, 0.2);
    }

    .session-icon {
        background: white;
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        flex-shrink: 0;
    }

    body.dark-mode .session-icon {
        background: #334155;
    }

    .session-info h5 {
        font-size: 1rem;
        font-weight: 500;
        color: #1e293b;
        margin-bottom: 4px;
    }

    body.dark-mode .session-info h5 {
        color: white;
    }

    .session-info p {
        font-size: 0.875rem;
        color: rgba(71, 85, 105, 1);
        margin-bottom: 0;
    }

    body.dark-mode .session-info p {
        color: rgba(148, 163, 184, 1);
    }

    .stat-card {
        border: 1px solid rgba(203, 213, 225, 0.3);
        border-radius: 12px;
        background: white;
        padding: 24px;
    }

    body.dark-mode .stat-card {
        background: #1e293b;
        border-color: rgba(51, 65, 85, 0.3);
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(19, 91, 236, 0.2);
        color: var(--primary-color);
        margin-bottom: 16px;
    }

    .stat-card.yellow .stat-icon {
        background: rgba(234, 179, 8, 0.2);
        color: #eab308;
    }

    .stat-label {
        font-weight: 600;
        color: #1e293b;
        font-size: 1rem;
        margin-bottom: 16px;
    }

    body.dark-mode .stat-label {
        color: white;
    }

    .stat-value {
        font-size: 3rem;
        font-weight: 800;
        color: #1e293b;
    }

    body.dark-mode .stat-value {
        color: white;
    }

    .stat-desc {
        font-size: 0.875rem;
        color: rgba(71, 85, 105, 1);
        margin-top: 8px;
    }

    body.dark-mode .stat-desc {
        color: rgba(148, 163, 184, 1);
    }

    .activity-item {
        display: flex;
        gap: 16px;
        padding: 16px;
        align-items: flex-start;
        min-height: 72px;
    }

    .activity-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background: rgba(226, 232, 240, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(71, 85, 105, 1);
        flex-shrink: 0;
    }

    body.dark-mode .activity-icon {
        background: #334155;
        color: rgba(148, 163, 184, 1);
    }

    .activity-text h6 {
        font-size: 1rem;
        font-weight: 500;
        color: #1e293b;
        margin-bottom: 4px;
    }

    body.dark-mode .activity-text h6 {
        color: white;
    }

    .activity-text p {
        font-size: 0.875rem;
        color: rgba(71, 85, 105, 1);
        margin-bottom: 0;
    }

    body.dark-mode .activity-text p {
        color: rgba(100, 116, 139, 1);
    }

    .quick-access-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: rgba(226, 232, 240, 1);
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #334155;
        text-decoration: none;
        transition: background-color 0.3s;
        border: none;
        width: 100%;
        text-align: left;
    }

    .quick-access-link:hover {
        background: rgba(203, 213, 225, 1);
        color: #334155;
    }

    body.dark-mode .quick-access-link {
        background: #334155;
        color: rgba(226, 232, 240, 1);
    }

    body.dark-mode .quick-access-link:hover {
        background: #475569;
        color: rgba(226, 232, 240, 1);
    }

    .session-content {
        padding: 8px;
    }

    .radio-card {
        transition: all 0.3s ease;
        cursor: pointer;
        opacity: 0;
        transform: translateY(20px);
    }

    .radio-card-1.animate-in {
        animation: fadeInUp 0.6s ease forwards;
    }

    .radio-card-2.animate-in {
        animation: fadeInUp 0.8s ease forwards;
    }

    .radio-card-3.animate-in {
        animation: fadeInUp 1s ease forwards;
    }

    .radio-card-4.animate-in {
        animation: fadeInUp 1.2s ease forwards;
    }

    .radio-card-5.animate-in {
        animation: fadeInUp 1.4s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .radio-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .radio-card.selected {
        border-color: #3b82f6;
        background-color: #eff6ff;
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15);
    }

    .radio-input {
        position: absolute;
        opacity: 0;
    }

    .cursor-pointen {
        cursor: pointer;
    }

    .border-blue-500 {
        border-color: #3b82f6;
    }

    .border-2 {
        border-width: 2px;
    }

    .border-gray-200 {
        border-color: #e5e7eb;
    }

    .bg-blue-50 {
        background-color: #eff6ff;
    }

    .hero-section {
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -10%;
        left: -10%;
        width: 50%;
        height: 50%;
        background-color: rgba(199, 210, 254, 0.4);
        border-radius: 50%;
        filter: blur(120px);
        z-index: -1;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -10%;
        right: -10%;
        width: 40%;
        height: 40%;
        background-color: rgba(233, 213, 255, 0.4);
        border-radius: 50%;
        filter: blur(120px);
        z-index: -1;
    }

    .gradient-text {
        background: linear-gradient(to right, #4f46e5, #9333ea);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .card-hover {
        transition: transform 0.5s, box-shadow 0.5s;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .chat-container {
        height: 500px;
        display: flex;
        flex-direction: column;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        background-color: #f8fafc;
    }

    .chat-messages::-webkit-scrollbar {
        display: none;
    }

    .chat-messages {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .message-bubble {
        max-width: 85%;
        padding: 0.75rem;
        border-radius: 1rem;
        margin-bottom: 1rem;
    }

    .message-bot {
        background-color: white;
        border: 1px solid #e2e8f0;
        border-top-left-radius: 0;
    }

    .message-user {
        background-color: #4f46e5;
        color: white;
        border-top-right-radius: 0;
        margin-left: auto;
    }

    .rotating-card {
        transform: rotate(2deg);
        transition: transform 0.7s;
    }

    .rotating-card:hover {
        transform: rotate(0);
    }

    .grow-card {
        position: relative;
        padding: 1.5rem;
        border-radius: 1rem;
        background-color: white;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.5s, box-shadow 0.5s;
    }

    .grow-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .grow-card-letter {
        position: absolute;
        top: 0;
        right: 0;
        padding: 1rem;
        font-size: 5rem;
        font-weight: 900;
        opacity: 0.05;
        transition: opacity 0.3s;
    }

    .grow-card:hover .grow-card-letter {
        opacity: 0.1;
    }

    .icon-circle {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        background-color: #f1f5f9;
        border: 1px solid #f1f5f9;
        transition: background-color 0.3s;
    }

    .grow-card:hover .icon-circle {
        background-color: #f1f5f9;
    }

    .badge-custom {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-gradient {
        background: linear-gradient(to right, #4f46e5, #9333ea);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 9999px;
        font-weight: 700;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        color: white;
    }

    .btn-outline-custom {
        padding: 0.75rem 2rem;
        border-radius: 9999px;
        border: 1px solid #e2e8f0;
        color: #475569;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-outline-custom:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
        color: #475569;
    }

    .chat-header {
        background: linear-gradient(to right, #4f46e5, #9333ea);
        color: white;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .chat-input-container {
        padding: 1rem;
        background-color: white;
        border-top: 1px solid #e2e8f0;
    }

    .chat-input {
        flex: 1;
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .chat-input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 1px #6366f1;
    }

    .send-button {
        background-color: #4f46e5;
        color: white;
        border: none;
        border-radius: 0.75rem;
        padding: 0.5rem;
        margin-left: 0.5rem;
        transition: background-color 0.3s;
    }

    .send-button:hover {
        background-color: #4338ca;
    }

    .send-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .cta-section {
        background-color: white;
        border: 1px solid #e2e8f0;
        border-radius: 1.5rem;
        padding: 3rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 0.25rem;
        background: linear-gradient(to right, #3b82f6, #6366f1, #a855f7);
    }

    .bg-light-bluemorph {
        background: linear-gradient(135deg, #e0f2fe 0%, #ffffff 50%, #bae6fd 100%);
    }

    .dark-mode .bg-light-bluemorph {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
    }

    .glass {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .duration-300 {
        transition-duration: 300ms;
    }

    .transition-all {
        transition-property: all;
        transition-timing-function:
            cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    .py-6 {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .z-50 {
        z-index: 50;
    }

    .top-0 {
        top: 0px;
    }

    .right-0 {
        right: 0px;
    }

    .left-0 {
        left: 0px;
    }

    .fixed {
        position: fixed;
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    .bg-white-40 {
        background-color: rgb(255 255 255 / 0.4);
    }

    .rounded-2xl {
        border-radius: 1rem;
    }

    .justify-between {
        justify-content: space-between;
    }

    .items-center {
        align-items: center;
    }

    .fs-7 {
        font-size: 0.75rem !important;
    }

    @media screen and (max-width: 768px) {

        .fs-4 {
            font-size: 1.25rem !important;
        }

        .fs-5 {
            font-size: 1rem !important;
        }

        .fs-6 {
            font-size: 0.75rem !important;
        }

        .fs-7 {
            font-size: 0.625rem !important;
        }

        p {
            font-size: 0.75rem !important;
        }

        .left-card img {
            display: none;
        }

        .btn-gradient {
            border-radius: 10px !important;
        }

        .btn-outline-custom {
            border-radius: 10px !important;
        }
    }
</style>