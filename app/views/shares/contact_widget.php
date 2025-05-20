<div class="chat-container">
  <!-- Nút chat ban đầu -->
  <div class="chat-button">
    <img src="http://localhost/webdr/uploads/messenger.png" alt="Chat Icon" class="chat-icon" />
  
    <span class="close-chat">×</span>
  </div>

  <!-- Thanh công cụ nổi (ẩn ban đầu) -->
  <div class="floating-toolbar hidden">
    <div class="toolbar-item">
      <a href="https://m.me/martin.tri.395" target="_blank">
        <img src="http://localhost/webdr/uploads/messenger.png" alt="Messenger" />
      </a>
    </div>
    <div class="toolbar-item">
      <a href="https://zalo.me/0965306692" target="_blank">
        <img src="http://localhost/webdr/uploads/zaloo.png" alt="Zalo" />
      </a>
    </div>
    <div class="toolbar-item">
      <a href="tel:+0965306692">
        <img src="http://localhost/webdr/uploads/callll.jpg" alt="Call" />
      </a>
    </div>
    <div class="toolbar-item close-btn">
      <span>×</span>
    </div>
  </div>
</div>

<style>
  .chat-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
  }

  .chat-button {
    display: flex;
    align-items: center;
    background-color: #fff;
    border-radius: 25px;
    padding: 10px 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    max-width: 300px;
    
    
  }

  .chat-button .chat-icon {
    width: 30px;
    height: 30px;
    margin-right: 10px;
    
  }

  .chat-button span {
    font-size: 14px;
    color: #333;
    line-height: 1.2;
  }

  .chat-button .close-chat {
    margin-left: 10px;
    font-size: 18px;
    color: #999;
  }

  .floating-toolbar {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 10px;
  }

  .floating-toolbar.hidden {
    display: none;
  }

  .toolbar-item {
    width: 50px;
    height: 50px;
    background-color: #fff;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    cursor: pointer;
  }

  .toolbar-item img {
    width: 30px;
    height: 30px;
  }

  .toolbar-item.close-btn {
    background-color: #ccc;
    color: #fff;
    font-size: 20px;
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    console.log("JavaScript is running!");
    const chatButton = document.querySelector(".chat-button");
    const floatingToolbar = document.querySelector(".floating-toolbar");
    const closeChat = document.querySelector(".close-chat");
    const closeBtn = document.querySelector(".close-btn");

    if (!chatButton || !floatingToolbar || !closeChat || !closeBtn) {
      console.error("One or more elements not found!");
      return;
    }

    chatButton.addEventListener("click", () => {
      console.log("Chat button clicked!");
      chatButton.style.display = "none";
      floatingToolbar.classList.remove("hidden");
    });

    closeChat.addEventListener("click", (e) => {
      e.stopPropagation();
      console.log("Close chat clicked!");
      chatButton.style.display = "none";
      floatingToolbar.classList.add("hidden");
    });

    closeBtn.addEventListener("click", () => {
      console.log("Close toolbar clicked!");
      floatingToolbar.classList.add("hidden");
      chatButton.style.display = "flex";
    });
  });
</script>
