<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap"
    rel="stylesheet" />
<link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />


<style>
    .loader-msg {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: block;
        margin: 15px auto;
        position: relative;
        color: #015EC2;
        box-sizing: border-box;
        animation: animloader 2s linear infinite;
    }

    @keyframes animloader {
        0% {
            box-shadow: 14px 0 0 -2px, 38px 0 0 -2px, -14px 0 0 -2px, -38px 0 0 -2px;
        }

        25% {
            box-shadow: 14px 0 0 -2px, 38px 0 0 -2px, -14px 0 0 -2px, -38px 0 0 2px;
        }

        50% {
            box-shadow: 14px 0 0 -2px, 38px 0 0 -2px, -14px 0 0 2px, -38px 0 0 -2px;
        }

        75% {
            box-shadow: 14px 0 0 2px, 38px 0 0 -2px, -14px 0 0 -2px, -38px 0 0 -2px;
        }

        100% {
            box-shadow: 14px 0 0 -2px, 38px 0 0 2px, -14px 0 0 -2px, -38px 0 0 -2px;
        }
    }

    .session-ended {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .dark-mode .session-ended {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    }

    .session-summary {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
    }

    .dark-mode .session-summary {
        background-color: #343a40;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #d1edff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .dark-mode .success-icon {
        background-color: rgba(25, 135, 84, 0.2);
    }
</style>