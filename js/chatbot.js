$(document).ready(function() {
    $('#chatForm').on('submit', function(event) {
        event.preventDefault();
        var message = $('#message').val(); // Simpan pertanyaan pengguna sebelum dikirim

        // Ganti nama pengguna dengan nama lengkap dari pengguna yang sedang login
        var fullName = 'Me';

        // Tambahkan pesan ke kotak obrolan dengan nama lengkap dan kelas user-message
        $('#chatbox').append('<p class="user-message"><strong>' + fullName + ':</strong> ' + message + '</p>');

        $.ajax({
            url: 'response.php',
            method: 'POST',
            data: { message: message },
            dataType: 'json', // Tambahkan ini untuk memastikan respons diterima dalam format JSON
            success: function(response) {
                console.log('Response:', response); // Debug response
                // Ganti nama chatbot menjadi "Bot GlowRX" di dalam kotak obrolan
                var chatbotName = 'Bot GlowRX';
                // Tambahkan elemen baru untuk jawaban chatbot dengan kelas bot-message
                $('#chatbox').append('<p class="bot-message"><strong>' + chatbotName + ':</strong> ' + response.response + '</p>');

                // Simpan riwayat obrolan ke LocalStorage
                saveChatHistory();
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });

        // Hapus pertanyaan pengguna dari input
        $('#message').val('');
    });

    function saveChatHistory() {
        var chatBox = document.getElementById("chatbox");
        localStorage.setItem("chatHistory", chatBox.innerHTML);
    }

    function loadChatHistory() {
        var chatHistory = localStorage.getItem("chatHistory");
        if (chatHistory) {
            var chatBox = document.getElementById("chatbox");
            chatBox.innerHTML = chatHistory;
        }
    }

    function clearChatHistory() {
        localStorage.removeItem("chatHistory");
    }

    // Muat riwayat obrolan saat halaman dimuat
    loadChatHistory();
});
