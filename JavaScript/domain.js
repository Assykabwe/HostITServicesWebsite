document.addEventListener("DOMContentLoaded", function () {
    // =========================
    // DOM ELEMENTS
    // =========================
    const links = document.querySelectorAll(".sidebar ul li a");
    const continueLink = document.querySelector(".continue-shopping a");
    const webHostingSection = document.querySelector("#web_hosting");
    const sections = Array.from(document.querySelectorAll(".content-section"));
    const profileBox = document.querySelector(".profile-detail");
    const mainSearchForm = document.querySelector(".search-form");
    const userIcon = document.querySelector(".user-icon");
    const checkoutBtn = document.querySelector("#checkout-btn");
    const reviewSection = document.querySelector("#view_cart");
    const checkoutSection = document.querySelector("#checkout");
    const cartContent = document.querySelector('.cart-content');
    const emptyMessage = document.querySelector('.empty-cart-message');
    const checkoutTotalBox = document.querySelector('#checkout .total-due-box strong'); // Checkout total
    const hash = window.location.hash.substring(1);

    // =========================
    // UTILS: show exactly one section
    // =========================
    function showSection(id, options = { scroll: true }) {
        sections.forEach(s => {
            s.classList.remove("active");
            s.style.display = "none";
        });
        links.forEach(l => l.classList.remove("active"));

        const target = document.getElementById(id);
        if (!target) return;

        target.classList.add("active");
        target.style.display = "block";

        const sidebarLink = Array.from(links).find(l => l.getAttribute("data-target") === id);
        if (sidebarLink) sidebarLink.classList.add("active");

        if (options.scroll) {
            target.scrollIntoView({ behavior: "smooth" });
        }
    }

    // Initialize visibility
    (function initSections() {
        let foundActive = false;
        sections.forEach(s => {
            if (s.classList.contains("active") && !foundActive) {
                s.style.display = "block";
                foundActive = true;
            } else {
                s.classList.remove("active");
                s.style.display = "none";
            }
        });
        if (!foundActive && webHostingSection) {
            showSection("web_hosting", { scroll: false });
        }
    })();

    // =========================
    // SIDEBAR NAVIGATION
    // =========================
    links.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const target = this.getAttribute("data-target");
            if (!target) return;
            showSection(target);
        });
    });

    // =========================
    // USER ICON DROPDOWN
    // =========================
    userIcon?.addEventListener("click", () => {
        profileBox?.classList.toggle("active");
        mainSearchForm?.classList.remove("active");
    });

    // =========================
    // CONTINUE SHOPPING LINK
    // =========================
    continueLink?.addEventListener("click", (e) => {
        e.preventDefault();
        showSection("web_hosting");
    });

    // =========================
    // CHECKOUT BUTTON IN REVIEW & CHECKOUT
    // =========================
    checkoutBtn?.addEventListener("click", (e) => {
        e.preventDefault();
        showSection("checkout", { scroll: true }); // smooth scroll
    });

    // =========================
    // HANDLE HASH IN URL
    // =========================
    if (hash) {
        const targetSection = document.getElementById(hash);
        if (targetSection) showSection(hash);
    }

    // =========================
    // FETCH AND RENDER CART
    // =========================
    function fetchCart() {
        fetch('get_cart.php')
            .then(res => res.json())
            .then(data => {
                renderCart(data.cart || []);
            })
            .catch(err => {
                console.error("Error fetching cart:", err);
                renderCart([]);
            });
    }

    fetchCart();

    function updateCheckoutButtonState(cart) {
        if (!checkoutBtn) return;
        if (cart && cart.length > 0) {
            checkoutBtn.removeAttribute("disabled");
            checkoutBtn.classList.add("active");
            if (emptyMessage) emptyMessage.style.display = "none";
        } else {
            checkoutBtn.setAttribute("disabled", "true");
            checkoutBtn.classList.remove("active");
            if (emptyMessage) emptyMessage.style.display = "block";
        }
    }

    function renderCart(cart, highlightId = null) {
        if (!cartContent || !emptyMessage) return;

        cartContent.innerHTML = '';
        const subtotalElem = document.querySelector('.order-summary .summary-line .price');
        const totalElem = document.querySelector('.order-summary .totals-line .price');

        let subtotal = 0;

        if (!cart || cart.length === 0) {
            emptyMessage.style.display = 'block';
            if (subtotalElem) subtotalElem.textContent = "R0.00 ZAR";
            if (totalElem) totalElem.textContent = "R0.00 ZAR";
            if (checkoutTotalBox) checkoutTotalBox.textContent = "R0.00 ZAR";
            updateCheckoutButtonState([]);
            return;
        }

        emptyMessage.style.display = 'none';

        cart.forEach((item, index) => {
            const unitPrice = parseFloat(item.price);
            const quantity = parseInt(item.quantity || 1);
            const lineTotal = unitPrice * quantity;
            subtotal += lineTotal;

            const div = document.createElement('div');
            div.classList.add('plan-card');
            if (highlightId && item.id == highlightId) div.classList.add('highlight');

            div.innerHTML = `<div class="product-col">
                    ${item.category_name} - ${item.service_title}
                    ${item.domain_name ? `<br><small>Domain: ${item.domain_name}</small>` : ''}
                    <div class="quantity-controls">
                        <button class="decrease-btn" data-index="${index}">-</button>
                        <span class="quantity">${quantity}</span>
                        <button class="increase-btn" data-index="${index}">+</button>
                    </div>
                </div>
                <div class="price-col">
                    R${unitPrice.toFixed(2)} ZAR &times; ${quantity} = <strong>R${lineTotal.toFixed(2)} ZAR</strong>
                    <button class="remove-btn" data-index="${index}">Remove</button>
                </div>`;
            cartContent.appendChild(div);
        });

        if (subtotalElem) subtotalElem.textContent = `R${subtotal.toFixed(2)} ZAR`;
        if (totalElem) totalElem.textContent = `R${subtotal.toFixed(2)} ZAR`;
        if (checkoutTotalBox) checkoutTotalBox.textContent = `R${subtotal.toFixed(2)} ZAR`;

        // Remove button handlers
        cartContent.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const index = btn.dataset.index;
                fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'index=' + index
                })
                .then(res => res.json())
                .then(data => renderCart(data.cart || []));
            });
        });

        // Quantity decrease
        cartContent.querySelectorAll('.decrease-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const index = btn.dataset.index;
                fetch('update_cart_quantity.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `index=${index}&action=decrease`
                })
                .then(res => res.json())
                .then(data => renderCart(data.cart || []));
            });
        });

        // Quantity increase
        cartContent.querySelectorAll('.increase-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const index = btn.dataset.index;
                fetch('update_cart_quantity.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `index=${index}&action=increase`
                })
                .then(res => res.json())
                .then(data => renderCart(data.cart || []));
            });
        });

        updateCheckoutButtonState(cart);
    }

    // =========================
    // DOMAIN SEARCH SECTION
    // =========================
    const tabs = document.querySelectorAll(".domain-tabs li");
    const tables = document.querySelectorAll(".domain-table");
    const domainSearchForm = document.getElementById("domainSearchForm");
    const domainInput = document.getElementById("domainNameInput");
    const continueBtn = document.getElementById("continueDomainBtn");

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            tabs.forEach(t => t.classList.remove("active"));
            tab.classList.add("active");

            const target = tab.getAttribute("data-tab");
            tables.forEach(table => {
                table.classList.toggle("active", table.id === target);
            });
        });
    });

    if (domainSearchForm) {
        domainSearchForm.addEventListener("submit", e => {
            e.preventDefault();
            const domainKeyword = domainInput.value.trim();
            if (domainKeyword === "") return alert("Enter a domain name to search!");
            document.querySelector(".domain-tables-container").style.display = "block";
        });
    }

    if (continueBtn) {
        continueBtn.addEventListener("click", () => {
            const selected = document.querySelector("input[name='domain_option']:checked");
            if (!selected) return swal("Error", "Please select a domain extension first!", "error");

            const domainName = domainInput.value.trim() + selected.value;
            const price = parseFloat(selected.dataset.price || 0);
            const pendingServiceId = sessionStorage.getItem('pendingServiceId');

            fetch("../UserPages/save_domain.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ domainName, price })
            })
            .then(async res => {
                const text = await res.text();
                try {
                    return JSON.parse(text);
                } catch (err) {
                    console.error("Invalid JSON from save_domain.php:", text);
                    swal("Error", "Could not save domain. Invalid server response.", "error");
                    throw err;
                }
            })
            .then(data => {
                if (data.success) {
                    // Add service + domain to cart if pending
                    if (pendingServiceId) {
                        sessionStorage.removeItem('pendingServiceId');
                        addServiceToCart(pendingServiceId, domainName, price);
                    }

                    swal("Success", `${domainName} and your service have been added to cart.`, "success");
                    setTimeout(() => showSection('view_cart'), 1000);
                } else {
                    swal("Error", data.message || "Could not save domain.", "error");
                }
            })
            .catch(err => {
                console.error(err);
            });
        });
    }


    // =========================
    // ORDER BUTTONS
    // =========================
    const orderButtons = document.querySelectorAll('.order-btn');
    const registerDomainTitle = document.getElementById('registerDomainServiceName');
    const registerDomainSection = document.getElementById('register_domain');
    const requiresDomain = ["web_hosting", "website_design", "ecommerce"];

    orderButtons.forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            const serviceId = button.dataset.serviceId;
            const sectionId = button.closest('.content-section').id;
            const planTitle = button.closest('.plan-card').querySelector('h4')?.textContent || "Service";

            if (registerDomainTitle) registerDomainTitle.textContent = planTitle;

            if (requiresDomain.includes(sectionId)) {
                sessionStorage.setItem('pendingServiceId', serviceId);
                showSection('register_domain');
                swal({
                    title: "Domain Required",
                    text: "Please register a domain before adding this service to your cart.",
                    icon: "info",
                    button: "Go to Register Domain"
                });
                return;
            }

            addServiceToCart(serviceId);
        });
    });

    // =========================
    // ADD SERVICE TO CART
    // =========================
    function addServiceToCart(serviceId, domainName = null, domainPrice = 0) {
        // Always fetch cart from server after adding service
        fetch('get_service.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `service_id=${serviceId}&domain_name=${domainName || ''}&domain_price=${domainPrice}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                renderCart(data.cart || [], data.service.id);
                swal("Added!", `${data.service.service_title} added to cart.`, "success");
            } else {
                swal("Error", data.message || "Could not add to cart", "error");
            }
        })
        .catch(err => {
            console.error("Add to cart error:", err);
            swal("Error", "Something went wrong", "error");
        });
    }
    // =========================
    // ADDITIONAL NAVIGATION BUTTONS
    // =========================
    document.getElementById("transferDomainLink")?.addEventListener("click", e => {
        e.preventDefault();
        showSection("transfer_domain");
    });

    document.querySelector(".view-cart-link")?.addEventListener("click", e => {
        e.preventDefault();
        showSection("view_cart");
    });

    // =========================
    // MAILING LIST RADIO HANDLER
    // =========================
    const mailingRadios = document.querySelectorAll('input[name="mailing_list"]');
    const userEmailInput = document.getElementById('user_email');

    mailingRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            const choice = document.querySelector('input[name="mailing_list"]:checked').value;
            const email = userEmailInput.value;

            if (choice === 'yes') {
                if (!email) return; // no email to send

                fetch('subscribe_mailing_list.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `email=${encodeURIComponent(email)}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Thank you! A confirmation email has been sent to you.');
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Something went wrong while subscribing.');
                });
            } else {
                // Optional: handle "No" selection, e.g., unsubscribe logic
                console.log(`${email} chose not to join the mailing list.`);
            }
        });
    });

    //==============================
    // TRANSFER DOMAIN FORM
    // ==============================
    const transferForm = document.getElementById("transferDomainForm");
    if (transferForm) {
        transferForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const domain = document.getElementById("domain").value.trim();
            const authCode = document.getElementById("auth-code").value.trim();
            const eppCode = document.getElementById("epp-code").value.trim();

            if (!domain || !authCode || !eppCode) {
                swal("Error", "Please fill in all fields.", "error");
                return;
            }

            fetch("../UserPages/save_transfer.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    domain_name: domain,
                    auth_code: authCode,
                    epp_code: eppCode
                })
            })
            .then(async res => {
                const text = await res.text();
                try {
                    const data = JSON.parse(text);
                    return data;
                } catch (err) {
                    console.error("Server returned invalid JSON:", text);
                    swal("Server Error", "Invalid response:\n" + text, "error");
                    throw err;
                }
            })
            .then(data => {
                if (data.success) {
                    swal("Success", data.message || "Domain transfer added to cart!", "success");
                    fetchCart(); // refresh cart
                } else {
                    swal("Error", data.message || "Failed to add domain transfer.", "error");
                }
            })
            .catch(err => {
                console.error("Transfer domain fetch error:", err);
                swal("Error", "Could not process domain transfer.", "error");
            });
        });
    }
    // ===== Update cart count badge =====
    function updateCartCount(quantity = 1) {
        const cartCountElem = document.querySelector("#cartCount");
        if (cartCountElem) {
            let currentCount = parseInt(cartCountElem.innerText || "0");
            cartCountElem.innerText = currentCount + quantity;
        }
    }

    function updateCartUI(service) {
        // Example: update cart count badge
        const cartCountElem = document.querySelector("#cartCount");
        let count = parseInt(cartCountElem.innerText || "0");
        count += 1;
        cartCountElem.innerText = count;
    }

});
