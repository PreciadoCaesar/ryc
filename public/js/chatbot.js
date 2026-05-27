// R&C Consulting Chatbot
(function() {
    console.log('Chatbot initialized');
    
    // Simple chatbot functionality
    window.startChat = function() {
        const phone = window.RC_CURSOS?.wspGeneral || '51950883155';
        const message = encodeURIComponent('Hola, necesito información sobre los cursos');
        window.open(`https://wa.me/${phone}?text=${message}`, '_blank');
    };
    
    // Auto-initialize after page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Chatbot ready');
        });
    } else {
        console.log('Chatbot ready');
    }
})();
