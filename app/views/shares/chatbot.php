<style>
    /* Chatbot Container */
    #chatbot-container {
        position: fixed;
        bottom: 90px;
        right: 30px;
        width: 380px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        z-index: 1000;
        display: none;
        overflow: hidden;
        font-family: 'Segoe UI', Roboto, sans-serif;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.3s ease;
        
    }
    
    #chatbot-container.visible {
        transform: translateY(0);
        opacity: 1;
    }
    
    /* Chatbot Header */
    .chatbot-header {
        padding: 16px 20px;
        background: linear-gradient(135deg, #000000, #333333);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .chatbot-header h6 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .chatbot-header h6 i {
        margin-right: 10px;
        font-size: 18px;
    }
    
    #close-chatbot {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    #close-chatbot:hover {
        background: rgba(255,255,255,0.3);
    }
    
    /* Chatbot Messages */
    #chatbot-messages {
        height: 350px;
        overflow-y: auto;
        padding: 20px;
        background: #f9f9f9;
    }
    
    /* Message Bubbles */
    .message {
        margin-bottom: 16px;
        max-width: 80%;
        word-wrap: break-word;
        animation: fadeIn 0.3s ease-out;
    }
    
    .user-message {
        margin-left: auto;
        background: #000;
        color: white;
        padding: 12px 16px;
        border-radius: 18px 18px 4px 18px;
    }
    
    .bot-message {
        margin-right: auto;
        background: white;
        padding: 12px 16px;
        border-radius: 18px 18px 18px 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    /* Quick Reply Options */
    .quick-replies {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }
    
    .quick-reply {
        background: #f0f0f0;
        border: none;
        border-radius: 16px;
        padding: 8px 12px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .quick-reply:hover {
        background: #e0e0e0;
    }
    
    /* Chatbot Input */
    .chatbot-input {
        padding: 16px;
        border-top: 1px solid #eee;
        display: flex;
        background: white;
    }
    
    #user-input {
        flex: 1;
        padding: 12px 16px;
        border: 1px solid #ddd;
        border-radius: 24px;
        font-size: 14px;
        transition: border 0.2s;
    }
    
    #user-input:focus {
        outline: none;
        border-color: #000;
    }
    
    #send-btn {
        margin-left: 10px;
        width: 48px;
        height: 48px;
        background: #000;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    #send-btn:hover {
        background: #333;
    }
    
    /* Chatbot Toggle Button */
    #chatbot-toggle {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: linear-gradient(135deg, #000000, #333333);
        color: white;
        border: none;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        cursor: pointer;
        z-index: 999;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        display: flex;
        justify-content: center;
        align-items: center;
        transition: all 0.3s;
    }
    
    #chatbot-toggle:hover {
        transform: scale(1.1);
    }
    
    #chatbot-toggle i {
        font-size: 24px;
    }
    
    /* Typing Indicator */
    .typing-indicator {
        display: flex;
        padding: 12px 16px;
        background: white;
        border-radius: 18px 18px 18px 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        width: fit-content;
        margin-bottom: 16px;
    }
    
    .typing-dot {
        width: 8px;
        height: 8px;
        background: #ccc;
        border-radius: 50%;
        margin: 0 2px;
        animation: typingAnimation 1.4s infinite ease-in-out;
    }
    
    .typing-dot:nth-child(1) {
        animation-delay: 0s;
    }
    
    .typing-dot:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .typing-dot:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes typingAnimation {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-5px); }
    }

    .product-suggestion {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
    }
    .product-suggestion img {
        max-width: 100px;
        max-height: 100px;
    }
    .product-suggestion a {
        color: #007bff;
        text-decoration: none;
    }
</style>

