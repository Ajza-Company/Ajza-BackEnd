# Postman Testing Guide - Ajza App

## 🚀 Base URL
```
http://127.0.0.1:8000
```

## 📋 API Structure

Your Ajza application has 4 main API groups:
- **Frontend APIs** (`/api/frontend`) - Customer-facing APIs
- **Supplier APIs** (`/api/supplier`) - Supplier management
- **Admin APIs** (`/api/admin`) - Admin panel
- **General APIs** (`/api/general`) - Shared functionality

---

## 🔐 Authentication

### Bearer Token
Most protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer {your_token}
```

### Content-Type
```
Content-Type: application/json
Accept: application/json
```

---

## 🧪 Test Endpoints by Category

### 1. Public Endpoints (No Auth Required)

#### General APIs
```
GET /api/general/categories
GET /api/general/countries
GET /api/general/cities
GET /api/general/cities/{city_id}/areas
GET /api/general/terms/{name}
```

#### Frontend Public APIs
```
GET /api/frontend/locales
GET /api/frontend/car-brands
GET /api/frontend/car-brands/{car_brand}/car-models
GET /api/frontend/car-types
GET /api/frontend/slider-images
GET /api/frontend/stores
GET /api/frontend/stores/{store_id}/details
GET /api/frontend/stores/products
GET /api/frontend/stores/{store_id}/products
GET /api/frontend/stores/products/{product_id}
```

#### Authentication (No Auth Required)
```
POST /api/frontend/auth/send-otp
POST /api/frontend/auth/verify-otp
POST /api/frontend/auth/create-account
POST /api/frontend/auth/setup-account
```

---

### 2. Protected Endpoints (Require Auth)

#### Frontend Protected APIs
```
GET /api/frontend/home
GET /api/frontend/favorites
POST /api/frontend/favorites
DELETE /api/frontend/favorites/{product_id}
GET /api/frontend/addresses
POST /api/frontend/addresses
POST /api/frontend/addresses/{id}
DELETE /api/frontend/addresses/{id}
POST /api/frontend/auth/update-profile
GET /api/frontend/auth/me
GET /api/frontend/user/wallet-transactions
POST /api/frontend/stores/{store_id}/orders/create
POST /api/frontend/stores/{store_id}/orders/getInvoice
POST /api/frontend/stores/cart
GET /api/frontend/orders
GET /api/frontend/orders/{order_id}/show
POST /api/frontend/orders/{order_id}/success
POST /api/frontend/orders/{order_id}/cancel
POST /api/frontend/orders/{order_id}/submit-review
POST /api/frontend/orders/{order_id}/pay
GET /api/frontend/rep-orders
POST /api/frontend/rep-orders/create
GET /api/frontend/rep-orders/{order_id}/check-order-acceptance
GET /api/frontend/rep-orders/{order_id}/delivered
GET /api/frontend/rep-orders/{order_id}/cancel
POST /api/frontend/rep-orders/{order_id}/submit-review
```

#### Supplier APIs
```
POST /api/supplier/auth/login
GET /api/supplier/permissions
GET /api/supplier/store-details
GET /api/supplier/company-car-brands
POST /api/supplier/orders/{order_id}/take-action
GET /api/supplier/orders/{order_id}/details
GET /api/supplier/stores
POST /api/supplier/stores/create
POST /api/supplier/stores/{store_id}/update
GET /api/supplier/stores/{store_id}/transactions
GET /api/supplier/stores/{store_id}/statistics
GET /api/supplier/stores/{store_id}/orders
GET /api/supplier/stores/{store_id}/list/products
POST /api/supplier/stores/{store_id}/list/products/create
GET /api/supplier/stores/{store_id}/products
POST /api/supplier/stores/{store_id}/products/create
POST /api/supplier/stores/{store_id}/products/{product}
GET /api/supplier/stores/{store_id}/products/show/{product}
DELETE /api/supplier/stores/{store_id}/products/delete/{product}
GET /api/supplier/stores/{store_id}/offers
POST /api/supplier/stores/{store_id}/offers
DELETE /api/supplier/stores/offers/{offer_id}
GET /api/supplier/team-members
POST /api/supplier/team-members/create
POST /api/supplier/team-members/{user_id}/update
GET /api/supplier/rep-orders
GET /api/supplier/rep-orders/all
GET /api/supplier/rep-orders/{rep_order_id}/accept
POST /api/supplier/rep-orders/{rep_order_id}/track
GET /api/supplier/rep-orders/{rep_order_id}/track
GET /api/supplier/rep-orders/{rep_order_id}/get-tracks
POST /api/supplier/rep-orders/statistics
```

#### Admin APIs
```
GET /api/admin/companies
POST /api/admin/companies
DELETE /api/admin/company/{id}/delete
GET /api/admin/company/{id}/active
POST /api/admin/stores/{id}/update
POST /api/admin/stores/{id}/active
POST /api/admin/rep-sales
POST /api/admin/rep-sales/update/{id}
POST /api/admin/rep-sales/delete/{id}
GET /api/admin/rep-sales
GET /api/admin/rep-orders/{id?}
GET /api/admin/rep-chat/{id}
GET /api/admin/users
POST /api/admin/user/create
POST /api/admin/user/update/{id}
POST /api/admin/user/destroy/{id}
GET /api/admin/user/show/{id}
GET /api/admin/user/admin/permissions
POST /api/admin/user/block/{id}
POST /api/admin/user/credit/{id}
POST /api/admin/user/debit/{id}
POST /api/admin/user/sendNotification/{id}
GET /api/admin/auth/virtual-login/{user}
GET /api/admin/product
POST /api/admin/product
POST /api/admin/product/{product}
GET /api/admin/product/show/{product}
DELETE /api/admin/product/delete/{product}
POST /api/admin/activate-product/{product}
GET /api/admin/promo-codes
POST /api/admin/promo-codes
DELETE /api/admin/promo-codes/{id}
GET /api/admin/state
POST /api/admin/state
POST /api/admin/state/{state}
GET /api/admin/state/show/{state}
DELETE /api/admin/state/delete/{state}
GET /api/admin/setting
POST /api/admin/setting/create
GET /api/admin/support/chats
POST /api/admin/support/chats/{chat_id}/status
GET /api/admin/slider
POST /api/admin/slider
DELETE /api/admin/slider/{id}
GET /api/admin/categories
POST /api/admin/category/create
POST /api/admin/category/update/{id}
POST /api/admin/category/destroy/{id}
GET /api/admin/category/show/{id}
GET /api/admin/sub-categories/{category_id}
POST /api/admin/sub-category/create
POST /api/admin/sub-category/update/{id}
POST /api/admin/sub-category/destroy/{id}
GET /api/admin/sub-category/show/{id}
GET /api/admin/statistics
GET /api/admin/orders
POST /api/admin/send-notification
```

#### General Protected APIs
```
GET /api/general/v1/notifications
POST /api/general/v1/orders/{order_id}/cancel
GET /api/general/v1/products
GET /api/general/v1/rep-orders/chats
GET /api/general/v1/rep-orders/chats/{chat_id}
GET /api/general/v1/rep-orders/chats/{chat_id}/messages
POST /api/general/v1/rep-orders/chats/{chat_id}/messages
POST /api/general/v1/rep-orders/chats/{chat_id}/offers
POST /api/general/v1/rep-orders/offers/{offer}/update
GET /api/general/v1/rep-orders/invoices/{invoice}/view
GET /api/general/v1/Statistics
GET /api/general/v1/settings
POST /api/general/v1/settings
GET /api/general/v1/settings/terms
GET /api/general/v1/settings/order-settings
POST /api/general/v1/settings/multiple
POST /api/general/v1/settings/order-settings
GET /api/general/v1/settings/{key}
PUT /api/general/v1/settings/{key}
DELETE /api/general/v1/settings/{key}
GET /api/general/v1/support/chats
POST /api/general/v1/support/chats
GET /api/general/v1/support/chats/{chat_id}
POST /api/general/v1/support/chats/{chat_id}/messages
```

---

## 🧪 Quick Test Examples

### 1. Test Public Endpoints

#### Get Categories
```
GET http://127.0.0.1:8000/api/general/categories
```

#### Get Car Brands
```
GET http://127.0.0.1:8000/api/frontend/car-brands
```

#### Get Countries
```
GET http://127.0.0.1:8000/api/general/countries
```

### 2. Test Authentication

#### Send OTP
```
POST http://127.0.0.1:8000/api/frontend/auth/send-otp
Content-Type: application/json

