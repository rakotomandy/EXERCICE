$(function() {
    var $searchInput = $('#conversation-search');
    var $conversations = $('.conversation');
    var $composer = $('.composer');
    var $messageInput = $composer.find('input[name="message"]');
    var $messageArea = $('.message-area');

    $searchInput.on('input', function() {
        var query = $.trim($(this).val()).toLowerCase();

        $conversations.each(function() {
            var matches = query === '' || $(this).text().toLowerCase().indexOf(query) !== -1;
            $(this).toggle(matches);
        });
    });

    $composer.on('submit', function(event) {
        var message = $.trim($messageInput.val());

        event.preventDefault();
        if (!message) {
            return;
        }

        var $row = $('<div>', { class: 'message-row sent' });
        var $stack = $('<div>', { class: 'message-stack' });
        var $meta = $('<span>', { class: 'message-name', text: 'You ' });
        var $time = $('<time>', { text: 'now' });
        var $bubble = $('<div>', { class: 'message-bubble', text: message });

        $meta.append($time);
        $stack.append($meta, $bubble);
        $row.append($stack).appendTo($messageArea);
        $messageInput.val('').trigger('focus');
        $messageArea.stop().animate({ scrollTop: $messageArea[0].scrollHeight }, 300);
    });
});