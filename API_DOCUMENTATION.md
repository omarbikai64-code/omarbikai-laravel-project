# Blog CMS REST API (v1)

Public RESTful API for managing Posts, Categories, and Tags, secured via token authentication.

---

## Setup & Running the Application

1. **Run Database Migrations & Seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

2. **Generate an API Token**
   Run the artisan command to generate an active API key:
   ```bash
   php artisan api-key:generate "Postman Client"
   ```
   *Copy the generated key output (e.g. `sk_abcdef123456...`).*

3. **Start local server**
   ```bash
   php artisan serve
   ```

---

## Authentication

All API endpoints require a valid API key sent via header:

- **Option A (Header):** `X-API-TOKEN: <your_token>`
- **Option B (Bearer):** `Authorization: Bearer <your_token>`

If the header is missing or invalid, the API returns:
- **HTTP 401 Unauthorized**

---

## Endpoints Overview

### **1. Posts (`/api/v1/posts`)**
| Method | Endpoint | Description | Status Code |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/posts` | List posts (Paginated). Supports `?category_id=` and `?tag_id=` filters. | `200 OK` |
| `GET` | `/api/v1/posts/{id}` | Get single post details. | `200 OK` / `404 Not Found` |
| `POST` | `/api/v1/posts` | Create new post. | `201 Created` / `422 Validation Error` |
| `PUT/PATCH` | `/api/v1/posts/{id}` | Update existing post. | `200 OK` / `422 Validation Error` / `404 Not Found` |
| `DELETE` | `/api/v1/posts/{id}` | Delete post and detach tags. | `200 OK` / `404 Not Found` |

### **2. Categories (`/api/v1/categories`)**
| Method | Endpoint | Description | Status Code |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/categories` | List all categories with `posts_count`. | `200 OK` |
| `POST` | `/api/v1/categories` | Create new category. | `201 Created` / `422 Validation Error` |
| `DELETE` | `/api/v1/categories/{id}` | Delete category. | `200 OK` / `404 Not Found` |

### **3. Tags (`/api/v1/tags`)**
| Method | Endpoint | Description | Status Code |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/tags` | List all tags. | `200 OK` |
| `POST` | `/api/v1/tags` | Create new tag. | `201 Created` / `422 Validation Error` |

---

## Postman Collection

Import `postman_collection.json` into Postman or Insomnia. Set the `API_TOKEN` environment variable to your generated token.