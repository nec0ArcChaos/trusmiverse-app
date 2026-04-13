<div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
            <div class="col">
                <span class="badge bg-light-blue small px-1 fw-bold text-dark rounded-5 me-2">
                    <div class="avatar avatar-20 rounded-5 bg-white">
                        <i class="bi bi-diagram-3"></i>
                    </div> Case: Quality Control - Unit <span id="label_project"></span>
                </span>

            </div>
            <div class="col-auto">
                <div class="input-group">
                    <span class="small px-1 text-muted" style="position: relative;top: 10px;" id="last_updated"></span>
                    <button class="btn btn-outline-primary" onclick="update_kpi()"><i class="bi bi-arrow-clockwise"></i>
                        Update</button>
                    <select name="id" class="form-control px-3 border-custom border-1" id="id" style="min-width: 280px;">
                        <?php foreach ($project as $item): ?>
                            
                            <option value="<?= $item->id_project ?>" <?= ($item->id_project == 42 ) ? 'selected' : '' ?>><?= $item->project ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-calendar"></i> <span id="periodeBtn">Periode</span>
                    </button>
                    <style>
                        #periode-list {
                            max-height: 280px;
                            /* Atur tinggi maksimal dropdown */
                            overflow-y: auto;
                            /* Tampilkan scrollbar vertikal jika perlu */
                        }
                    </style>
                    <ul class="dropdown-menu" id="periode-list">
                        <?php
                        $startYear = 2025;
                        $startMonth = 8; // Agustus
                        $endYear = 2026;
                        $endMonth = 12; // Desember
                        $currentPeriod = date('Y-m');
                        $bulanIndonesia = [
                            1 => 'Januari',
                            'Februari',
                            'Maret',
                            'April',
                            'Mei',
                            'Juni',
                            'Juli',
                            'Agustus',
                            'September',
                            'Oktober',
                            'November',
                            'Desember'
                        ];

                        // Mulai looping
                        for ($year = $startYear; $year <= $endYear; $year++) {
                            $loopStartMonth = ($year == $startYear) ? $startMonth : 1;
                            $loopEndMonth = ($year == $endYear) ? $endMonth : 12;

                            for ($month = $loopStartMonth; $month <= $loopEndMonth; $month++) {
                                $value = sprintf('%d-%02d', $year, $month);
                                $text = $bulanIndonesia[$month] . ' ' . $year;
                                $activeClass = ($value == $currentPeriod) ? 'active' : '';
                                echo "<li><button class=\"dropdown-item {$activeClass}\" value=\"{$value}\">{$text}</button></li>";
                            }
                            if ($year < $endYear) {
                                echo '<li><hr class="dropdown-divider"></li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>