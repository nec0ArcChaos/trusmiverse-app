<style>
    /* Skeleton Loader Styles */
    .skeleton {
        background-color: #e2e5e7;
        background-image: linear-gradient(90deg, rgba(255, 255, 255, 0) 0, rgba(255, 255, 255, 0.2) 20%, rgba(255, 255, 255, 0.5) 50%, rgba(255, 255, 255, 0) 100%);
        background-size: 200px 100%;
        background-repeat: no-repeat;
        border-radius: 4px;
        display: inline-block;
        line-height: 1;
        width: 100%;
        animation: skeleton-shimmer 1.5s infinite;
    }

    @keyframes skeleton-shimmer {
        0% {
            background-position: -200px 0;
        }

        100% {
            background-position: calc(200px + 100%) 0;
        }
    }

    .skeleton-text {
        height: 10px;
        margin-bottom: 8px;
    }

    .skeleton-title {
        height: 20px;
        margin-bottom: 12px;
        width: 70%;
    }

    .skeleton-img {
        height: 120px;
        width: 100%;
        margin-bottom: 12px;
    }

    .skeleton-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-block;
    }

    .skeleton-tag {
        height: 24px;
        width: 60px;
        border-radius: 4px;
        margin-bottom: 12px;
        display: inline-block;
    }
</style>