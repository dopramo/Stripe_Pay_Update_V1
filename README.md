# 🚀 Stripe Payment Integration in PHP

A complete beginner-friendly Stripe payment system built with PHP. This solution includes QR code support, PDF invoice generation, payment status tracking, and email notifications — all wrapped in a simple and clean workflow.

---

## 📦 Features

* ✅ Stripe Checkout integration
* 📩 Email delivery via Gmail SMTP
* 🧾 PDF invoice creation (Dompdf)
* 🔐 Webhook handling for payment updates
* 📊 MySQL storage of all payment records
* 📷 Auto-generated QR code for payment URL
* 🧪 Works with Stripe test cards

---

## 🧱 Project Structure

```
StripePayUpdate/
├── index.php             # Payment input form
├── checkout.php          # Creates session, QR, invoice, email
├── webhook.php           # Stripe webhook listener
├── success.php           # Payment confirmation page
├── invoices/             # Stores generated PDF invoices
├── vendor/               # Composer libraries (Stripe, DomPDF, PHPMailer, QRCode)
```

---

## 🔧 Prerequisites

Before you begin:

* PHP >= 7.4
* MySQL / phpMyAdmin
* Composer ([https://getcomposer.org/](https://getcomposer.org/))
* Stripe Account ([https://stripe.com/](https://stripe.com/))
* Gmail Account (with App Password)
* [ngrok](https://ngrok.com/) for local testing

---

## ⚙️ Installation & Setup

### 1️⃣ Clone the Project

```bash
git clone https://github.com/yourname/StripePayUpdate.git
cd StripePayUpdate
```

### 2️⃣ Install Dependencies

```bash
composer require stripe/stripe-php phpmailer/phpmailer dompdf/dompdf endroid/qr-code
```

### 3️⃣ Create MySQL Database

**Create `Stripe_Pay` database**, then run:

```sql
CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reference_no VARCHAR(255),
  email VARCHAR(255),
  amount DECIMAL(10,2),
  stripe_session_id VARCHAR(255),
  status ENUM('pending', 'paid', 'canceled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 4️⃣ Configure `.php` Files

Update the following in `checkout.php` and `webhook.php`:

* Stripe Secret Key
* Gmail SMTP credentials
* MySQL DB connection
* Webhook Secret (from Stripe dashboard)

### 5️⃣ Prepare Invoices Folder

```bash
mkdir -p /var/www/html/StripePayUpdate/invoices
chmod -R 777 /var/www/html/StripePayUpdate/invoices
```

### 6️⃣ Setup Stripe Webhook

Use `ngrok` if testing locally:

```bash
ngrok http 80
```

Use the generated URL:

```
https://your-ngrok-id.ngrok.io/webhook.php
```

On Stripe Dashboard:

* Go to **Developers → Webhooks** → Add Endpoint
* Select events:

  * `checkout.session.completed`
  * `checkout.session.expired`
* Paste Webhook Secret into `webhook.php`

---

## 💳 Usage Flow

1. User fills email + amount on `index.php`
2. Stripe payment link and QR code sent via email
3. PDF invoice sent with payment details
4. After payment:

   * Stripe updates DB via `webhook.php`
   * Final PDF receipt emailed with payment status

---

## 💡 Customization Ideas

| Feature         | How To Customize                               |
| --------------- | ---------------------------------------------- |
| Currency        | Change `'currency' => 'usd'` in `checkout.php` |
| Logo / Branding | Edit PDF HTML and email body                   |
| Email Templates | Customize `$mail->Body` and add styling        |
| QR Style        | Use advanced Endroid\QrCode options            |
| Frontend        | Style `index.php` with Bootstrap or Tailwind   |

---

## 🧪 Stripe Test Cards

* Card: `4242 4242 4242 4242`
* Exp: Any future date
* CVC: Any 3 digits

[More Test Cards ➜](https://stripe.com/docs/testing)

---

## 📬 Support & Contributions

Feel free to [open an issue](https://github.com/yourname/StripePayUpdate/issues) or [submit a pull request](https://github.com/yourname/StripePayUpdate/pulls) for improvements!

---

## 📜 License

MIT License. Use it freely in commercial or personal projects.

---

> Built with ❤️ for developers by \Pramod Madushan
