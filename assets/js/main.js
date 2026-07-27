const STORAGE_KEYS = {
    users: 'awesomeGroupUsers',
    session: 'awesomeGroupSession',
    records: 'awesomeGroupRecords',
    messages: 'awesomeGroupMessages',
    flash: 'awesomeGroupFlash'
};

const DEMO_ACCOUNT = {
    id: 1,
    fullName: 'System Administrator',
    email: 'admin@awesomegroup.test',
    password: 'Awesome123!'
};

const DEFAULT_RECORDS = [
    { id: 1, department: 'Technology', serviceName: 'Cloud Solutions', manager: 'Ama Mensah', email: 'technology@awesomegroup.test', status: 'Active' },
    { id: 2, department: 'Consulting', serviceName: 'Business Advisory', manager: 'Kojo Asare', email: 'consulting@awesomegroup.test', status: 'Active' },
    { id: 3, department: 'Operations', serviceName: 'Customer Success', manager: 'Efua Owusu', email: 'support@awesomegroup.test', status: 'Pending' }
];

function readStorage(key, fallback) {
    try {
        const value = JSON.parse(localStorage.getItem(key));
        return value ?? fallback;
    } catch {
        return fallback;
    }
}

function writeStorage(key, value) {
    localStorage.setItem(key, JSON.stringify(value));
}

function initializeStorage() {
    if (!localStorage.getItem(STORAGE_KEYS.users)) {
        writeStorage(STORAGE_KEYS.users, [DEMO_ACCOUNT]);
    }
    if (!localStorage.getItem(STORAGE_KEYS.records)) {
        writeStorage(STORAGE_KEYS.records, DEFAULT_RECORDS);
    }
}

function getSession() {
    return readStorage(STORAGE_KEYS.session, null);
}

function setFlash(type, message) {
    writeStorage(STORAGE_KEYS.flash, { type, message });
}

function showFlash() {
    const flash = readStorage(STORAGE_KEYS.flash, null);
    if (!flash) return;

    localStorage.removeItem(STORAGE_KEYS.flash);
    const element = document.createElement('div');
    element.className = `flash ${flash.type}`;
    element.setAttribute('role', 'status');
    element.textContent = flash.message;
    document.body.appendChild(element);
}

function renderSiteChrome() {
    const session = getSession();
    const page = document.body.dataset.page;
    const header = document.querySelector('[data-site-header]');
    const footer = document.querySelector('[data-site-footer]');

    const active = (name) => page === name ? 'active' : '';

    if (header) {
        header.className = 'site-header';
        header.innerHTML = `
            <a class="brand" href="index.html" aria-label="Awesome Group home">
                <span class="brand-mark">A</span>
                <span>Awesome<span>Group</span></span>
            </a>
            <button class="menu-toggle" type="button" aria-label="Open navigation" aria-expanded="false">☰</button>
            <nav class="site-nav" aria-label="Main navigation">
                <a class="${active('home')}" href="index.html">Home</a>
                <a class="${active('about')}" href="about.html">Company</a>
                <a class="${active('contact')}" href="contact.html">Contact</a>
                <a class="${active('popups')}" href="popups.html">Pop-ups</a>
                ${session ? `
                    <a class="${active('dashboard')}" href="dashboard.html">Records</a>
                    <a class="nav-button" href="#" data-logout>Log out</a>
                ` : `
                    <a class="${active('login')}" href="login.html">Log in</a>
                    <a class="nav-button" href="register.html">Register</a>
                `}
            </nav>
        `;
    }

    if (footer) {
        footer.className = 'site-footer';
        footer.innerHTML = `
            <div>
                <a class="brand footer-brand" href="index.html"><span class="brand-mark">A</span><span>Awesome<span>Group</span></span></a>
                <p>Smart systems. Human results.</p>
            </div>
            <div>
                <strong>Explore</strong>
                <a href="about.html">Our company</a>
                <a href="contact.html">Contact us</a>
                <a href="popups.html">JavaScript demo</a>
            </div>
            <div>
                <strong>Information system</strong>
                <a href="login.html">Staff login</a>
                <a href="register.html">Create account</a>
                <a href="dashboard.html">Manage records</a>
            </div>
            <p class="copyright">&copy; ${new Date().getFullYear()} Awesome Group Company.</p>
        `;
    }

    const menuButton = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('.site-nav');
    menuButton?.addEventListener('click', () => {
        const isOpen = navigation.classList.toggle('open');
        menuButton.setAttribute('aria-expanded', String(isOpen));
    });

    document.querySelector('[data-logout]')?.addEventListener('click', (event) => {
        event.preventDefault();
        localStorage.removeItem(STORAGE_KEYS.session);
        setFlash('success', 'You have been logged out safely.');
        window.location.href = 'login.html';
    });
}

