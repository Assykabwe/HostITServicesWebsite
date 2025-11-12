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
        let lastServiceId = null; // Track previous service to group domain

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

            // Highlight domain under its service visually
            let label = `${item.category_name} - ${item.service_title}`;
            if (item.domain_name) {
                // Only mark it as a “sub-item” if the previous item is same service
                label = `&nbsp;&nbsp;&nbsp; Domain: ${item.domain_name}`;
            }

            div.innerHTML = `<div class="product-col">
                ${label}
                ${item.billing_cycle ? `<br><small>Billing: ${item.billing_cycle}</small>` : ''}
                <div class="quantity-controls">
                    <button class="decrease-btn" data-index="${index}">-</button>
                    <span class="quantity">${quantity}</span>
                    <button class="increase-btn" data-index="${index}">+</button>
                </div>
            </div>
            <div class="price-col">
                <strong>R${lineTotal.toFixed(2)} ZAR</strong>
                <button class="remove-btn" data-index="${index}">Remove</button>
            </div>`;
            cartContent.appendChild(div);

            lastServiceId = item.id;
        });

        if (subtotalElem) subtotalElem.textContent = `R${subtotal.toFixed(2)} ZAR`;
        if (totalElem) totalElem.textContent = `R${subtotal.toFixed(2)} ZAR`;
        if (checkoutTotalBox) checkoutTotalBox.textContent = `R${subtotal.toFixed(2)} ZAR`;

        window.currentCartTotal = subtotal.toFixed(2);

        // --- Attach event handlers ---
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


    // Separate function to attach cart buttons
    function attachCartButtons() {
        cartContent.querySelectorAll('.remove-btn').forEach(btn => {
            btn.onclick = () => {
                const index = btn.dataset.index;
                fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'index=' + index
                })
                .then(res => res.json())
                .then(data => renderCart(data.cart || []));
            };
        });
        cartContent.querySelectorAll('.decrease-btn').forEach(btn => {
            btn.onclick = () => {
                const index = btn.dataset.index;
                fetch('update_cart_quantity.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `index=${index}&action=decrease`
                })
                .then(res => res.json())
                .then(data => renderCart(data.cart || []));
            };
        });
        cartContent.querySelectorAll('.increase-btn').forEach(btn => {
            btn.onclick = () => {
                const index = btn.dataset.index;
                fetch('update_cart_quantity.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `index=${index}&action=increase`
                })
                .then(res => res.json())
                .then(data => renderCart(data.cart || []));
            };
        });
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
            if (!pendingServiceId) {
                swal("Error", "No pending service found. Please choose a service first.", "error");
                return;
            }

            // --- Fetch service info to display in popup before adding ---
            fetch('get_service.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `service_id=${pendingServiceId}`
            })
            .then(res => res.json())
            .then(serviceData => {
                if (serviceData.status !== 'success' || !serviceData.service) {
                    swal("Error", "Could not fetch service info.", "error");
                    return;
                }

                const serviceTitle = serviceData.service.service_title || "Service";
                const categoryName = serviceData.service.category_name || "Category";
                const servicePrice = parseFloat(serviceData.service.price || 0);

                // --- Show confirmation popup with breakdown ---
                swal({
                    title: "Confirm Selection",
                    html: `
                        <p><strong>Service:</strong> ${categoryName} - ${serviceTitle}</p>
                        <p><strong>Domain:</strong> ${domainName}</p>
                        <p><strong>Service Price:</strong> R${servicePrice.toFixed(2)}</p>
                        <p><strong>Domain Price:</strong> R${price.toFixed(2)}</p>
                        <p><strong>Total:</strong> R${(servicePrice + price).toFixed(2)}</p>
                    `,
                    icon: "info",
                    buttons: {
                        cancel: "Cancel",
                        confirm: { text: "Add to Cart", value: true }
                    }
                }).then(addConfirmed => {
                    if (!addConfirmed) return;

                    // --- Save domain first ---
                    fetch("../UserPages/save_domain.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ domainName: domainName, price: price })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) {
                            swal("Error", data.message || "Could not save domain.", "error");
                            return;
                        }

                        // --- Add service to cart ---
                        addServiceToCart(pendingServiceId);

                        // --- Add domain only to cart ---
                        addServiceToCart(null, domainName, price);

                        sessionStorage.removeItem('pendingServiceId');

                        swal("Success", `${domainName} and your service have been added to cart.`, "success");
                        setTimeout(() => showSection('view_cart'), 1000);
                    })
                    .catch(err => {
                        console.error(err);
                        swal("Error", "Could not save domain.", "error");
                    });
                });
            })
            .catch(err => {
                console.error(err);
                swal("Error", "Could not fetch service info.", "error");
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
    function addServiceToCart(serviceId = null, domainName = null, domainPrice = 0) {
        const body = new URLSearchParams();
        if (serviceId) body.append('service_id', serviceId);
        if (domainName) body.append('domain_name', domainName);
        if (domainPrice) body.append('domain_price', domainPrice);

        fetch('get_service.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: body.toString()
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                renderCart(data.cart || []);
                swal("Added!", `${domainName ? domainName : data.cart[0].service_title} added to cart.`, "success");
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

    // ==============================
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
                    return JSON.parse(text);
                } catch (err) {
                    console.error("Server returned invalid JSON:", text);
                    swal("Server Error", "Invalid response:\n" + text, "error");
                    throw err;
                }
            })
            .then(data => {
                if (data.success) {
                    // Automatically add Domain Transfer (ID=30) to cart
                    addServiceToCart(30, domain, parseFloat(data.service?.price || 500));

                    swal("Success", `Domain transfer for ${domain} added to cart!`, "success");
                    setTimeout(() => showSection('view_cart'), 800); // Go to cart after short delay
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

    /////////////////////desable and active renew button in home page///////////
    document.querySelectorAll(".renew-btn.disabled").forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();
            const tooltip = btn.getAttribute("title") || "Renew not available yet";
            swal("Notice", tooltip, "info");
        });
    });

});
