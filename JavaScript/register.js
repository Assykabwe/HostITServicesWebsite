document.addEventListener("DOMContentLoaded", function () {
    // =============================
    // Register Form
    // =============================
    const registerForm = document.getElementById("registerForm");
    if (registerForm) {
        const nameInput = document.getElementById("registerName");
        const emailInput = document.getElementById("registerEmail");
        const passwordInput = document.getElementById("registerPassword");
        const confirmInput = document.getElementById("confirmPassword");

        const nameError = document.getElementById("nameError");
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");
        const confirmError = document.getElementById("confirmError");

        const showPasswordsCheckbox = document.getElementById('showRegisterPasswords');

        showPasswordsCheckbox?.addEventListener('change', () => {
            const type = showPasswordsCheckbox.checked ? 'text' : 'password';
            passwordInput.type = type;
            confirmInput.type = type;
        });

        nameInput?.addEventListener("input", () => {
            nameError.textContent =
                nameInput.value.trim().length > 0 && nameInput.value.trim().length < 10
                    ? "Full name must be at least 10 characters."
                    : "";
        });

        emailInput?.addEventListener("input", () => {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            emailError.textContent =
                emailInput.value.trim() && !emailRegex.test(emailInput.value)
                    ? "Please enter a valid email address."
                    : "";
        });

        passwordInput?.addEventListener("input", () => {
            const pass = passwordInput.value;
            const hasLength = pass.length >= 9;
            const hasUpper = /[A-Z]/.test(pass);
            const hasNumber = /[0-9]/.test(pass);
            const hasSpecial = /[!@#$%^&*]/.test(pass);

            passwordError.textContent =
                pass && !(hasLength && hasUpper && hasNumber && hasSpecial)
                    ? "Password must be at least 9 characters and include uppercase, number, and special character."
                    : "";

            confirmError.textContent =
                confirmInput.value && confirmInput.value !== pass
                    ? "Passwords do not match."
                    : "";
        });

        confirmInput?.addEventListener("input", () => {
            confirmError.textContent =
                confirmInput.value !== passwordInput.value
                    ? "Passwords do not match."
                    : "";
        });

        registerForm.addEventListener("submit", (e) => {
            let hasError = false;

            if (nameInput.value.trim().length > 0 && nameInput.value.trim().length < 10) {
                nameError.textContent = "Full name must be at least 10 characters.";
                hasError = true;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value.trim() !== "" && !emailRegex.test(emailInput.value)) {
                emailError.textContent = "Please enter a valid email address.";
                hasError = true;
            }

            const pass = passwordInput.value;
            if (
                pass.trim() !== "" &&
                (pass.length < 9 ||
                    !/[A-Z]/.test(pass) ||
                    !/[0-9]/.test(pass) ||
                    !/[!@#$%^&*]/.test(pass))
            ) {
                passwordError.textContent =
                    "Password must be at least 9 characters and include uppercase, number, and special char.";
                hasError = true;
            }

            if (confirmInput.value.trim() !== "" && confirmInput.value !== pass) {
                confirmError.textContent = "Passwords do not match.";
                hasError = true;
            }

            if (hasError) e.preventDefault();
        });
    }

    // =============================
    // Login Form
    // =============================
    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        const loginEmail = document.getElementById("loginEmail");
        const loginPassword = document.getElementById("loginPassword");
        const loginEmailError = document.getElementById("loginEmailError");
        const loginPasswordError = document.getElementById("loginPasswordError");
        const togglePassword = document.getElementById("showLoginPassword");

        togglePassword?.addEventListener("change", () => {
            loginPassword.type = togglePassword.checked ? "text" : "password";
        });

        loginEmail?.addEventListener("input", () => {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            loginEmailError.textContent =
                loginEmail.value.trim() && !emailRegex.test(loginEmail.value)
                    ? "Please enter a valid email address."
                    : "";
        });

        loginPassword?.addEventListener("input", () => {
            loginPasswordError.textContent =
                loginPassword.value.trim() ? "" : "Password is required.";
        });

        loginForm.addEventListener("submit", (e) => {
            let hasError = false;

            loginEmailError.textContent = "";
            loginPasswordError.textContent = "";

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!loginEmail.value.trim()) {
                loginEmailError.textContent = "Email is required.";
                hasError = true;
            } else if (!emailRegex.test(loginEmail.value.trim())) {
                loginEmailError.textContent = "Please enter a valid email address.";
                hasError = true;
            }

            if (!loginPassword.value.trim()) {
                loginPasswordError.textContent = "Password is required.";
                hasError = true;
            }

            if (hasError) e.preventDefault();
        });
    }

    // =============================
    // Checkout Account Toggle
    // =============================
    const createAccountBtn = document.getElementById("create-account-btn");
    const alreadyRegisteredBtn = document.getElementById("already-registered-btn");
    const fullAccountForm = document.getElementById("full-account-form");
    const existingLoginSection = document.getElementById("existing-login-section");

    createAccountBtn?.addEventListener("click", () => {
        fullAccountForm.style.display = "block";
        existingLoginSection.style.display = "none";
        createAccountBtn.style.display = "none";
        alreadyRegisteredBtn.style.display = "inline-block";
    });

    alreadyRegisteredBtn?.addEventListener("click", () => {
        fullAccountForm.style.display = "none";
        existingLoginSection.style.display = "block";
        alreadyRegisteredBtn.style.display = "none";
        createAccountBtn.style.display = "inline-block";
    });

    // =============================
    // Complete Order & Payment Popup
    // =============================
    const completeOrderForm = document.getElementById("complete-order-form");
    const paymentPopup = document.getElementById("payment-popup");
    const paymentInfo = document.getElementById("payment-info");
    const closePopupBtn = document.getElementById("close-popup");
    const notesInput = document.getElementById("additional-notes");
    const paymentRadios = document.querySelectorAll('input[name="payment-method"]');
    const hiddenPaymentInput = document.getElementById("selected-payment-method");
    const hiddenNotesInput = document.getElementById("order-notes");

    let currentCartTotal = "0.00";
    let currentOrderId = "XXXX";

    // ---------- Show Payment Instructions ----------
    function showPaymentInstructions(paymentMethod, orderId = "XXXX", totalAmount = null) {
    // Use live cart total from user_script.js if available
    const cartTotal = window.currentCartTotal || totalAmount || "0.00";
    const totalFormatted = `R${parseFloat(cartTotal).toFixed(2)}`;
        let html = "";

        if (paymentMethod === "bank-transfer") {
            html = `
                <h4>Bank Transfer Instructions</h4>
                <p>Please transfer <strong>${totalFormatted}</strong> to one of the following banks:</p>
                <ul>
                    <li><strong>FNB Bank:</strong>Check Account: <span class="copy-text">63180904237</span> <button class="copy-btn">Copy</button>, Branch Code: 25655, Reference: Order ${orderId}</li>
                    <li><strong>Capitec Bank:</strong>Savings Account: <span class="copy-text">9876543217</span> <button class="copy-btn">Copy</button>, Branch Code: 57002, Reference: Order ${orderId}</li>
                    <li><strong>ABSA Bank:</strong>Check Account: <span class="copy-text">1122334458</span> <button class="copy-btn">Copy</button>, Branch Code: 87003, Reference: Order ${orderId}</li>
                </ul>
                <div class="total-amount-box"><strong>Total Due:</strong> <span>${totalFormatted}</span></div>
            `;
        } else if (paymentMethod === "mail-in") {
            html = `
                <h4>Mail-In Payment Instructions</h4>
                <p>Mail a cheque or money order for <strong>${totalFormatted}</strong> to:</p>
                <address>
                    Host IT Services<br>
                    2 Alwin Street Brooklyn<br>
                    Capetown, South Africa
                    +27 78 554 3814
                    info@hostitservices.com
                </address>
                <p>Include your Order ID: <strong>${orderId}</strong> with your payment.</p>
                <div class="total-amount-box"><strong>Total Due:</strong> <span>${totalFormatted}</span></div>
            `;
        }

        paymentInfo.innerHTML = html;
        paymentPopup.style.display = "block";
        paymentPopup.scrollIntoView({ behavior: "smooth" });
    }

    // ---------- Update Payment Info on Radio Change ----------
    paymentRadios.forEach(radio => {
        radio.addEventListener("change", () => {
            showPaymentInstructions(radio.value, currentOrderId, currentCartTotal);
        });
    });

    // ---------- Show default payment info ----------
    const defaultRadio = document.querySelector('input[name="payment-method"]:checked');
    if (defaultRadio) {
        showPaymentInstructions(defaultRadio.value, currentOrderId, currentCartTotal);
    }

    // ---------- Form Submission ----------
    completeOrderForm?.addEventListener("submit", function (e) {
        e.preventDefault();

        const userId = document.getElementById("user_id")?.value;
        if (!userId) {
            alert("Please login or register before completing the order.");
            return;
        }

        const selectedRadio = completeOrderForm.querySelector('input[name="payment-method"]:checked');
        if (!selectedRadio) {
            alert("Payment method is required.");
            return;
        }

        const paymentMethod = selectedRadio.value;
        const notes = notesInput?.value || "";

        hiddenPaymentInput.value = paymentMethod;
        hiddenNotesInput.value = notes;

        const formData = new FormData(completeOrderForm);

        fetch("../UserPages/process_order.php", {
            method: "POST",
            body: formData
        })
        .then(async res => {
            const text = await res.text();
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    currentOrderId = data.order_id;
                    currentCartTotal = data.total_amount; // use the correct total from server
                    showPaymentInstructions(paymentMethod, currentOrderId, currentCartTotal);
                } else {
                    alert(data.message || "There was an error completing your order.");
                }
            } catch (err) {
                console.error("Invalid JSON response:", text);
                alert("Server returned an invalid response. Check console for details.");
            }
        })
        .catch(err => {
            console.error("Fetch error:", err);
            alert("Error completing order. Check console for details.");
        });
    });

    // ---------- Copy buttons in popup ----------
    paymentInfo.addEventListener("click", (e) => {
        if (e.target.classList.contains("copy-btn")) {
            const copyTextElem = e.target.previousElementSibling;
            if (copyTextElem) {
                navigator.clipboard.writeText(copyTextElem.textContent)
                    .then(() => {
                        e.target.textContent = "Copied!";
                        setTimeout(() => e.target.textContent = "Copy", 1500);
                    })
                    .catch(err => console.error("Copy failed:", err));
            }
        }
    });

    // ---------- Close popup ----------
    closePopupBtn?.addEventListener("click", () => {
        paymentPopup.style.display = "none";
    });

    // --- Auto-update total in payment popup when cart total changes ---
    setInterval(() => {
        const popup = document.getElementById("payment-popup");
        if (popup?.style.display === "block") {
            const totalSpan = popup.querySelector(".total-amount-box span");
            if (totalSpan && window.currentCartTotal) {
                totalSpan.textContent = `R${parseFloat(window.currentCartTotal).toFixed(2)}`;
            }
        }
    }, 1000);


});


