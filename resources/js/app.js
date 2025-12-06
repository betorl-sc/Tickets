import './bootstrap';

// Trix Editor - Limpiar después de enviar
document.addEventListener('livewire:init', () => {
    Livewire.on('trix-reset', () => {
        document.querySelectorAll('input[type="hidden"][name="message"]').forEach(input => {
            const editor = input.nextElementSibling;
            if (editor && editor.tagName === 'TRIX-EDITOR' && editor.editor) {
                editor.editor.loadHTML('');
                input.value = '';
            }
        });
    });
});
