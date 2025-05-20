document.addEventListener("DOMContentLoaded", function () {
    const chatBox = document.getElementById("ai-messages");
    const input = document.getElementById("ai-user-input");
    const sendBtn = document.getElementById("ai-send-btn");

    function appendMessage(sender, text) {
        const msg = document.createElement("div");
        msg.innerHTML = `<strong>${sender}:</strong> ${text}`;
        msg.style.marginBottom = "10px";
        chatBox.appendChild(msg);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function sendMessage(msg) {
        appendMessage("You", msg);
        input.value = "";

        fetch(aiChatData.ajax_url, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                action: "ai_assistant_send",
                message: msg,
            }),
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    appendMessage("Assistant", data.data);
                } else {
                    appendMessage("Error", "AI did not respond.");
                }
            });
    }

    // Initial greeting on first visit
    if (!sessionStorage.getItem("ai_assistant_greeted")) {
        appendMessage("Assistant", aiChatData.start_message);
        sessionStorage.setItem("ai_assistant_greeted", "true");
    }

    sendBtn.addEventListener("click", () => {
        if (input.value.trim() !== "") {
            sendMessage(input.value.trim());
        }
    });

    input.addEventListener("keypress", function (e) {
        if (e.key === "Enter") sendBtn.click();
    });
});


