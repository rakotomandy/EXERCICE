<?php $displayName = htmlspecialchars($_SESSION['username'] ?? 'there', ENT_QUOTES, 'UTF-8'); ?>

<div class="chat-shell">
    <aside class="chat-sidebar">
        <div class="sidebar-heading">
            <div>
                <p class="eyebrow">Your space</p>
                <h1>Messages</h1>
            </div>
            <button class="icon-button" type="button" aria-label="Start a new message" title="New message">+</button>
        </div>

        <label class="search-box" for="conversation-search">
            <span aria-hidden="true">⌕</span>
            <input id="conversation-search" type="search" placeholder="Search conversations">
            <kbd>/</kbd>
        </label>

        <div class="conversation-list" role="list" aria-label="Conversations">
            <p class="list-label">Recent</p>
            <a class="conversation active" href="#conversation-maya" role="listitem">
                <span class="avatar avatar-coral">MC</span>
                <span class="conversation-copy">
                    <strong>Maya Chen</strong>
                    <small>That sounds perfect, thank you!</small>
                </span>
                <time datetime="2026-09-11T09:42">9:42</time>
            </a>
            <a class="conversation" href="#conversation-noah" role="listitem">
                <span class="avatar avatar-sage">NW</span>
                <span class="conversation-copy">
                    <strong>Noah Williams</strong>
                    <small>Are we still on for tomorrow?</small>
                </span>
                <time datetime="2026-09-10T16:18">Yesterday</time>
            </a>
            <a class="conversation" href="#conversation-lena" role="listitem">
                <span class="avatar avatar-lilac">LP</span>
                <span class="conversation-copy">
                    <strong>Lena Park</strong>
                    <small>Sent an attachment</small>
                </span>
                <time datetime="2026-09-09T11:05">Wed</time>
            </a>
        </div>

        <div class="sidebar-footer">
            <a href="#settings"><span aria-hidden="true">⚙</span> Settings</a>
            <a href="#help"><span aria-hidden="true">?</span> Help center</a>
        </div>
    </aside>

    <main class="chat-main" id="conversation-maya">
        <header class="chat-header">
            <div class="chat-contact">
                <span class="avatar avatar-coral">MC</span>
                <div>
                    <h2>Maya Chen</h2>
                    <p><span class="status-dot"></span> Online</p>
                </div>
            </div>
            <div class="chat-actions">
                <button class="icon-button subtle" type="button" aria-label="Start voice call" title="Voice call">◔</button>
                <button class="icon-button subtle" type="button" aria-label="Start video call" title="Video call">▣</button>
                <button class="icon-button subtle" type="button" aria-label="More conversation options" title="More options">•••</button>
            </div>
        </header>

        <div class="message-area">
            <div class="day-divider"><span>Today</span></div>
            <p class="conversation-intro">This is the beginning of your conversation with Maya.</p>

            <div class="message-row received">
                <span class="avatar avatar-coral small">MC</span>
                <div class="message-stack">
                    <span class="message-name">Maya Chen <time>09:38</time></span>
                    <div class="message-bubble">Hey! I just looked through the latest notes.</div>
                    <div class="message-bubble">The direction is feeling really strong. I especially like the way the story is coming together.</div>
                </div>
            </div>
            <div class="message-row sent">
                <div class="message-stack">
                    <span class="message-name">You <time>09:40</time></span>
                    <div class="message-bubble">That makes me so happy to hear. I tightened up the final section this morning.</div>
                </div>
            </div>
            <div class="message-row received">
                <span class="avatar avatar-coral small">MC</span>
                <div class="message-stack">
                    <span class="message-name">Maya Chen <time>09:42</time></span>
                    <div class="message-bubble">That sounds perfect, thank you!</div>
                </div>
            </div>
        </div>

        <form class="composer" action="#" method="post">
            <button class="composer-button" type="button" aria-label="Attach a file" title="Attach file">＋</button>
            <input type="text" name="message" placeholder="Write a message..." aria-label="Message text">
            <button class="send-button" type="submit" aria-label="Send message" title="Send message">➜</button>
        </form>
    </main>

    <aside class="profile-panel">
        <div class="profile-topline"><span>Contact details</span><button class="close-button" type="button" aria-label="Close contact details">×</button></div>
        <span class="avatar avatar-coral profile-avatar">MC</span>
        <h2>Maya Chen</h2>
        <p class="profile-handle">@mayac.design</p>
        <span class="profile-status"><span class="status-dot"></span> Available</span>
        <div class="profile-links">
            <a href="mailto:maya@example.com"><span>✉</span> maya@example.com</a>
            <a href="#shared-media"><span>▧</span> 12 shared files</a>
        </div>
        <div class="profile-note"><span>ABOUT</span><p>Designing thoughtful digital products and collecting good questions.</p></div>
    </aside>
</div>