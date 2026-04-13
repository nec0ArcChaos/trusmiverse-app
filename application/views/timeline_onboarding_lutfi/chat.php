<script src="<?= base_url('assets/js/owl.carousel.min.js') ?>"></script>
<script>
  $(document).ready(function(){
      $(".owl-carousel").owlCarousel({
          loop:true,
          margin:10,
          nav:true,
          items:1
      });
  });
</script>




<!-- <div class="card border border-warning bg-light-warning rounded-3 shadow-none">
    <div class="card-body bg-none">
        <h5 class="fw-bold mb-3"><i class="bi bi-stars me-2"></i> Ambar AI</h5>

        <div id="chat" class="mb-3" style="height: 250px; overflow-y: auto;">
            
            <?php
                // $user_id    = $this->session->userdata('user_id');
            ?>
        	<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" id="user_id" />

            <div class="d-flex justify-content-end mb-3">
                <div class="p-2 rounded-3  bg-light" style=" max-width: 80%;">
                    <p class="mb-0 small">Halo, saya ingin bertanya tentang proses onboarding. Apa
                        langkah pertamanya?</p>
                </div>
            </div>

            <div class="d-flex justify-content-start mb-3">
                <div class="p-2 rounded-3 text-white bg-secondary" style=" max-width: 80%;">
                    <p class="mb-0 small">Tentu! Langkah pertama dalam proses onboarding adalah
                        melengkapi data diri Anda di portal karyawan. Setelah itu, Anda akan dijadwalkan
                        untuk sesi orientasi bersama tim HR.</p>
                </div>
            </div>


        </div>

        <div class="mb-3 p-3 rounded-3" style="background-color: rgba(255, 255, 255, 0.39);">
            <p class="small mb-1"><i class="bi bi-lightbulb"></i> Tanyakan apa saja tentang proses
                onboarding</p>
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-sm btn-outline-secondary">Apa langkah pertama?</button>
                <button class="btn btn-sm btn-outline-secondary">Apa saja fitur utama?</button>
            </div>
        </div>

        <div class="input-group">
            <textarea class="form-control" id="message" placeholder="Tanyakan sesuatu..." rows="1" style="resize: none;"></textarea>
            <button type="button" class="btn btn-secondary" onclick="sendMessage()">
                <i class="bi bi-send-fill fs-5"></i>
            </button>
        </div>
        

    </div>
</div> -->


<div class="card border border-warning bg-light-warning rounded-3 shadow-none">
    <div class="card-body bg-none">
        <h5 class="fw-bold mb-3"><i class="bi bi-stars me-2"></i> Ambar AI</h5>

        <!-- Chat Area -->
        <div id="chat" style="height: 300px; overflow-y: auto;">

        <?php
            $user_id    = $this->session->userdata('user_id');
        ?>

        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" id="user_id" />

        <?php foreach ($chats as $chat): ?>
            <!-- Pesan user -->
            <div class="d-flex justify-content-end mb-2">
            <div class="p-2 rounded-3 bg-light border" style="max-width: 75%;">
                <p class="mb-0 small"><b>Saya:</b> <?= htmlspecialchars($chat->pertanyaan) ?></p>
                <small class="text-muted"><?= date("H:i", strtotime($chat->created_at)) ?></small>
            </div>
            </div>

            <!-- Jawaban bot -->
            <?php if (!empty($chat->jawaban)): ?>
            <div class="d-flex justify-content-start mb-3">
                <div class="p-2 rounded-3 text-white bg-secondary" style="max-width: 75%;">
                <p class="mb-0 small"><b>Bot:</b> <?= htmlspecialchars($chat->jawaban) ?></p>
                <small class="text-light"><?= date("H:i", strtotime($chat->created_at)) ?></small>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
        </div>

        <!-- Input -->
        <div class="input-group mt-3">
            <textarea class="form-control" id="message" placeholder="Tanyakan sesuatu..." rows="1" style="resize: none;"></textarea>
            <button type="button" class="btn btn-secondary" onclick="sendMessage()">
                <i class="bi bi-send-fill fs-5"></i>
            </button>
        </div>
    </div>
</div>
