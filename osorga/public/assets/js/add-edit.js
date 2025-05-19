(() => {
    // === Tag Manager ===
    const tagDisplay = document.getElementById('tag-display');
    const tagSelect = document.getElementById('tag-select');
    const tagsInput = document.getElementById('tags-input');
    let tags = [];

    function renderTags() {
        tagDisplay.innerHTML = '';
        tags.forEach((tag, index) => {
            const badge = document.createElement('span');
            badge.className = 'badge bg-secondary d-flex align-items-center';
            badge.innerHTML = `
        ${tag}
        <button type="button" class="btn-close btn-close-white btn-sm ms-2" data-index="${index}" aria-label="Eliminar"></button>
      `;
            tagDisplay.appendChild(badge);
        });
        tagsInput.value = tags.join(',');
    }

    tagSelect.addEventListener('change', () => {
        const selected = tagSelect.value;

        if (selected === '__custom') {
            const custom = prompt("Ingrese la etiqueta personalizada:");
            if (custom && custom.trim() !== '' && !tags.includes(custom.trim())) {
                tags.push(custom.trim());
                renderTags();
            }
        } else if (selected && !tags.includes(selected)) {
            tags.push(selected);
            renderTags();
        }

        tagSelect.value = '';
    });

    tagDisplay.addEventListener('click', e => {
        if (e.target.classList.contains('btn-close')) {
            const index = e.target.dataset.index;
            tags.splice(index, 1);
            renderTags();
        }
    });

    // === Image Preview + Clear ===
    function handleImageInput(inputId, previewId, clearId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const clear = document.getElementById(clearId);

        input.addEventListener('change', () => {
            const file = input.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    clear.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        clear.addEventListener('click', () => {
            input.value = '';
            preview.src = '';
            preview.style.display = 'none';
            clear.style.display = 'none';
        });
    }

    handleImageInput('foto1', 'preview1', 'clear1');
    handleImageInput('foto2', 'preview2', 'clear2');

    // === Form Submit (Safe Binding) ===
    const form = document.getElementById('item-form');
    if (!form.dataset.handlerAttached) {
        form.dataset.handlerAttached = 'true';

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log("[1] Form submitted, preparing FormData...");

            const formData = new FormData(form);

            try {
                const foto1 = document.getElementById('foto1').files[0];
                const foto2 = document.getElementById('foto2').files[0];

                if (foto1) formData.set('foto1', foto1);
                if (foto2) formData.set('foto2', foto2);

                console.log("[2] Images attached to FormData (if any)");

                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData
                });

                console.log("[3] Response received");

                if (response.ok) {
                    const text = await response.text();
                    console.log("[4] Server response OK:", text);

                    alert("Artículo registrado");
                    form.reset();
                    tags = [];
                    renderTags();

                    ['preview1', 'preview2'].forEach(id => {
                        const img = document.getElementById(id);
                        if (img) {
                            img.src = '';
                            img.style.display = 'none';
                        }
                    });

                    ['clear1', 'clear2'].forEach(id => {
                        const btn = document.getElementById(id);
                        if (btn) btn.style.display = 'none';
                    });

                } else {
                    console.error("[!] Server error status:", response.status);
                    const errorText = await response.text();
                    console.error("Server message:", errorText);
                    alert("No se pudo registrar el artículo, intente de nuevo más tarde");
                }

            } catch (err) {
                console.error("[X] Unexpected error during submission:", err);
                alert("No se pudo registrar el artículo, intente de nuevo más tarde");
            }
        });
    }
})();