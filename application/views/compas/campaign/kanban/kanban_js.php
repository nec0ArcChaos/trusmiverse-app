<script>
    loadDraftCampaigns(1);

    // Filter events
    var typingTimer;
    $('#draft_filter_title').on('keyup', function () {
        var searchVal = $(this).val();
        clearTimeout(typingTimer);
        if (searchVal.length >= 4 || searchVal.length === 0) {
            typingTimer = setTimeout(function () {
                loadDraftCampaigns(1); // Reset to page 1 on filter
            }, 500);
        }
    });

    function loadDraftCampaigns(page, priority = '') {
        var title = $('#draft_filter_title').val();

        // Skeleton Loading HTML
        var skeletonHtml = '';
        for (let i = 0; i < 3; i++) {
            skeletonHtml += `
            <div class="card border-0 mb-4" aria-hidden="true">
                <div class="card-body">
                    <div class="row align-items-center gx-2">
                        <div class="col">
                            <p class="placeholder-glow mb-2">
                                <span class="placeholder col-3"></span>
                            </p>
                            <div class="placeholder-glow mb-3">
                                <span class="placeholder col-12 rounded" style="height: 110px;"></span>
                            </div>
                            <div class="placeholder-glow mb-3">
                                <span class="placeholder col-4 btn btn-sm disabled"></span>
                            </div>
                            <h6 class="placeholder-glow mb-2">
                                <span class="placeholder col-7"></span>
                            </h6>
                            <p class="placeholder-glow">
                                <span class="placeholder col-12"></span>
                                <span class="placeholder col-8"></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row align-items-center gx-2">
                        <div class="col-auto avatar-group placeholder-glow">
                            <span class="placeholder rounded-circle" style="width: 30px; height: 30px; display:inline-block;"></span>
                            <span class="placeholder rounded-circle" style="width: 30px; height: 30px; display:inline-block;"></span>
                        </div>
                        <div class="col placeholder-glow">
                            <span class="placeholder col-6"></span>
                        </div>
                        <div class="col-auto placeholder-glow">
                            <span class="placeholder rounded" style="width: 36px; height: 36px; display:inline-block;"></span>
                            <span class="placeholder rounded" style="width: 36px; height: 36px; display:inline-block;"></span>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        // Show Skeleton before Ajax
        $('#draft_items_container').html(skeletonHtml);
        $('#draft_pagination_container').hide();

        $.ajax({
            url: "<?= base_url('sub_campaign/kanban/get_draft_campaigns') ?>",
            type: "POST",
            data: {
                title: title,
                priority: priority,
                page: page
            },
            dataType: "json",
            success: function (response) {
                var items = response.items;
                var html = '';

                if (items.length > 0) {
                    $.each(items, function (index, item) {
                        var priorityClass = 'bg-light-green text-green';
                        var cardClassLate = 'border-0 mb-4';

                        if (item.status_leadtime == 'at_risk') {
                            cardClassLate = 'border-0 mb-4 bg-gradient-theme-light theme-orange';
                        }

                        if (item.status_leadtime == 'late') {
                            cardClassLate = 'border-0 mb-4 bg-gradient-theme-light theme-pink';
                        }

                        if (item.priority == 'Medium') {
                            priorityClass = 'bg-light-yellow text-yellow';
                        }
                        if (item.priority == 'High') {
                            priorityClass = 'bg-light-orange text-orange';
                        }
                        if (item.priority == 'Urgent') {
                            priorityClass = 'bg-light-red text-red';
                        }

                        var avatarsHtml = '';
                        $.each(item.avatars, function (i, avatar) {
                            avatarsHtml += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url('<?= base_url() ?>assets/compas/main_theme/img/${avatar}');">
                                                <img src="<?= base_url() ?>assets/compas/main_theme/img/${avatar}" alt="" style="display: none;">
                                            </div>`;
                        });

                        var imageHtml = '';
                        if (item.image) {
                            imageHtml = `<div class="coverimg rounded h-110 overflow-hidden mb-3">
                                            <img src="<?= base_url() ?>assets/compas/main_theme/img/${item.image}" class="w-100" alt="" />
                                        </div>`;
                        }

                        html += `
                        <div class="card ${cardClassLate}" id="campaign-${item.id}">
                            <div class="card-body">
                                <div class="row align-items-center gx-2">
                                    <div class="col">
                                        <p class="text-secondary small">${item.time}</p>
                                        ${imageHtml}
                                        <span class="btn btn-sm btn-link ${priorityClass} mb-3">${item.priority}</span>
                                        <h6>${item.title}</h6>
                                        <p class="text-secondary small">${item.description}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row align-items-center gx-2">
                                    <div class="col-auto avatar-group">
                                        ${avatarsHtml}
                                    </div>
                                    <div class="col">
                                        <p class="text-secondary small mb-0">${item.more_users} more</p>
                                        <p class="small">Working</p>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-paperclip avatar avatar-36 bg-light-gray rounded"></i>
                                        <i class="bi bi-chat-right-dots avatar avatar-36 bg-light-gray rounded"></i>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    });
                } else {
                    html = '<div class="text-center text-muted p-3">No campaigns found</div>';
                }

                setTimeout(function () {
                    $('#draft_items_container').html(html);
                }, 2000);

                // Pagination logic
                if (response.total_pages > 1) {
                    $('#draft_pagination_container').show();
                    var paginationHtml = '';

                    // Previous
                    var prevDisabled = (response.current_page == 1) ? 'disabled' : '';
                    paginationHtml += `<li class="page-item ${prevDisabled}">
                                        <a class="page-link" href="javascript:void(0)" data-page="${response.current_page - 1}">Previous</a>
                                       </li>`;

                    // Pages
                    for (var i = 1; i <= response.total_pages; i++) {
                        var active = (i == response.current_page) ? 'active' : '';
                        paginationHtml += `<li class="page-item ${active}">
                                            <a class="page-link" href="javascript:void(0)" data-page="${i}">${i}</a>
                                           </li>`;
                    }

                    // Next
                    var nextDisabled = (response.current_page == response.total_pages) ? 'disabled' : '';
                    paginationHtml += `<li class="page-item ${nextDisabled}">
                                        <a class="page-link" href="javascript:void(0)" data-page="${response.current_page + 1}">Next</a>
                                      </li>`;

                    $('#draft_pagination').html(paginationHtml);
                } else {
                    $('#draft_pagination_container').hide();
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching drafts:", error);
                $('#draft_items_container').html('<div class="text-center text-danger p-3">Error loading campaigns</div>');
            }
        });
    }

    // Pagination Click
    $(document).off('click', '#draft_pagination .page-link').on('click', '#draft_pagination .page-link', function (e) {
        e.preventDefault();
        var page = $(this).data('page');
        // Check if disabled
        if (!$(this).parent().hasClass('disabled') && page > 0) {
            loadDraftCampaigns(page);
        }
    });
</script>