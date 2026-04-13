<style>
    /* DataTable Pagination Styling */
    .dataTables_paginate {
        text-align: center;
        padding: 1.5rem 0 0.5rem 0;
    }

    .paginate_button {
        display: inline-block;
        padding: 0.5rem 0.75rem;
        margin: 0 0.25rem;
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        color: #495057;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .paginate_button:hover:not(.disabled) {
        background-color: #f8f9fa;
        border-color: #80bdff;
        color: #0056b3;
    }

    .paginate_button.active {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .paginate_button.active:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .paginate_button.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .paginate_button.disabled:hover {
        background-color: white;
        border-color: #dee2e6;
        color: #495057;
    }

    .paginate_button a {
        color: inherit;
        text-decoration: none;
    }
</style>