function initializeSlider() {
    const slideImage = document.querySelector('#slider-image');
    if (!slideImage) return;

    const slides = [
        ['assets/images/slide-1.svg', 'Ideas into impact'],
        ['assets/images/slide-2.svg', 'Teams in sync'],
        ['assets/images/slide-3.svg', 'Smarter decisions'],
        ['assets/images/slide-4.svg', 'Secure by design'],
        ['assets/images/slide-5.svg', 'Growth that lasts']
    ];
    let current = 0;

    const showSlide = (index) => {
        current = (index + slides.length) % slides.length;
        slideImage.classList.add('changing');
        window.setTimeout(() => {
            slideImage.src = slides[current][0];
            slideImage.alt = `${slides[current][1]} illustration`;
            document.querySelector('#slide-title').textContent = slides[current][1];
            document.querySelector('#slide-number').textContent = `${String(current + 1).padStart(2, '0')} / 05`;
            slideImage.classList.remove('changing');
        }, 220);
    };

    document.querySelector('.slider-arrow.next')?.addEventListener('click', () => showSlide(current + 1));
    document.querySelector('.slider-arrow.previous')?.addEventListener('click', () => showSlide(current - 1));
    window.setInterval(() => showSlide(current + 1), 5000);
}

function initializePopups() {
    const result = document.querySelector('#popup-result');
    if (!result) return;

    document.querySelectorAll('[data-popup]').forEach((button) => {
        button.addEventListener('click', () => {
            if (button.dataset.popup === 'alert') {
                alert('Welcome to Awesome Group Company!');
                result.textContent = 'Alert acknowledged successfully.';
            }
            if (button.dataset.popup === 'confirm') {
                const accepted = confirm('Would you like Awesome Group to contact you?');
                result.textContent = accepted ? 'You selected OK.' : 'You selected Cancel.';
            }
            if (button.dataset.popup === 'prompt') {
                const name = prompt('What is your name?', '');
                result.textContent = name ? `Hello, ${name}! It is awesome to meet you.` : 'The prompt was cancelled or left empty.';
            }
        });
    });
}

function initializeContactForm() {
    const form = document.querySelector('#contact-form');
    if (!form) return;

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const data = Object.fromEntries(new FormData(form));
        const messages = readStorage(STORAGE_KEYS.messages, []);
        messages.push({ ...data, id: Date.now(), submittedAt: new Date().toISOString() });
        writeStorage(STORAGE_KEYS.messages, messages);
        form.reset();
        const success = document.querySelector('#contact-success');
        success.hidden = false;
        success.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
}

function initializeLogin() {
    const form = document.querySelector('#login-form');
    if (!form) return;
    if (getSession()) {
        window.location.replace('dashboard.html');
        return;
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const email = form.email.value.trim().toLowerCase();
        const password = form.password.value;
        const users = readStorage(STORAGE_KEYS.users, []);
        const user = users.find((item) => item.email === email && item.password === password);
        const error = document.querySelector('#login-error');

        if (!user) {
            error.textContent = 'The email address or password is incorrect.';
            error.hidden = false;
            return;
        }

        writeStorage(STORAGE_KEYS.session, { id: user.id, fullName: user.fullName, email: user.email });
        setFlash('success', `Welcome back, ${user.fullName}!`);
        window.location.href = 'dashboard.html';
    });
}

function initializeRegistration() {
    const form = document.querySelector('#register-form');
    if (!form) return;

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const fullName = form.fullName.value.trim();
        const email = form.email.value.trim().toLowerCase();
        const password = form.password.value;
        const error = document.querySelector('#register-error');
        const users = readStorage(STORAGE_KEYS.users, []);

        if (fullName.length < 2 || password.length < 8) {
            error.textContent = 'Enter a valid name and use at least 8 characters for the password.';
            error.hidden = false;
            return;
        }
        if (users.some((user) => user.email === email)) {
            error.textContent = 'An account with that email address already exists.';
            error.hidden = false;
            return;
        }

        users.push({ id: Date.now(), fullName, email, password });
        writeStorage(STORAGE_KEYS.users, users);
        setFlash('success', 'Account created successfully. You can now sign in.');
        window.location.href = 'login.html';
    });
}

