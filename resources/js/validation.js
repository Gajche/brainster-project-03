document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("artist-application-form");
    if (!form) return;

    const nameInput = document.getElementById("name");
    const surnameInput = document.getElementById("surname");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phone");
    const socialInput = document.getElementById("social_media");
    const areaInput = document.getElementById("collaboration_area");
    const messageInput = document.getElementById("message");
    const portfolioInput = document.getElementById("portfolio");
    const portfolioUrlInput = document.getElementById("portfolio_url");
    const fileLabel = document.getElementById("file-label");
    const submitBtn = document.getElementById("submit-btn");

    // Tailwind-based error helpers
    function showError(field, msg) {
        clearError(field);
        field.classList.add("field-invalid");
        const div = document.createElement("div");
        div.className = "field-error-msg";
        div.setAttribute("data-error", "true");
        div.textContent = msg;
        field.parentNode.appendChild(div);
    }

    function clearError(field) {
        if (!field) return;
        field.classList.remove("field-invalid", "field-valid");
        const existing = field.parentNode.querySelector('[data-error="true"]');
        if (existing) existing.remove();
    }

    function markValid(field) {
        clearError(field);
        field.classList.add("field-valid");
    }

    // File chooser logic for PDF, DOC, DOCX
    const chooseFileBtn = document.getElementById("choose-file-btn");
    if (chooseFileBtn && portfolioInput) {
        chooseFileBtn.addEventListener("click", function (e) {
            e.preventDefault();
            portfolioInput.click();
        });

        portfolioInput.addEventListener("change", function () {
            if (portfolioInput.files.length === 0) {
                if (fileLabel) fileLabel.textContent = "Одбери фајл";
                clearError(portfolioInput);
                return;
            }
            const file = portfolioInput.files[0];
            const fileName = file.name.toLowerCase();

            const isAllowed =
                fileName.endsWith(".pdf") ||
                fileName.endsWith(".doc") ||
                fileName.endsWith(".docx");

            if (!isAllowed) {
                showError(
                    portfolioInput,
                    "Дозволени се PDF, DOC и DOCX датотеки.",
                );
                if (fileLabel) fileLabel.textContent = "Одбери фајл";
                portfolioInput.value = "";
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                showError(
                    portfolioInput,
                    "Датотеката не смее да биде поголема од 2MB.",
                );
                if (fileLabel) fileLabel.textContent = "Одбери фајл";
                portfolioInput.value = "";
                return;
            }

            markValid(portfolioInput);
            if (fileLabel) fileLabel.textContent = file.name;
            if (portfolioUrlInput) clearError(portfolioUrlInput);
        });
    }

    // Validate all fields
    function validateAll() {
        let valid = true;

        // Name & Surname
        if (!nameInput || nameInput.value.trim().length < 2) {
            if (nameInput)
                showError(nameInput, "Внесете го вашето име (мин. 2 знаци).");
            valid = false;
        } else {
            markValid(nameInput);
        }

        if (!surnameInput || surnameInput.value.trim().length < 2) {
            if (surnameInput)
                showError(surnameInput, "Внесете го вашето презиме.");
            valid = false;
        } else {
            markValid(surnameInput);
        }

        // Email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailInput || !emailRegex.test(emailInput.value.trim())) {
            if (emailInput) showError(emailInput, "Внесете валидна е-пошта.");
            valid = false;
        } else {
            markValid(emailInput);
        }

        // Portfolio Logic
        const hasFile = portfolioInput && portfolioInput.files.length > 0;
        const hasUrl =
            portfolioUrlInput && portfolioUrlInput.value.trim().length > 0;

        // Only validate URL format if something is typed
        if (hasUrl) {
            try {
                new URL(portfolioUrlInput.value.trim());
                markValid(portfolioUrlInput);
            } catch {
                showError(portfolioUrlInput, "Внесете валиден линк (URL).");
                valid = false;
            }
        } else {
            clearError(portfolioUrlInput);
        }

        // Keep file marked valid if one is selected, otherwise clear
        if (hasFile) {
            markValid(portfolioInput);
        } else {
            // Only clear if there isn't already an error from the "change" listener
            if (!portfolioInput.classList.contains("field-invalid")) {
                clearError(portfolioInput);
            }
        }

        // Collaboration Area & Message
        if (!areaInput || areaInput.value.trim().length < 3) {
            if (areaInput)
                showError(areaInput, "Внесете ја областа на соработка.");
            valid = false;
        } else {
            markValid(areaInput);
        }

        if (!messageInput || messageInput.value.trim().length < 10) {
            if (messageInput)
                showError(
                    messageInput,
                    "Оставете кратка порака (мин. 10 знаци).",
                );
            valid = false;
        } else {
            markValid(messageInput);
        }

        return valid;
    }

    // Submit Handler
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        if (!validateAll()) {
            const firstError = form.querySelector(".field-invalid");
            if (firstError)
                firstError.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            return;
        }
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = "Се испраќа...";
        }
        form.submit();
    });

    // Real-time validation on blur
    [
        nameInput,
        surnameInput,
        emailInput,
        areaInput,
        messageInput,
        portfolioUrlInput,
    ].forEach(function (field) {
        if (!field) return;
        field.addEventListener("blur", function () {
            validateAll();
        });
    });
});
