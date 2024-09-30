# 🏡 AtypikHouse

AtypikHouse is a platform for renting unique accommodations (tree houses, yurts, floating cabins, etc.) in France and Europe. This project was developed to meet the needs of **AtypikHouse** by using modern web technologies to provide a smooth, secure, and high-performance user experience.

## 🌟 Main Features

- 🔍 **Browse Properties**: View different types of available accommodations with detailed information (property type, capacity, price, amenities, photos, etc.).
- 📝 **User Account Management**:
  - User registration and login (for both owners and tenants).
  - Profile management (update personal information, manage properties, etc.).
  - View booking history.
- 🏠 **Property Management**:
  - Add, edit, and delete properties for owners.
  - Plan availability and manage property bookings.
  - Manage available amenities.
- 📅 **Booking System**:
  - Book available accommodations.
  - Secure online payments via APIs like PayPal and Stripe (Sandbox mode for testing).
  - Cancel bookings if the date has not passed yet.
- 💬 **Reviews & Comments**:
  - Tenants can leave comments and reviews about their stay (during or after their booking).
- 📲 **Mobile Application**:
  - Developed as a **Progressive Web App (PWA)**, accessible from any mobile browser with a native-like experience (offline mode, push notifications).

## 🛠️ Technologies Used

### Front-end
- **Tailwind CSS** and **SCSS** for styling and creating responsive and modern interfaces.
- **DaisyUI** for pre-styled components built on top of Tailwind CSS to accelerate development.
- **Vite** for fast bundling and development.

### Back-end
- **Laravel**: PHP framework for managing business logic and implementing a clean MVC architecture.
- **Livewire**: Adding dynamic and reactive features without the need for a heavy JavaScript framework.
- **SQLite**: Lightweight database management for handling user data, properties, and bookings.

### Mobile Application
- **Progressive Web App (PWA)**: Developed using Laravel as the backend framework, the PWA offers a complete mobile experience while remaining accessible through a web browser.

### Tools & Deployment
- **Git** and **GitLab**: Source code management and CI/CD.
- **Composer**: PHP dependency manager.
- **Pest**: Testing framework for Laravel (unit, integration, and functional tests).
- **Linux**: Secure and reliable server for hosting and deployment.

## 🚀 Installation and Configuration

To run this project locally, ensure you have the following prerequisites:

1. **PHP 8.1+**
2. **Composer**
3. **Node.js & npm**
4. **SQLite**

### Installation Steps

1. Clone the repository:

    ```bash
    git clone https://github.com/your-username/atypikhouse.git
    cd atypikhouse
    ```

2. Install PHP and JavaScript dependencies:

    ```bash
    composer install
    npm install
    ```

3. Copy the `.env.example` file to `.env` and configure your environment (database, API keys, etc.):

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Create and configure the SQLite database:

    ```bash
    touch database/database.sqlite
    php artisan migrate --seed
    ```

5. Compile the assets with Vite:

    ```bash
    npm run dev
    ```

6. Start the development server:

    ```bash
    php artisan serve
    ```

You can now access the application at [http://localhost:8000](http://localhost:8000).