{
    "mobile": "+966501234567"
}
```

#### Login as Admin
```
POST http://127.0.0.1:8000/api/supplier/auth/login
Content-Type: application/json

{
    "email": "store@ajza.net",
    "password": "1Alqarawi1"
}
```

#### Login as Supplier
```
POST http://127.0.0.1:8000/api/supplier/auth/login
Content-Type: application/json

{
    "email": "supplier1@ajza.net",
    "password": "password123"
}
```

### 3. Test Protected Endpoints

#### Get User Profile (with Bearer token)
```
GET http://127.0.0.1:8000/api/frontend/auth/me
Authorization: Bearer {your_token}
```

#### Get Admin Statistics
```
GET http://127.0.0.1:8000/api/admin/statistics
Authorization: Bearer {admin_token}
```

---

## 📱 Postman Collection Setup

### 1. Create Environment Variables
```
BASE_URL: http://127.0.0.1:8000
FRONTEND_TOKEN: (leave empty, will be set after login)
SUPPLIER_TOKEN: (leave empty, will be set after login)
ADMIN_TOKEN: (leave empty, will be set after login)
```

### 2. Create Folders
- **Public APIs** - No authentication required
- **Frontend APIs** - Customer APIs
- **Supplier APIs** - Supplier management
- **Admin APIs** - Admin panel
- **General APIs** - Shared functionality

### 3. Test Flow
1. **Start with public endpoints** to verify server is running
2. **Test authentication** to get tokens
3. **Test protected endpoints** using the tokens
4. **Test CRUD operations** for each module

---

## 🔍 Common Test Scenarios

### Frontend User Flow
1. Send OTP → Verify OTP → Create Account
2. Browse categories, car brands, stores
3. View products, add to favorites
4. Create orders, manage addresses
5. Track orders, submit reviews

### Supplier Flow
1. Login as supplier
2. Manage store details
3. Add/update products
4. Handle orders
5. Manage team members
6. Track rep orders

### Admin Flow
1. Login as admin
2. Manage companies, stores, users
3. View statistics
4. Manage categories, products
5. Handle support chats
6. Send notifications

---

## 🚨 Troubleshooting

### Common Issues
1. **401 Unauthorized** - Missing or invalid Bearer token
2. **422 Validation Error** - Check request body format
3. **404 Not Found** - Check URL and route parameters
4. **500 Server Error** - Check Laravel logs

### Debug Tips
1. Check `storage/logs/laravel.log` for errors
2. Use Laravel Telescope for API debugging
3. Verify database connection
4. Check middleware configuration

---

## 📊 Expected Responses

### Success Response Format
```json
{
    "status": true,
    "message": "Success message",
    "data": {
        // Response data
    }
}
```

### Error Response Format
```json
{
    "status": false,
    "message": "Error message",
    "errors": {
        // Validation errors
    }
}
```

---

## 🎯 Ready to Test!

Your Laravel application is running and ready for Postman testing. Start with the public endpoints to verify everything is working, then move on to authenticated endpoints using the provided credentials.

**Happy Testing! 🚀**
