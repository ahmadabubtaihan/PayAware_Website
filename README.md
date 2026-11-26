<div align="center">

  <h1>💳 PayAware - Smart Debt & Installment Management System</h1>
  
  <p>
    <strong>Your digital partner for organizing financial obligations securely and efficiently in Palestine.</strong>
  </p>

  <p>
    <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
    <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
    <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
    <img src="https://img.shields.io/badge/Localization-EN%20%7C%20AR-success?style=for-the-badge" alt="Bilingual" />
    <img src="https://img.shields.io/badge/License-MIT-blue?style=for-the-badge" alt="License" />
  </p>
</div>

---

## 📖 Overview

**PayAware** is a comprehensive, bilingual (Arabic & English) web application tailored for the Palestinian market to streamline and digitize debt and installment management between **Creditors** (shops, service providers, small businesses) and **Debtors** (individuals/customers). 

Built to replace traditional paper-based tracking and stressful manual follow-ups, PayAware provides real-time tracking, automated FIFO payment distribution, credit trust scoring, and smart reminders to ensure transparency and financial stability for all parties.

---

## ✨ Key Features

### 🏢 For Creditors (Businesses & Shops)
* **Interactive Analytics Dashboard:** Real-time overview of total issued debts, collected repayments, active accounts, and monthly performance charts.
* **Debtor Credit Check (Exclusive Feature):** Search any user's credit history across the platform using their unique 6-digit Account ID or phone number before issuing new credit to prevent fraud.
* **Smart FIFO Repayment Engine:** Automatically distributes incoming payments across the debtor's oldest active debts first (First-In, First-Out) and updates statuses dynamically.
* **Automated & Manual Smart Warnings:** Send friendly payment reminders or late-payment alerts directly to debtors with customizable delay triggers.
* **Company Profile & Marketing Feed:** Publish promotional offers, updates, and installment discounts directly to customers.
* **Comprehensive Financial Reports:** Detailed transaction logs, risk-level categorization (Low, Medium, High), and CSV/Print export capabilities.

### 👤 For Debtors (Individuals)
* **Unified Debt Portfolio:** Track all financial obligations across different stores/providers in one clean dashboard.
* **Credit Trust Score & Clearance Certificates:** Maintain a high credit score through timely payments and generate official, electronically verified **Clearance Certificates (براءة ذمة)**.
* **Built-in Installment Calculator:** Plan future purchases by calculating monthly installments based on total amount, down payment, and duration.
* **Full Transaction History:** Filter and review every issued debt and recorded payment with complete transparency.

### 🛡️ For System Administrators
* **Platform Oversight:** Monitor platform growth, active companies, and total user metrics.
* **Company Verification:** Approve, suspend, or manage registered business accounts.
* **Roles & Permissions Matrix:** Granular access control for Admins, Support Agents, and Creditors.
* **System Logs & Backups:** Security auditing and automated/manual database backup management.

### 🌐 Core System Capabilities
* **Full Bilingual Support (RTL/LTR):** Seamless switching between **Arabic** and **English** across the entire UI.
* **Real-time In-App Messaging:** Direct chat interface between creditors and debtors with file/image sharing capabilities.
* **Instant Notifications:** Live activity alerts for new debts, received payments, and warnings.

---

## 🛠️ Tech Stack

* **Backend:** PHP 8.2+, Laravel 12.x
* **Frontend:** Blade Templates, Tailwind CSS, Alpine.js / Vanilla JS, Chart.js, Lucide Icons
* **Database:** SQLite / MySQL (Eloquent ORM)
* **Authentication & Security:** Laravel Auth, Role-Based Access Control (Middleware), CSRF Protection

---

## 🚀 Installation & Local Setup

Follow these steps to run the project locally on your machine:

### 1. Clone the Repository
```bash
git clone [https://github.com/ahmadabubtaihan/PayAware_Website.git](https://github.com/ahmadabubtaihan/PayAware_Website.git)
cd PayAware_Website
