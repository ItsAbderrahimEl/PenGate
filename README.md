# 🛡️ PenGate

> A collaborative **forum platform for penetration testers** to share knowledge, techniques, and experience — built with **Laravel**, **Vue.js**, and **Inertia.js**,
> running in a **Dockerized environment** powered by **Laravel Sail**..

---

## 🚀 Overview

**PenGate** is a modern web application designed for cybersecurity professionals and enthusiasts.  
It provides a community-driven space where penetration testers can:

- 🧠 Share findings, tutorials, and write-ups
- 💬 Discuss exploitation techniques and tools
- 🤝 Collaborate and learn from each other
- 🏆 Build a strong knowledge base for the ethical hacking community

---

[Github Code](https://github.com/ItsAbderrahimEl/PenGate)

---


## 🚧 Project Status

> ⚙️ **PenGate is currently in development (build state).**  
> Some features and UI components are still under construction, but the core structure and environment are ready to use.

---

## 🧩 Tech Stack

| Layer | Technology |
|-------|-------------|
| **Backend** | [Laravel 11](https://laravel.com) |
| **Frontend** | [Vue.js 3](https://vuejs.org) |
| **Bridge** | [Inertia.js](https://inertiajs.com) |
| **Styling** | [Tailwind CSS](https://tailwindcss.com) |
| **Editor** | [TipTap](https://tiptap.dev) |
| **State Management** | [Pinia](https://pinia.vuejs.org) |
| **Database** | MySQL / Redis |

---

## ⚙️ Installation

Clone the repository:

```bash
git clone https://github.com/ItsAbderrahimEl/pengate.git
cd pengate
```

Install dependencies:

```bash
composer install && sail npm run build
```

Build and start the Docker containers:

```bash
sail build --no-cache
sail up -d
```

Optimize the application:

```bash
sail artisan optimize
```

My app — or better yet, *our app* — should now be running at [http://localhost](http://localhost) 🚀
