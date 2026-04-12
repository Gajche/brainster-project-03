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
        field.classList.remove("field-invalid", "field-valid");
        const existing = field.parentNode.querySelector('[data-error="true"]');
        if (existing) existing.remove();
    }

    function markValid(field) {
        clearError(field);
        field.classList.add("field-valid");
    }

    // PDF file chooser
    const chooseFileBtn = document.getElementById("choose-file-btn");
    if (chooseFileBtn && portfolioInput) {
        chooseFileBtn.addEventListener("click", function (e) {
            e.preventDefault();
            portfolioInput.click();
        });

        portfolioInput.addEventListener("change", function () {
            if (portfolioInput.files.length === 0) {
                if (fileLabel) fileLabel.textContent = "Choose File";
                return;
            }
            const file = portfolioInput.files[0];

            if (
                !file.name.toLowerCase().endsWith(".pdf") ||
                file.type !== "application/pdf"
            ) {
                showError(portfolioInput, "Само PDF датотеки се дозволени.");
                if (fileLabel) fileLabel.textContent = "Choose File";
                portfolioInput.value = "";
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                showError(
                    portfolioInput,
                    "Датотеката не смее да биде поголема од 10MB.",
                );
                if (fileLabel) fileLabel.textContent = "Choose File";
                portfolioInput.value = "";
                return;
            }
            markValid(portfolioInput);
            if (fileLabel) fileLabel.textContent = file.name;
        });
    }

    // Validate all fields
    function validateAll() {
        let valid = true;

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

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailInput || !emailRegex.test(emailInput.value.trim())) {
            if (emailInput) showError(emailInput, "Внесете валидна е-пошта.");
            valid = false;
        } else {
            markValid(emailInput);
        }

        if (phoneInput && phoneInput.value.trim() !== "") {
            const phoneRegex = /^[0-9\+\-\s\(\)]{6,20}$/;
            if (!phoneRegex.test(phoneInput.value.trim())) {
                showError(phoneInput, "Внесете валиден телефонски број.");
                valid = false;
            } else {
                markValid(phoneInput);
            }
        }

        if (socialInput && socialInput.value.trim() !== "") {
            try {
                new URL(socialInput.value.trim());
                markValid(socialInput);
            } catch {
                showError(
                    socialInput,
                    "Внесете валиден URL за социјалната мрежа.",
                );
                valid = false;
            }
        }

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

    // Submit
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        if (!validateAll()) {
            // Tailwind class already highlights errors, just scroll to the first one
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

    // Blur validation
    [nameInput, surnameInput, emailInput, areaInput, messageInput].forEach(
        function (field) {
            if (!field) return;
            field.addEventListener("blur", function () {
                validateAll();
            });
        },
    );
});
