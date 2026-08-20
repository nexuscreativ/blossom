<?php
    $chatName = setting('site.site.name', 'BLOSSOM');
?>


<div id="blossom-chat" class="blossom-chat-root">
    <style>
        #blossom-chat { --chat-onion:#14532d; --chat-orange:#ea580c; --chat-ink:#1c1917; --chat-muted:#78716c; --chat-bubble-bot:#f5f5f4; --chat-bubble-user:#14532d; }
        .blossom-chat-root * { box-sizing:border-box; margin:0; padding:0; }
        .blossom-chat-fab {
            position:fixed; bottom:24px; right:24px; z-index:9990;
            width:60px; height:60px; border-radius:50%; border:0; cursor:pointer;
            background:var(--chat-onion); color:#fff; box-shadow:0 8px 24px rgba(20,83,45,.35);
            display:flex; align-items:center; justify-content:center; transition:transform .2s ease;
        }
        .blossom-chat-fab:hover { transform:scale(1.06); }
        .blossom-chat-fab svg { width:28px; height:28px; }
        .blossom-chat-fab .badge {
            position:absolute; top:-2px; right:-2px; min-width:20px; height:20px; padding:0 5px;
            border-radius:10px; background:#dc2626; color:#fff; font-size:11px; font-weight:700;
            display:none; align-items:center; justify-content:center; font-family:Inter,system-ui,sans-serif;
        }
        .blossom-chat-window {
            position:fixed; bottom:96px; right:24px; z-index:9991; width:min(380px,calc(100vw - 32px));
            height:min(560px,calc(100vh - 140px)); display:none; flex-direction:column; overflow:hidden;
            background:#fff; border-radius:16px; box-shadow:0 20px 60px rgba(28,25,23,.18);
            border:1px solid #e7e5e4; font-family:Inter,system-ui,-apple-system,sans-serif;
        }
        .blossom-chat-window.open { display:flex; }
        .blossom-chat-head {
            background:linear-gradient(135deg,var(--chat-onion),#166534); color:#fff; padding:16px 18px;
            display:flex; align-items:center; gap:12px;
        }
        .blossom-chat-head .avatar {
            width:40px; height:40px; border-radius:50%; background:rgba(255,255,255,.15);
            display:flex; align-items:center; justify-content:center; font-size:18px;
        }
        .blossom-chat-head .meta { flex:1; }
        .blossom-chat-head .name { font-weight:700; font-size:15px; }
        .blossom-chat-head .status { font-size:12px; opacity:.85; display:flex; align-items:center; gap:5px; }
        .blossom-chat-head .status::before { content:''; width:7px; height:7px; border-radius:50%; background:#4ade80; display:inline-block; }
        .blossom-chat-close {
            background:rgba(255,255,255,.15); border:0; color:#fff; width:30px; height:30px; border-radius:8px;
            cursor:pointer; font-size:15px; display:flex; align-items:center; justify-content:center;
        }
        .blossom-chat-body { flex:1; overflow-y:auto; padding:16px; background:#fafaf9; }
        .blossom-chat-msg { margin-bottom:12px; max-width:82%; clear:both; }
        .blossom-chat-msg .bubble { padding:10px 14px; border-radius:14px; font-size:14px; line-height:1.5; word-wrap:break-word; }
        .blossom-chat-msg.bot .bubble { background:var(--chat-bubble-bot); color:var(--chat-ink); border:1px solid #e7e5e4; border-top-left-radius:4px; float:left; }
        .blossom-chat-msg.user .bubble { background:var(--chat-bubble-user); color:#fff; border-top-right-radius:4px; float:right; }
        .blossom-chat-msg.agent .bubble { background:#fef3c7; color:#92400e; border:1px solid #fde68a; border-top-left-radius:4px; float:left; }
        .blossom-chat-msg .time { font-size:10px; color:var(--chat-muted); margin-top:4px; }
        .blossom-chat-msg.user .time { text-align:right; }
        .blossom-chat-escalate {
            text-align:center; font-size:12px; color:#92400e; background:#fffbeb; border:1px solid #fde68a;
            border-radius:10px; padding:8px 12px; margin-bottom:12px;
        }
        .blossom-chat-form { border-top:1px solid #e7e5e4; padding:12px; background:#fff; display:flex; gap:8px; align-items:flex-end; }
        .blossom-chat-form textarea {
            flex:1; resize:none; border:1px solid #e7e5e4; border-radius:10px; padding:10px 12px;
            font-size:14px; font-family:inherit; outline:none; max-height:90px;
        }
        .blossom-chat-form textarea:focus { border-color:var(--chat-onion); }
        .blossom-chat-send {
            background:var(--chat-onion); color:#fff; border:0; border-radius:10px; width:42px; height:42px;
            cursor:pointer; display:flex; align-items:center; justify-content:center;
        }
        .blossom-chat-send svg { width:20px; height:20px; }
        .blossom-chat-send:disabled { opacity:.5; cursor:not-allowed; }
        .blossom-chat-form .hint { font-size:11px; color:var(--chat-muted); position:absolute; bottom:0; }
        .blossom-chat-typing { font-size:12px; color:var(--chat-muted); font-style:italic; padding:4px 0; }
        @media (max-width:480px) { .blossom-chat-window { right:16px; bottom:88px; } }
    </style>

    <button class="blossom-chat-fab" id="blossom-chat-fab" aria-label="Open support chat" title="Chat with us">
        <span class="badge" id="blossom-chat-badge">1</span>
        <svg id="blossom-chat-icon-open" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
        <svg id="blossom-chat-icon-close" style="display:none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>

    <div class="blossom-chat-window" id="blossom-chat-window">
        <div class="blossom-chat-head">
            <div class="avatar">💬</div>
            <div class="meta">
                <div class="name"><?php echo e($chatName); ?> Support</div>
                <div class="status">Online — replies instantly</div>
            </div>
            <button class="blossom-chat-close" id="blossom-chat-close" aria-label="Close chat">✕</button>
        </div>
        <div class="blossom-chat-body" id="blossom-chat-body"></div>
        <form class="blossom-chat-form" id="blossom-chat-form">
            <textarea id="blossom-chat-input" placeholder="Type your message…" rows="1" maxlength="2000"></textarea>
            <button type="submit" class="blossom-chat-send" id="blossom-chat-send" aria-label="Send">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </button>
        </form>
    </div>

    <script>
        (function () {
            const fab = document.getElementById('blossom-chat-fab');
            const windowEl = document.getElementById('blossom-chat-window');
            const closeBtn = document.getElementById('blossom-chat-close');
            const body = document.getElementById('blossom-chat-body');
            const form = document.getElementById('blossom-chat-form');
            const input = document.getElementById('blossom-chat-input');
            const sendBtn = document.getElementById('blossom-chat-send');
            const badge = document.getElementById('blossom-chat-badge');

            let session = null;
            let conversationId = null;
            let escalated = false;
            let opened = false;

            const CSRF = document.querySelector('meta[name="csrf-token"]')?.content
                || (window.Laravel && window.Laravel.csrfToken) || '';

            function api(url, data) {
                return fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(data),
                    credentials: 'same-origin',
                }).then(r => r.json());
            }

            function addMessage(role, text, time) {
                const wrap = document.createElement('div');
                wrap.className = 'blossom-chat-msg ' + (role === 'user' ? 'user' : (role === 'agent' ? 'agent' : 'bot'));
                const bubble = document.createElement('div');
                bubble.className = 'bubble';
                bubble.textContent = text;
                wrap.appendChild(bubble);
                if (time) {
                    const t = document.createElement('div');
                    t.className = 'time';
                    t.textContent = time;
                    wrap.appendChild(t);
                }
                body.appendChild(wrap);
                body.scrollTop = body.scrollHeight;
            }

            function showTyping() {
                const div = document.createElement('div');
                div.className = 'blossom-chat-typing';
                div.id = 'blossom-chat-typing';
                div.textContent = '…';
                body.appendChild(div);
                body.scrollTop = body.scrollHeight;
            }

            function hideTyping() {
                const el = document.getElementById('blossom-chat-typing');
                if (el) el.remove();
            }

            function setEscalated(flag) {
                escalated = flag;
                const existing = document.querySelector('.blossom-chat-escalate');
                if (existing) existing.remove();
                if (flag) {
                    const note = document.createElement('div');
                    note.className = 'blossom-chat-escalate';
                    note.textContent = '👤 A human agent has been notified and will join this chat shortly.';
                    body.insertBefore(note, body.firstChild);
                }
            }

            function autoResize() {
                input.style.height = 'auto';
                input.style.height = Math.min(input.scrollHeight, 90) + 'px';
            }

            function loadSession() {
                fetch('<?php echo e(route("chat.session")); ?>', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
                    .then(r => r.json())
                    .then(d => {
                        session = d.session;
                        conversationId = d.conversation_id;
                        setEscalated(!!d.escalated);
                        if (d.messages && d.messages.length) {
                            d.messages.forEach(m => {
                                if (m.role !== 'system') addMessage(m.role, m.body, new Date(m.at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
                            });
                        } else {
                            addMessage('bot', d.welcome);
                        }
                    });
            }

            fab.addEventListener('click', () => {
                opened = !opened;
                windowEl.classList.toggle('open', opened);
                document.getElementById('blossom-chat-icon-open').style.display = opened ? 'none' : '';
                document.getElementById('blossom-chat-icon-close').style.display = opened ? '' : 'none';
                badge.style.display = 'none';
                if (opened) {
                    if (!session) loadSession();
                    setTimeout(() => input.focus(), 150);
                }
            });

            closeBtn.addEventListener('click', () => {
                windowEl.classList.remove('open');
                opened = false;
                document.getElementById('blossom-chat-icon-open').style.display = '';
                document.getElementById('blossom-chat-icon-close').style.display = 'none';
            });

            input.addEventListener('input', autoResize);
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    form.requestSubmit();
                }
            });

            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const text = input.value.trim();
                if (!text) return;

                addMessage('user', text, new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
                input.value = '';
                autoResize();
                sendBtn.disabled = true;
                showTyping();

                api('<?php echo e(route("chat.send")); ?>', {
                    message: text,
                    session: session,
                    conversation_id: conversationId,
                }).then(d => {
                    sendBtn.disabled = false;
                    hideTyping();
                    session = d.session;
                    conversationId = d.conversation_id;
                    setEscalated(!!d.escalated);
                    if (d.reply) addMessage(d.reply ? 'bot' : 'bot', d.reply, new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
                }).catch(() => {
                    sendBtn.disabled = false;
                    hideTyping();
                    addMessage('bot', 'Sorry, something went wrong. Please try again.');
                });
            });
        })();
    </script>
</div><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/layouts/components/chat-widget.blade.php ENDPATH**/ ?>