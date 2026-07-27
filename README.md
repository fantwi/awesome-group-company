# Awesome Group Company Information System

A framework-free static website built with HTML5, CSS, Flexbox, CSS Grid, and
JavaScript. It can be deployed directly to Vercel, Netlify, GitHub Pages, or any
static web host.

## Features

- Responsive home, company, contact, and JavaScript demonstration pages
- Four group-member profile cards
- Scrolling announcement text
- Automatic and manually controlled five-image slider
- Alert, confirm, and prompt demonstrations
- Browser-based registration and login
- Protected records dashboard
- Add, retrieve/search, update, and delete company records
- Responsive Flexbox and CSS Grid layouts

## Run locally

No build process is required. Open `index.html` directly or use a basic static
server:

```bash
npx serve .
```

Then open the local URL displayed in the terminal.

## Demo login

- Email: `admin@awesomegroup.test`
- Password: `Awesome123!`

## Data storage

Because this version contains no server-side language, accounts, login state,
contact messages, and company records are stored in the browser's `localStorage`.
Data remains after refresh but is specific to that browser and device. Clearing
site data resets it. This is suitable for an academic demonstration, not real
production authentication.

## Add group photographs

Place photographs in `assets/images/members/`, replace each avatar block in
`index.html` with an image, and use the existing `.avatar` container. Example:

```html
<div class="avatar">
    <img src="assets/images/members/member-1.jpg"
         alt="Photograph of Ebenezer Nana Annan">
</div>
```

Add this styling if it is not already present:

```css
.avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  display: block;
}
```

## Project structure

```text
assets/css/style.css    Complete non-minified stylesheet
assets/js/main.js       Navigation, slider, pop-ups, authentication, and CRUD
assets/images/          Slider illustrations and optional member photos
docs/                   Code explanations
index.html              Homepage and group profiles
about.html              Company information
contact.html            Contact form
popups.html             JavaScript pop-up demonstration
login.html              Login
register.html           Registration
dashboard.html          Protected CRUD information system
```

