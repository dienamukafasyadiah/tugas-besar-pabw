<?php 
session_start();
include 'koneksi.php'; 

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username']; // Ambil username dari sesi
$status = $_SESSION['status'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlowRX Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../Logo/logo.png"/>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.36.1/collect.min.js" integrity="sha512-aub0tRfsNTyfYpvUs0e9G/QRsIDgKmm4x59WRkHeWUc3CXbdiMwiMQ5tTSElshZu2LCq8piM/cbIsNwuuIR4gA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <style>
        #voiceButton {
            background-color: #ffffff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 0 10px 10px 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }

        #voiceButton:hover {
            background-color: #ddd;
        }

        .watermark {
            position: absolute;
            top: 55%;
            left: 55%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            font-size: 100px;
            color: #000;
            pointer-events: none;
        }
    </style>
    <script>
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

        function startVoiceRecognition() {
            if ('webkitSpeechRecognition' in window) {
                var recognition = new webkitSpeechRecognition();
                recognition.lang = "id-ID";
                recognition.continuous = false;
                recognition.interimResults = false;

                recognition.onstart = function() {
                    console.log("Voice recognition started. Try speaking into the microphone.");
                };

                recognition.onspeechend = function() {
                    console.log("You were quiet for a while so voice recognition turned itself off.");
                    recognition.stop();
                };

                recognition.onerror = function(event) {
                    if(event.error === 'no-speech') {
                        console.log("No speech was detected. Try again.");
                    }
                };

                recognition.onresult = function(event) {
                    var transcript = event.results[0][0].transcript;
                    document.getElementById('message').value = transcript;
                };

                recognition.start();
            } else {
                console.log("Your browser does not support speech recognition.");
            }
        }

        window.onload = function() {
            loadChatHistory();
        };
    </script>
</head>
<body>

    <div class="page">
    
        <div class="sidebar">
        <div id="particles-js"></div>
            <div class="logo">
            
                <img src="../img/logo.png" alt="">
                <span>GlowRX</span>
            </div>
            
            <div class="menu">
                <div><a class="sidebar-item" href="homepage.php"><i class='bx bxs-dashboard'></i>Dashboard</a></div>
                <div><a class="sidebar-item" href="analytic.php"><i class='bx bx-bar-chart-alt-2'></i>Analytics</a></div>
                <div><a class="sidebar-item" href="produk.php"><i class='bx bx-store-alt'></i>Product</a></div>
                <div><a class="sidebar-item" href="ai.php"><i class='bx bx-bulb'></i>Recommendation AI</a></div>
                <div><a class="sidebar-item" href="riwayat.php"><i class='bx bx-history'></i>History</a></div>
                <div><a class="sidebar-item" href="report.php"><i class='bx bx-bar-chart-alt'></i>Report</a></div>
                <div><a class="sidebar-item" href="../index.php" onclick="clearChatHistory()"><i class='bx bxs-log-out'></i>Logout</a></div>
            </div>

            <div class="user-info">
                <img src="../img/manager.jpg" alt="User">
                <div>
                    <span><?php echo htmlspecialchars($username); ?></span><br>
                    <span><?php echo htmlspecialchars($status); ?></span>
                </div>
            </div>
        </div>
        <div class="main-content">
            
            <header>
                <h1>ChatBot GlowRX</h1>
                <a class="nav-button" href="rekomendasi.php">Rekomendasi</a>
            </header>
            <div class="chatbot">
            <div id="chatbox" class="chat-box">
            <div class="watermark"><img src="../img/logo.png" alt=""></div>
            </div>
                    <form id="chatForm">
                        <label for="message"></label><br>
                            <input type="text" id="message" name="message" placeholder="Masukkan pesan..." >
                            <button type="button" id="voiceButton" class="voice-button" onclick="startVoiceRecognition()">🎤</button>
                            <button class="nav-button" type="submit">Kirim</button>
                    </form>
            </div>
        </div>
    </div>
    <script src="../js/chatbot.js"></script>
    <script type="text/javascript" src="../js/particles.js"></script>
    <script type="text/javascript" src="../js/app.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>