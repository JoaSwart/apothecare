<template>
  <div class="chat-widget">
    <button id="chat-toggle-btn" @click="toggleChatbox">
      <i class="fa-regular fa-comment"></i>
    </button>

    <div class="chatbox" :class="{ active: isChatboxActive }">
      <div class="chatbox-messages" ref="messagesContainer">
        <div
          v-for="(msg, index) in messages"
          :key="index"
          class="message-bubble"
          :class="msg.sender"
        >
          {{ msg.text }}
        </div>
      </div>

      <div class="chatbox-input-area">
        <input
          type="text"
          v-model="userInput"
          @keyup.enter="sendMessage"
          placeholder="Typ uw vraag..."
        >
        <button class="send-btn" @click="sendMessage">
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, nextTick } from 'vue';

const isChatboxActive = ref(false);
const userInput = ref('');
const messages = ref([
  { sender: 'ai', text: 'Hallo! Ik ben uw AI-assistent van Apothecare. Hoe kan ik u helpen?' }
]);
const messagesContainer = ref(null);

const toggleChatbox = () => {
  isChatboxActive.value = !isChatboxActive.value;
  if (isChatboxActive.value) scrollToBottom();
};

// Update this to the moved PHP endpoint
const API_ENDPOINT = 'http://localhost/Projectweek%20october/apothecare/apothecare_with-vue/api/chat.php';

const scrollToBottom = async () => {
  await nextTick();
  const el = messagesContainer.value;
  if (el) el.scrollTop = el.scrollHeight;
};

const sendMessage = async () => {
  const text = userInput.value.trim();
  if (!text) return;

  messages.value.push({ sender: 'you', text });
  userInput.value = '';
  scrollToBottom();

  // temporary typing bubble
  const typingIndex = messages.value.push({ sender: 'ai', text: '...' }) - 1;
  scrollToBottom();

  const formData = new FormData();
  formData.append('vraag', text);

  try {
    const response = await fetch(API_ENDPOINT, {
      method: 'POST',
      body: formData
    });

    if (!response.ok) {
      messages.value[typingIndex] = { sender: 'ai', text: `Server error: ${response.status}` };
      scrollToBottom();
      return;
    }

    const data = await response.json();

    if (data.antwoord) {
      messages.value[typingIndex] = { sender: 'ai', text: data.antwoord };
    } else if (data.error) {
      messages.value[typingIndex] = { sender: 'ai', text: `Error: ${data.error}` };
    } else {
      messages.value[typingIndex] = { sender: 'ai', text: 'Geen antwoord ontvangen.' };
    }
    scrollToBottom();
  } catch (err) {
    messages.value[typingIndex] = { sender: 'ai', text: `Fetch error: ${err.message}` };
    scrollToBottom();
  }
};
</script>

<style>
.message-bubble.you { background: #d9fdd3; text-align: right; }
.message-bubble.ai  { background: #eeeeee; }
.chatbox.active { display: block; }
</style>

<style scoped>
.chat-widget {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 1000;
}

#chat-toggle-btn {
    width: 60px;
    height: 60px;
    background-color: #5a8b5e;
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    transition: background-color 0.3s, transform 0.3s;
}

#chat-toggle-btn:hover {
    background-color: #4a754e;
    transform: scale(1.1);
}

.chatbox {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 350px;
    height: 450px;
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    visibility: hidden;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.3s, transform 0.3s, visibility 0.3s;
}

.chatbox.active {
    visibility: visible;
    opacity: 1;
    transform: translateY(0);
}

.chatbox-messages {
    flex-grow: 1;
    padding: 20px;
    overflow-y: auto;
    background-color: #f4f6f5;
}

.message-bubble {
    background-color: #e9ecef;
    padding: 10px 15px;
    border-radius: 18px;
    max-width: 80%;
    line-height: 1.4;
    font-size: 14px;
    color: #343a40;
}

.chatbox-input-area {
    display: flex;
    padding: 10px;
    border-top: 1px solid #e0e0e0;
    background-color: #fff;
}

.chatbox-input-area input {
    flex-grow: 1;
    border: none;
    outline: none;
    padding: 10px;
    font-size: 14px;
    font-family: 'Poppins', sans-serif;
    background-color: transparent;
}

.chatbox-input-area .send-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: #5a8b5e;
    font-size: 18px;
    padding: 10px;
    transition: color 0.3s;
}

.chatbox-input-area .send-btn:hover {
    color: #4a754e;
}
</style>
