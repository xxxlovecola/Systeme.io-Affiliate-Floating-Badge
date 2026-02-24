# 🚀 Systeme.io Affiliate Floating Badge

A professional, lightweight WordPress plugin designed specifically for **Systeme.io affiliates**. Display a stunning floating badge in the corner of your website that opens a "drop-up" menu with your hardcoded affiliate offers.

![Version](https://img.shields.io/badge/version-1.0.1-blue)
![WordPress](https://img.shields.io/badge/WordPress-5.0+-blueviolet)
![License](https://img.shields.io/badge/License-GPL--2.0-green)

---

## ✨ Features

*   **⚡ Zero Configuration Links**: All Systeme.io links are predefined and hardcoded. You only need to enter your **Affiliate ID**.
*   **🌍 Intelligent Language Support**: Supports **English** and **French**. Switching languages automatically updates:
    *   Menu labels and link structures.
    *   Target URLs (e.g., `/fr/` vs `/en/`).
    *   Badge images.
*   **🎨 Highly Customizable**:
    *   **Built-in Badges**: Choose from professional pre-designed badges.
    *   **Custom Images**: Upload your own badge via the WordPress Media Library.
    *   **Live Preview**: See your badge selection instantly in the admin settings.
    *   **Precise Positioning**: Control corner position (Bottom Left/Right) and pixel-perfect offsets.
*   **📱 Responsive & Interactive**:
    *   **Desktop**: Seamless hover interaction to show the menu.
    *   **Mobile**: Smooth tap behavior with a configurable breakpoint.
    *   **Discreet Design**: Compact badge size (60px) that sits elegantly on your site.
*   **🎯 Visibility Control**: Choose exactly where to show your badge (Homepage, Blog Posts, or Archive pages).
*   **🚀 Clean Code**: Written in **Vanilla JS** and CSS. No jQuery, no bloat, just 100% performance.

---

## 🛠️ Installation

1.  **Download** the plugin repository as a ZIP.
2.  **Upload** it to your WordPress site via `Plugins > Add New > Upload Plugin`.
3.  **Activate** the plugin.
4.  Navigate to **Settings > Systeme.io Badge** to enter your Affiliate ID.

---

## ⚙️ How it Works

The plugin appends your `Affiliate ID` and an optional `Tracking Code` (default: `BadgeAffiliationFacile`) to all hardcoded links automatically.

**Example Generated Link:**
`https://systeme.io/fr/pricing?sa=affiliate123&tk=BadgeAffiliationFacile`

---

## 📸 Screenshots

### Admin Dashboard
Features a real-time preview of your selected badge and easy-to-use configuration fields.

### Frontend Widget
A discreet floating badge that transforms into a professional dark-themed "drop-up" menu on interaction.

---

## 👨‍💻 Developer Notes

This plugin is built for performance. It enqueues only **one CSS file** and **one JS file**, both minified-ready and extremely small. 

- **No jQuery dependency**
- **Vanilla JS dynamic DOM construction**
- **WordPress Native Settings API**

---

## 📜 License

This project is licensed under the GPL-2.0 License.

---

Created with ❤️ for the Systeme.io Affiliate Community.