<!-- Chatbot UI -->
<div id="chatbot-container">
    <div class="chatbot-header">
        <h6><i class="fas fa-robot"></i> Droppy CSKH</h6>
        <button id="close-chatbot" title="Close">×</button>
    </div>
    <div id="chatbot-messages">
        <!-- Initial greeting message -->
        <div class="message bot-message">
            Xin chào! Tôi là trợ lý ảo Droppy. Tôi có thể giúp gì cho bạn hôm nay?
            <div class="quick-replies">
                <button class="quick-reply" data-reply="Giờ mở cửa">Giờ mở cửa</button>
                <button class="quick-reply" data-reply="Địa chỉ cửa hàng">Địa chỉ cửa hàng</button>
                <button class="quick-reply" data-reply="Liên hệ hỗ trợ">Liên hệ hỗ trợ</button>
            </div>
        </div>
    </div>
    <div class="chatbot-input">
        <input type="text" id="user-input" placeholder="Nhập câu hỏi của bạn..." autocomplete="off">
        <button id="send-btn" title="Send"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<!-- Chatbot Toggle Button -->
<button id="chatbot-toggle" title="Chat with Droppy">
    <i class="fas fa-comment-dots"></i>
</button>

<script>


function handleUserInput(message) {
        displayMessage(message, 'user');

        // Gửi yêu cầu AJAX đến server
        fetch('/webdr/chatbot/process', { // Thay đổi đường dẫn nếu cần
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'message=' + encodeURIComponent(message)
        })
        .then(response => response.json())
        .then(data => {
            displayBotResponse(data);
        })
        .catch(error => {
            console.error('Lỗi:', error);
            displayMessage("Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau.", 'bot');
        });
    }

    function displayBotResponse(data) {
    let responseText = data.text;
    let productsHTML = '';
    let productDetailHTML = '';

    if (data.products && data.products.length > 0) {
        productsHTML = '<p>Chúng tôi tìm thấy các sản phẩm sau:</p>';
        data.products.forEach(product => {
            productsHTML += `
                <div class="product-suggestion">
                    <img src="${product.product_image}" alt="${product.product_name}">
                    <a href="${product.product_link}">${product.product_name}</a>
                    <p>Giá: ${product.product_price}</p>
                </div>
            `;
        });
    }

    if (data.product) {
        productDetailHTML = `
            <div class="product-detail">
                <h3>${data.product.product_name}</h3>
                <img src="${data.product.product_image}" alt="${data.product.product_name}">
                <p>Giá: ${data.product.product_price}</p>
                <p>${data.product.product_desc}</p>
                <a href="${data.product.product_link}">Xem chi tiết</a>
            </div>
        `;
    }

    displayMessage(responseText + productsHTML + productDetailHTML, 'bot');
}
// Chatbot functionality
document.addEventListener('DOMContentLoaded', function() {
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotContainer = document.getElementById('chatbot-container');
    const closeChatbot = document.getElementById('close-chatbot');
    const messagesDiv = document.getElementById('chatbot-messages');
    const userInput = document.getElementById('user-input');
    const sendBtn = document.getElementById('send-btn');
    
    // Show/hide chatbot with animation
    chatbotToggle.addEventListener('click', function() {
        chatbotContainer.style.display = 'block';
        setTimeout(() => {
            chatbotContainer.classList.add('visible');
            userInput.focus();
        }, 10);
    });
    
    closeChatbot.addEventListener('click', function() {
        chatbotContainer.classList.remove('visible');
        setTimeout(() => {
            chatbotContainer.style.display = 'none';
        }, 300);
    });
    
    // Send message on button click or Enter key
    sendBtn.addEventListener('click', sendMessage);
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') sendMessage();
    });
    
    // Quick reply buttons
    document.querySelectorAll('.quick-reply').forEach(button => {
        button.addEventListener('click', function() {
            const replyText = this.getAttribute('data-reply');
            userInput.value = replyText;
            sendMessage();
        });
    });
    
    function sendMessage() {
        const message = userInput.value.trim();
        if (!message) return;
        
        // Add user message
        appendMessage('user', message);
        userInput.value = '';
        
        // Show typing indicator
        showTypingIndicator();
        
        // Simulate bot thinking time
        setTimeout(() => {
            // Remove typing indicator
            const typingIndicator = document.querySelector('.typing-indicator');
            if (typingIndicator) typingIndicator.remove();
            
            // Get and display bot response
            const botResponse = getBotResponse(message);
            appendMessage('bot', botResponse.text);
            
            // Add quick replies if available
            if (botResponse.quickReplies) {
                const quickRepliesDiv = document.createElement('div');
                quickRepliesDiv.className = 'quick-replies';
                
                botResponse.quickReplies.forEach(reply => {
                    const button = document.createElement('button');
                    button.className = 'quick-reply';
                    button.setAttribute('data-reply', reply);
                    button.textContent = reply;
                    button.addEventListener('click', function() {
                        userInput.value = reply;
                        sendMessage();
                    });
                    quickRepliesDiv.appendChild(button);
                });
                
                // Find the last bot message and append quick replies
                const botMessages = document.querySelectorAll('.bot-message');
                if (botMessages.length > 0) {
                    botMessages[botMessages.length - 1].appendChild(quickRepliesDiv);
                }
            }
            
            // Scroll to bottom
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }, 1000 + Math.random() * 1000); // Random delay between 1-2 seconds
    }
    
    function appendMessage(sender, text) {
        const messageElement = document.createElement('div');
        messageElement.className = `message ${sender}-message`;
        messageElement.textContent = text;
        messagesDiv.appendChild(messageElement);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
    
    function showTypingIndicator() {
        const typingElement = document.createElement('div');
        typingElement.className = 'typing-indicator';
        typingElement.innerHTML = `
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        `;
        messagesDiv.appendChild(typingElement);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
    
    // Enhanced bot responses with quick replies
    function getBotResponse(userMessage) {
        const lowerMsg = userMessage.toLowerCase();
        
        if (lowerMsg.includes('xin chào') || lowerMsg.includes('hello') || lowerMsg.includes('hi')) {
            return {
                text: "Xin chào! Tôi là trợ lý ảo Droppy. Bạn cần hỗ trợ gì ạ?",
                quickReplies: ["Giờ mở cửa", "Địa chỉ cửa hàng", "Tôi muốn đặt hàng"]
            };
        } else if (lowerMsg.includes('giờ mở cửa') || lowerMsg.includes('mấy giờ mở cửa')) {
            return {
                text: "Cửa hàng mở từ 8:00 - 22:00 hàng ngày. Bạn có thể đến bất kỳ lúc nào trong khung giờ này!",
                quickReplies: ["Địa chỉ cửa hàng", "Liên hệ hỗ trợ", "Sản phẩm bán chạy"]
            };
        } else if (lowerMsg.includes('địa chỉ') || lowerMsg.includes('ở đâu')) {
            return {
                text: "Cửa hàng chúng tôi tại 123 Đường Bida, Quận 1, TP. HCM. Bạn có thể xem bản đồ trên website hoặc gọi 0965 306 692 để được hướng dẫn.",
                quickReplies: ["Giờ mở cửa", "Gửi tôi bản đồ", "Có chỗ đậu xe không?"]
            };
        } else if (lowerMsg.includes('liên hệ') || lowerMsg.includes('support') || lowerMsg.includes('hotline')) {
            return {
                text: "Bạn có thể liên hệ với chúng tôi qua:\n- Email: support@droppy.vn\n- Hotline: (+84) 965 306 692\n- Facebook: fb.com/droppy.vn\nChúng tôi luôn sẵn sàng hỗ trợ bạn!",
                quickReplies: ["Giờ mở cửa", "Khiếu nại dịch vụ", "Hỏi về đơn hàng"]
            };
        } else if (lowerMsg.includes('đặt hàng') || lowerMsg.includes('mua hàng')) {
            return {
                text: "Bạn có thể đặt hàng trực tiếp tại cửa hàng hoặc qua website droppy.vn. Chúng tôi có dịch vụ giao hàng tận nơi trong nội thành TP.HCM.",
                quickReplies: ["Phí giao hàng bao nhiêu?", "Thời gian giao hàng", "Xem sản phẩm"]
            };
        } else {
            return {
                text: "Tôi chưa hiểu rõ câu hỏi của bạn. Bạn có thể:\n1. Liên hệ hotline 0965 306 692\n2. Đến trực tiếp cửa hàng\n3. Sử dụng form liên hệ trên website\nTôi rất tiếc vì chưa thể giúp bạn ngay bây giờ.",
                quickReplies: ["Giờ mở cửa", "Địa chỉ cửa hàng", "Liên hệ hỗ trợ"]
            };
        }
    }
});
</script>