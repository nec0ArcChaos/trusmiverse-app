<div class="container mb-5" id="campaign_table_container">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="campaignDataTable" style="width:100%;">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3" style="width:40px;">#</th>
                            <th class="px-3 py-3">Campaign</th>
                            <th class="px-3 py-3">Brand</th>
                            <th class="px-3 py-3">Period</th>
                            <th class="px-3 py-3">Status</th>
                            <th class="px-3 py-3">Progress</th>
                            <th class="px-3 py-3">Team</th>
                            <th class="px-3 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="campaign_table_body">
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                Loading campaigns...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex align-items-center justify-content-between px-4 py-3 border-top"
                id="campaign_table_footer">
                <small class="text-muted" id="campaign_table_info">-</small>
                <nav aria-label="Campaign table pagination">
                    <ul class="pagination pagination-sm mb-0" id="campaign_table_pagination"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>