# Fintrack

A modern **Expense Tracker & Personal Finance App** built with **Laravel, Vue.js, and Inertia.js**.

Fintrack empowers individuals and families to track their spending, manage budgets, and gain financial insights through clean dashboards and reports.

---

## Features

### \[ ] `/` – Dashboard

- [ ] Summary cards: total income, total expenses, net balance
- [ ] Recent transactions table with quick actions
- [ ] Spending breakdown by category (pie chart)
- [ ] Monthly trends visualization (bar/line chart)
- [ ] Budget progress bars with alerts when limits are exceeded

---

### \[ ] `/transactions` – Transactions Management

- [ ] Transaction list with filters (date range, type, category, amount)
- [ ] Create new transaction with fields: type (income/expense), amount, category, date, notes, tags, receipt upload
- [ ] Edit and delete transactions with confirmation modals
- [ ] Bulk delete or export transactions as CSV
- [ ] Receipt preview in modal or sidebar

---

### \[ ] `/budgets` – Budgeting System

- [ ] List budgets with progress indicators (e.g., “Food: \$320/\$500”)
- [ ] Create and edit budgets (set amount, category, and duration: monthly/weekly)
- [ ] Visual alerts when budget exceeds threshold
- [ ] Budget history to track past performance

---

### \[ ] `/categories` – Categories Management

- [ ] Default categories (Food, Rent, Transport, Salary, etc.) seeded automatically
- [ ] User-defined categories (create, edit, delete)
- [ ] Separate income and expense categories
- [ ] Category usage stats (transactions count and total spent/earned)

---

### \[ ] `/profile` – User Profile & Settings

- [ ] Update name, email, password, and avatar
- [ ] Currency preference (USD, EUR, etc.)
- [ ] Dark/light mode toggle
- [ ] Delete account option

---

### Future Enhancements (Optional)

- Recurring transactions (e.g., monthly rent, salary)
- Shared accounts / multi-user mode for family or group tracking
- Notifications & reminders (email or in-app) for bills and budgets
- Export reports as PDF/CSV
- AI-powered insights for spending habits
- PWA support for offline tracking

---

## Tech Stack

- **Language**: PHP, TypeScript
- **Framework**: Laravel, Vue.js, Inertia.js
- **Database**: SQLite
- **Styling**: Tailwind CSS, shadcn/vue

---

## Getting Started

### Prerequisites

- PHP 8.4+
- Composer
- SQLite
- [Bun](https://bun.sh/) (instead of npm/yarn)

### Installation

1. **Clone the repository**

```bash
git clone https://github.com/mt-shihab26/fintrack.git
cd fintrack
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install TypeScript dependencies**

```bash
bun install
```

4. **Environment setup**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Database setup**

```bash
php artisan migrate
php artisan db:seed # optional
```

6. **Link public storage**

```bash
php artisan storage:link
```

7. **Run development servers**

```bash
composer dev
```

8. **Open the app**
   Visit [http://localhost:8000](http://localhost:8000)

---

## License

This project is licensed under the MIT License – see the [LICENSE](LICENSE) file for details.