function initializeDashboard() {
    const dashboard = document.querySelector('#dashboard-app');
    if (!dashboard) return;

    const session = getSession();
    if (!session) {
        setFlash('error', 'Please log in to access the records dashboard.');
        window.location.replace('login.html');
        return;
    }

    const form = document.querySelector('#record-form');
    const searchForm = document.querySelector('#search-form');
    const tableBody = document.querySelector('#records-body');
    const count = document.querySelector('#record-count');
    const greeting = document.querySelector('#dashboard-greeting');
    const formTitle = document.querySelector('#record-form-title');
    const submitButton = document.querySelector('#record-submit');
    const cancelButton = document.querySelector('#cancel-edit');
    let editingId = null;
    let searchTerm = '';

    const hour = new Date().getHours();
    const period = hour < 12 ? 'morning' : hour < 18 ? 'afternoon' : 'evening';
    greeting.textContent = `Good ${period}, ${session.fullName.split(' ')[0]}.`;

    const escapeHtml = (value) => String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');

    const renderRecords = () => {
        const records = readStorage(STORAGE_KEYS.records, []);
        const term = searchTerm.toLowerCase();
        const visibleRecords = records
            .filter((record) => [record.department, record.serviceName, record.manager]
                .some((value) => value.toLowerCase().includes(term)))
            .sort((a, b) => b.id - a.id);

        count.textContent = visibleRecords.length;
        if (!visibleRecords.length) {
            tableBody.innerHTML = '<tr><td colspan="6" class="empty-state">No matching records found.</td></tr>';
            return;
        }

        tableBody.innerHTML = visibleRecords.map((record) => `
            <tr>
                <td>#${String(record.id).padStart(3, '0')}</td>
                <td><strong>${escapeHtml(record.department)}</strong></td>
                <td>${escapeHtml(record.serviceName)}<small>${escapeHtml(record.email)}</small></td>
                <td>${escapeHtml(record.manager)}</td>
                <td><span class="status ${record.status.toLowerCase()}">${escapeHtml(record.status)}</span></td>
                <td class="actions">
                    <button type="button" data-edit="${record.id}">Edit</button>
                    <button type="button" data-delete="${record.id}">Delete</button>
                </td>
            </tr>
        `).join('');
    };

    const resetForm = () => {
        editingId = null;
        form.reset();
        formTitle.textContent = 'Create new record';
        submitButton.textContent = 'Add record →';
        cancelButton.hidden = true;
    };

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const records = readStorage(STORAGE_KEYS.records, []);
        const record = {
            department: form.department.value.trim(),
            serviceName: form.serviceName.value.trim(),
            manager: form.manager.value.trim(),
            email: form.email.value.trim(),
            status: form.status.value
        };

        if (editingId === null) {
            records.push({ id: Date.now(), ...record });
            showInlineFlash('success', 'New record added successfully.');
        } else {
            const index = records.findIndex((item) => item.id === editingId);
            if (index !== -1) records[index] = { ...records[index], ...record };
            showInlineFlash('success', 'Record updated successfully.');
        }
        writeStorage(STORAGE_KEYS.records, records);
        resetForm();
        renderRecords();
    });

    tableBody.addEventListener('click', (event) => {
        const editButton = event.target.closest('[data-edit]');
        const deleteButton = event.target.closest('[data-delete]');
        const records = readStorage(STORAGE_KEYS.records, []);

        if (editButton) {
            const id = Number(editButton.dataset.edit);
            const record = records.find((item) => item.id === id);
            if (!record) return;
            editingId = id;
            form.department.value = record.department;
            form.serviceName.value = record.serviceName;
            form.manager.value = record.manager;
            form.email.value = record.email;
            form.status.value = record.status;
            formTitle.textContent = 'Edit company data';
            submitButton.textContent = 'Update record →';
            cancelButton.hidden = false;
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        if (deleteButton && confirm('Delete this record permanently?')) {
            const id = Number(deleteButton.dataset.delete);
            writeStorage(STORAGE_KEYS.records, records.filter((item) => item.id !== id));
            if (editingId === id) resetForm();
            renderRecords();
            showInlineFlash('success', 'Record deleted successfully.');
        }
    });

    searchForm.addEventListener('submit', (event) => {
        event.preventDefault();
        searchTerm = searchForm.search.value.trim();
        renderRecords();
    });

    cancelButton.addEventListener('click', resetForm);
    renderRecords();
}

function showInlineFlash(type, message) {
    document.querySelector('.flash')?.remove();
    const element = document.createElement('div');
    element.className = `flash ${type}`;
    element.setAttribute('role', 'status');
    element.textContent = message;
    document.body.appendChild(element);
}

document.addEventListener('DOMContentLoaded', () => {
    initializeStorage();
    renderSiteChrome();
    showFlash();
    initializeSlider();
    initializePopups();
    initializeContactForm();
    initializeLogin();
    initializeRegistration();
    initializeDashboard();
});

