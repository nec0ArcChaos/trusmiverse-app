
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/clockpicker/jquery-clockpicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    // function sendMessage()
    // {
    //     var message = $("#message").val();
    //     var user_id = $("#user_id").val();
    //     console.log(message);
    //     // if (message.trim() === '') return;

    //     // $("#chat").append('<div class="message user"><b>User:</b> ' + message + '</div>');

    //     $.ajax({
    //         url: "https://n8n.trustcore.id/webhook-test/chatbot_hr",
    //         type: "POST",
    //         contentType: "application/json",   // penting untuk JSON
    //         data: JSON.stringify({ message: message, user_id: user_id }),
    //         dataType: "json",
    //         success: function(res) {
    //             console.log("Respon dari n8n:", res);
    //             $("#chat").append('<div class="message bot"><b>Bot:</b> ' + res.jawaban + '</div>');
    //             $("#chat").scrollTop($("#chat")[0].scrollHeight);
    //         },
    //         error: function(xhr, status, error) {
    //             console.error("Error:", error, xhr.responseText);
    //         }
    //     });

    //     // $("#message").val('');
    // }


    // function sendMessage()
    // {
    //     var message = $("#message").val();
    //     var user_id = $("#user_id").val();

    //     if (message.trim() === "") return; // cegah insert kosong

    //     // tampilkan pesan user langsung
    //     $("#chat").append(`
    //         <div class="d-flex justify-content-end mb-3">
    //             <div class="p-2 rounded-3 bg-light" style="max-width: 80%;">
    //                 <p class="mb-0 small">`+ message +`</p>
    //             </div>
    //         </div>
    //     `);

    //     $.ajax({
    //         url: "<?= base_url('api/insert_chatbot_hr/save_chatbot_hr') ?>",
    //         type: "POST",
    //         data: {
    //             message: message,
    //             user_id: user_id
    //         },
    //         dataType: "json",
    //         success: function(res) {
    //             if(res.jawaban){
    //                 $("#chat").append(`
    //                     <div class="d-flex justify-content-start mb-3">
    //                         <div class="p-2 rounded-3 text-white bg-secondary" style="max-width: 80%;">
    //                             <p class="mb-0 small">`+ res.jawaban +`</p>
    //                         </div>
    //                     </div>
    //                 `);
    //             }
    //             $("#chat").scrollTop($("#chat")[0].scrollHeight);
    //         },
    //         error: function(xhr, status, error) {
    //             console.error("Error:", error, xhr.responseText);
    //         }
    //     });

    //     $("#message").val(""); // kosongkan input
    // }


    function sendMessage()
    {
        var message = $("#message").val();
        var user_id = $("#user_id").val();
        var session_id = $("#session_id").val() || generateSessionId(); // fungsi untuk generate session ID
        var role = "user"; // default role

        if (message.trim() === "") return; // cegah insert kosong

        // tampilkan pesan user langsung
        $("#chat").append(`
            <div class="d-flex justify-content-end mb-3">
                <div class="p-2 rounded-3 bg-light" style="max-width: 80%;">
                    <p class="mb-0 small">${message}</p>
                </div>
            </div>
        `);

        // Tampilkan loading indicator
        $("#chat").append(`
            <div class="d-flex justify-content-start mb-3" id="loading-indicator">
                <div class="p-2 rounded-3 text-white bg-secondary" style="max-width: 80%;">
                    <p class="mb-0 small"><i class="fas fa-spinner fa-spin"></i> Thinking...</p>
                </div>
            </div>
        `);
        $("#chat").scrollTop($("#chat")[0].scrollHeight);

        $.ajax({
            url: "<?= base_url('api/insert_chatbot_hr/save_chatbot_hr') ?>",
            type: "POST",
            data: {
                message: message,
                user_id: user_id,
                session_id: session_id,
                role: role
            },
            dataType: "json",
            success: function(res) {
                // Hapus loading indicator
                $("#loading-indicator").remove();
                
                if(res.status === 'success' && res.jawaban){
                    $("#chat").append(`
                        <div class="d-flex justify-content-start mb-3">
                            <div class="p-2 rounded-3 text-white bg-secondary" style="max-width: 80%;">
                                <p class="mb-0 small">${res.jawaban}</p>
                            </div>
                        </div>
                    `);
                } else {
                    $("#chat").append(`
                        <div class="d-flex justify-content-start mb-3">
                            <div class="p-2 rounded-3 text-white bg-danger" style="max-width: 80%;">
                                <p class="mb-0 small">Error: ${res.jawaban || 'Terjadi kesalahan'}</p>
                            </div>
                        </div>
                    `);
                }
                $("#chat").scrollTop($("#chat")[0].scrollHeight);
            },
            error: function(xhr, status, error) {
                $("#loading-indicator").remove();
                $("#chat").append(`
                    <div class="d-flex justify-content-start mb-3">
                        <div class="p-2 rounded-3 text-white bg-danger" style="max-width: 80%;">
                            <p class="mb-0 small">Error: Terjadi kesalahan koneksi</p>
                        </div>
                    </div>
                `);
                $("#chat").scrollTop($("#chat")[0].scrollHeight);
                console.error("Error:", error, xhr.responseText);
            }
        });

        $("#message").val(""); // kosongkan input
    }

    // Fungsi untuk generate session ID
    function generateSessionId() {
        return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }





    // $(document).ready(function()
    // {

    //     const $messageForm      = $('#messageForm');
    //     const $chatMessages     = $('#chatMessages');
    //     const $userMessageInput = $('#userMessage');
    //     const $sessionIdInput   = $('#sessionId');

    //     loadChatSessions();

    //     $userMessageInput.on('input', function ()
    //     {

    //         this.style.height = 'auto';

    //         const maxHeight = 120; // batas tinggi maksimal
    //         const scrollHeight = this.scrollHeight;

    //         if (scrollHeight <= maxHeight) {
    //             this.style.height = scrollHeight + 'px';
    //             this.style.overflowY = 'hidden';
    //         } else {
    //             this.style.height = maxHeight + 'px';
    //             this.style.overflowY = 'auto';
    //         }
        
    //     });

    //     // Fungsi untuk menambahkan pesan ke chat
    //     function addMessage(content, sender)
    //     {

    //         const $message = $('<div>').addClass('message ' + sender);
    //         const $messageContent = $('<div>').addClass('message-content');

    //         $message.append($messageContent);
    //         $chatMessages.append($message);
    //         $chatMessages.scrollTop($chatMessages[0].scrollHeight); // Scroll otomatis ke bawah

    //         if (sender === 'bot' || sender === 'loader_chat') {
    //             typeMessageHTML(content, $messageContent);
    //         } else {
    //             $messageContent.text(content); // Pesan langsung untuk pengguna
    //         }

    //     }

    //     // Fungsi untuk mengetik konten HTML dengan benar
    //     function typeMessageHTML(htmlContent, $element)
    //     {
    //         const $nodes = $($.parseHTML(htmlContent)); // Mengubah HTML menjadi jQuery object

    //         let nodeIndex = 0;
    //         let charIndex = 0;

    //         function typeNext()
    //         {
                
    //             if (nodeIndex < $nodes.length) {
    //             const currentNode = $nodes[nodeIndex];

    //                 if (currentNode.nodeType === Node.TEXT_NODE) {
    //                     if (charIndex < currentNode.textContent.length) {
    //                         $element.append(currentNode.textContent.charAt(charIndex));
    //                         charIndex++;
    //                         setTimeout(typeNext, 30); // Jeda 100ms per karakter
    //                     } else {
    //                         charIndex = 0;
    //                         nodeIndex++;
    //                         typeNext();
    //                     }
    //                 } else {
    //                     $element.append(currentNode); // Tambahkan elemen HTML sekaligus
    //                     nodeIndex++;
    //                     typeNext();
    //                 }
    //             }
    //         }

    //         typeNext(); // Mulai mengetik
    //     }

    //     // Send message function
    //     function sendMessage(userMessage, sessionId)
    //     {

    //         addMessage(userMessage, 'user');
    //         $userMessageInput.val('');

    //         const loaderChat = `
    //             <div class="container-loader">
    //             <div class="dot"></div><div class="dot"></div><div class="dot"></div>
    //             </div>`;
    //         addMessage(loaderChat, 'loader_chat');

    //         $('.loader_chat').show();

    //         // Create FormData to handle text and file uploads
    //         let formData = new FormData();
    //         formData.append("category", 4);
    //         formData.append("content", userMessage);
    //         formData.append("sessionId", sessionId);

    //         // Check if a file is selected
    //         let fileInput = document.getElementById("fileInput");
    //         if (fileInput.files.length > 0) {
    //             formData.append("file", fileInput.files[0]); // Append file
    //         }

    //         $.ajax({
    //             url: '<?php echo base_url() ?>timeline_onboarding/get_help',
    //             method: 'POST',
    //             dataType: 'html',
    //             data: formData,
    //             processData: false, // Prevent automatic data transformation
    //             contentType: false, // Prevent jQuery from setting content type
    //             cache: false
    //         })

    //         .done(function(response) {
    //             loadChatMessages(sessionId);
    //             $('.loader_chat').hide();
    //             addMessage(response || 'Maaf, saya tidak mengerti.', 'bot');
    //             loadChatSessions();

    //             fileInput.value = "";
    //             fileNameDisplay.textContent = "";
    //         })

    //         .fail(function() {
    //             $('.loader_chat').hide();
    //             addMessage('Terjadi kesalahan. Coba lagi nanti.', 'bot');
    //         });

    //     }

    //     // Handle new chat button
    //     $("#newChatButton").on("click", async function()
    //     {

    //         loadNewChat();
    //         document.getElementById("sidebar").classList.add("d-none");
    //         document.getElementById("closeSidebar").classList.add("d-none");

    //     });

    //     // Handle message form submission
    //     $messageForm.on('submit', async function(e)
    //     {

    //         e.preventDefault();
    //         const userMessage = $userMessageInput.val().trim();
    //         console.log(userMessage);

    //         const sessionId = $sessionIdInput.val().trim();
    //         console.log(sessionId);

    //         if (!userMessage) return;

    //         if (sessionId == '' || sessionId == null) {
    //             console.log('session Id kosong, buat chat baru');

    //             // Create new session if none exists
    //             try {
    //                 const response = await $.post('<?php echo base_url() ?>timeline_onboarding/create_new_chat_session');
    //                 const responseData = JSON.parse(response);
    //                 console.log("New session created:", responseData.session_id); // Debugging

    //                 document.getElementById("sessionId").value = responseData.session_id;

    //                 if (responseData.session_id) {
    //                     currentSessionId = responseData.session_id;
    //                     sendMessage(userMessage, currentSessionId);
    //                     removeImage()
    //                     loadChatSessions();
    //                 }
    //             } catch (error) {
    //                 console.error("Error creating session:", error);
    //             }
    //         } else {
    //             console.log('session Id ada, lanjut chat, id=' + sessionId);
    //             removeImage()
    //             sendMessage(userMessage, sessionId);
    //         }

    //     });

    //     function cleanText(str)
    //     {
    //         if (!str) return '';

    //         // Create a temporary div element to decode HTML entities
    //         const tempDiv = document.createElement('div');
    //         tempDiv.innerHTML = str;
    //         let cleaned = tempDiv.textContent || tempDiv.innerText || '';

    //         // Remove any remaining HTML tags
    //         cleaned = cleaned.replace(/<\/?[^>]+(>|$)/g, "");

    //         // Replace common HTML entities
    //         const entityMap = {
    //             '&lt;': '<',
    //             '&gt;': '>',
    //             '&amp;': '&',
    //             '&quot;': '"',
    //             '&#39;': "'",
    //             '&nbsp;': ' '
    //         };

    //         return cleaned.replace(/&(lt|gt|amp|quot|#39|nbsp);/g, match => entityMap[match]);
    //     }

    //     function loadChatSessions()
    //     {

    //         fetch('<?php echo base_url() ?>timeline_onboarding/get_chat_sessions')
    //         .then(response => response.json())
    //         .then(data => {
    //             let chatHistoryContainer = document.getElementById("chatSessions");
    //             chatHistoryContainer.innerHTML = "";

    //             data.forEach(chat => {
    //                 let listItem = document.createElement("li");
    //                 listItem.classList.add("list-group-item", "chat-session", "d-flex", "justify-content-between", "align-items-center");
    //                 listItem.dataset.chatId = chat.id;
    //                 listItem.textContent = chat.session_name;

    //                 // Create delete button
    //                 let deleteButton = document.createElement("button");
    //                 deleteButton.classList.add("btn", "btn-sm", "btn-default");
    //                 deleteButton.innerHTML = '<i class="bi bi-trash"></i>';

    //                 deleteButton.onclick = function() {
    //                     deleteChatSession(chat.id, listItem);
    //                 };

    //                 // Create edit button
    //                 let editButton = document.createElement("button");
    //                 editButton.classList.add("btn", "btn-sm", "btn-default");
    //                 editButton.innerHTML = '<i class="bi bi-pencil"></i>';

    //                 // Shorten the last message if too long
    //                 // let lastMessagePreview = chat.last_message ? stripHtml(chat.last_message).substring(0, 40) + "..." : "No messages yet";
    //                 let lastMessage = chat.last_message;
    //                 lastMessage = cleanText(lastMessage);
    //                 let lastMessagePreview = chat.session_title ? stripHtml(chat.session_title).substring(0, 40) + "..." : lastMessage.substring(0, 40) + "...";

    //                 editButton.onclick = function() {
    //                     openEditModal(chat.id, lastMessagePreview);
    //                 };

    //                 listItem.innerHTML = `
    //                         <div class="chat-preview">${lastMessagePreview}</div>
    //                     `;

    //                 listItem.addEventListener("click", function() {
    //                     loadChatMessages(chat.id);
    //                     document.getElementById("sidebar").classList.add("d-none");
    //                 });

    //                 // Append button to list item
    //                 // listItem.appendChild(deleteButton);
    //                 listItem.appendChild(editButton);
    //                 chatHistoryContainer.appendChild(listItem);
    //             });
    //         })
    //         .catch(error => console.error("Error loading chat history:", error));
    //     }

    //     function loadChatMessages(sessionId)
    //     {

    //         document.getElementById("sessionId").value = sessionId;

    //         fetch(`<?php echo base_url() ?>timeline_onboarding/get_chat_messages/${sessionId}`)
    //         .then(response => response.json())
    //         .then(data => {
    //             let chatMessages = document.getElementById("chatMessages");
    //             chatMessages.innerHTML = "";
    //             data.forEach(message => {
    //                 let messageDiv = document.createElement("div");
    //                 messageDiv.classList.add("message", message.role === "user" ? "user" : "bot");

    //                 // ✅ Single bubble for both image and text
    //                 let contentDiv = document.createElement("div");
    //                 contentDiv.classList.add("message-content");

    //                 // ✅ If there's an image, add it first
    //                 if (message.file_url) {
    //                     if (/\.(jpg|jpeg|png|gif)$/i.test(message.file_url)) {
    //                         contentDiv.innerHTML += `<img src="${message.file_url}" alt="Uploaded Image" style="max-width: 200px; border-radius: 10px; display: block; margin-bottom: 5px; margin-left: auto;">`;
    //                     } else {
    //                         contentDiv.innerHTML += `<a href="${message.file_url}" target="_blank" style="color: blue; text-decoration: underline;">📂 View File</a><br>`;
    //                     }
    //                 }

    //                 contentDiv.innerHTML += message.message;

    //                 messageDiv.appendChild(contentDiv);
    //                 chatMessages.appendChild(messageDiv);
    //             });

    //             chatMessages.scrollTo({
    //                 top: chatMessages.scrollHeight
    //             });
    //         })
    //         .catch(error => console.error("Error loading chat messages:", error));
    //     }

    //     function deleteChatSession(chatId, listItem)
    //     {
            
    //         if (!confirm("Apakah Anda yakin ingin menghapus sesi ini?")) return;

    //         fetch(`<?php echo base_url() ?>timeline_onboarding/delete_chat_session/${chatId}`)
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 setTimeout(() => {
    //                     loadNewChat();
    //                 }, 100); // Ensure DOM updates

    //             } else {
    //                 alert("Gagal menghapus sesi!");
    //             }
    //         })
    //         .catch(error => console.error("Error deleting chat session:", error));
    //     }

    //     function openEditModal(chatId, chatTitle)
    //     {

    //         document.getElementById("editChatId").value = chatId;
    //         document.getElementById("editChatTitle").value = chatTitle;

    //         // Open the Bootstrap modal
    //         var editModal = new bootstrap.Modal(document.getElementById("editChatModal"));
    //         editModal.show();

    //     }

    //     document.getElementById("saveChatTitle").addEventListener("click", function()
    //     {
    //         let chatId = document.getElementById("editChatId").value;
    //         let newTitle = document.getElementById("editChatTitle").value;

    //         if (newTitle.trim() === "") {
    //             alert("Title cannot be empty!");
    //             return;
    //         }

    //         // console.log(newTitle);

    //         // Call update function
    //         updateChatTitle(chatId, newTitle);
    //     });

    //     function updateChatTitle(chatId, newTitle)
    //     {

    //         fetch(`<?php echo base_url() ?>timeline_onboarding/update_chat_title/${chatId}`, {
    //             method: "POST",
    //             headers: {
    //                 "Content-Type": "application/json"
    //             },
    //             body: JSON.stringify({
    //                 title: newTitle
    //             })
    //         })

    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 alert("Chat title updated successfully!");
    //                 loadChatSessions();

    //                 $('#editChatModal').modal('hide');
    //             } else {
    //                 alert("Failed to update title!");
    //             }
    //         })
    //         .catch(error => console.error("Error updating title:", error));

    //     }


    //     function loadNewChat()
    //     {

    //         const sessionId = null;
    //         document.getElementById("sessionId").value = '';

    //         try {
    //             $chatMessages.html("");

    //             addMessage("Halo! Apa yang bisa saya bantu hari ini?", "bot");
    //             loadChatSessions();
    //         } catch (error) {
    //             console.error("Error creating new chat:", error);
    //         }
    //     }

    //     document.getElementById("toggleSidebar").addEventListener("click", function()
    //     {
    //         document.getElementById("sidebar").classList.toggle("d-none");
    //         document.getElementById("closeSidebar").classList.toggle("d-none");
    //     });

    //     document.getElementById("closeSidebar").addEventListener("click", function()
    //     {
    //         document.getElementById("sidebar").classList.add("d-none");
    //         document.getElementById("closeSidebar").classList.add("d-none");
    //     });

    //     document.getElementById("uploadBtn").addEventListener("click", function()
    //     {
    //         document.getElementById("fileInput").click();
    //     });

    //     document.getElementById("fileInput").addEventListener("change", function()
    //     {
    //         let fileName = this.files[0] ? this.files[0].name : "No file selected";

    //         document.getElementById("fileNameDisplay").textContent = fileName;

    //         if (this.files.length > 0) {
    //             fileNameDisplay.textContent = "File: " + this.files[0].name; // Display file name
    //         } else {
    //             fileNameDisplay.textContent = ""; // Clear if no file selected
    //         }
    //     });


    //     function stripHtml(html)
    //     {
    //         let doc = new DOMParser().parseFromString(html, "text/html");
    //         return doc.body.textContent || "";
    //     }


    // });


</script>